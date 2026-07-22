<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\CollaboratorBusinessDetails;
use App\Models\AdminBusinessDetails;
use App\Services\ShippoService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    protected $shippoService;

    public function __construct(ShippoService $shippoService)
    {
        $this->shippoService = $shippoService;
    }

    /**
     * Calculate shipping rates for multiple sellers
     */
    public function calculateSplitShippingRates(array $cart, array $destinationAddress): array
    {
        // Group cart items by seller
        $groupedItems = $this->groupCartBySeller($cart);
        $shippingQuotes = [];

        foreach ($groupedItems as $sellerId => $sellerItems) {
            $seller = User::find($sellerId);
            if (!$seller) continue;

            $originAddress = $this->getSellerPickupAddress($seller);
            if (!$originAddress) {
                // Include seller with no shipping available message
                $shippingQuotes[$sellerId] = [
                    'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                    'seller_id' => $sellerId,
                    'origin_address' => null,
                    'items' => $sellerItems,
                    'package_details' => $this->calculatePackageDetails($sellerItems),
                    'rates' => null, // No rates available
                    'selected_rate' => null,
                    'handling_fee' => 0,
                    'no_shipping_message' => 'No shipping available. Please contact support.',
                ];
                continue;
            }

            $packageDetails = $this->calculatePackageDetails($sellerItems);
            // Get shipping rates for this seller
            $rates = $this->getShippingRates($originAddress, $destinationAddress, $packageDetails);
            $defaultRateKey = $this->resolveDefaultRateKey($rates);

            $shippingQuotes[$sellerId] = [
                'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                'seller_id' => $sellerId,
                'origin_address' => $originAddress,
                'items' => $sellerItems,
                'package_details' => $packageDetails,
                'rates' => $rates,
                'default_rate_key' => $defaultRateKey,
                'selected_rate_key' => $defaultRateKey,
                'selected_rate' => $defaultRateKey ? $rates[$defaultRateKey] : null,
                'requires_shipping' => $packageDetails['requires_shipping'],
                // Digital-only groups (e.g. downloadable guides) ship nothing, so no
                // handling fee applies even though a zero-cost "Digital Product" rate
                // exists. A missing rate also means nothing is charged.
                'handling_fee' => ($packageDetails['requires_shipping'] && $defaultRateKey) ? $this->getSellerHandlingFee($seller) : 0,
            ];
        }

        return $shippingQuotes;
    }

    /**
     * Group cart items by seller
     */
    public function groupCartBySeller(array $cart): Collection
    {
        $groupedItems = collect();

        foreach ($cart as $lineKey => $quantity) {
            $product = Product::with('user')->find(\App\Support\CartLine::productId($lineKey));
            if (!$product) continue;

            $sellerId = $product->user_id;

            if (!$groupedItems->has($sellerId)) {
                $groupedItems->put($sellerId, []);
            }

            // Carry the line's purchase choice so downstream shipping rules (e.g.
            // free shipping for yearly Vital Boost subscriptions) apply per line.
            $meta = \App\Support\CartLine::meta($lineKey);

            $items = $groupedItems->get($sellerId);
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_key' => (string) $lineKey,
                'purchase_type' => $meta['purchase_type'],
                'plan' => $meta['plan'],
            ];
            $groupedItems->put($sellerId, $items);
        }

        return $groupedItems;
    }

    /**
     * Get seller's pickup address
     */
    private function getSellerPickupAddress(User $seller): ?array
    {
        // Handle collaborator business address
        if ($seller->role === 'collaborator') {
            $businessDetails = CollaboratorBusinessDetails::where('user_id', $seller->id)->first();
            if ($businessDetails && $this->isValidAddress($businessDetails)) {
                $address = [
                    'name' => $seller->first_name . ' ' . $seller->last_name,
                    'address_line_1' => $businessDetails->business_address,
                    'city' => $businessDetails->business_city,
                    'state' => $businessDetails->business_state,
                    'zip_code' => $businessDetails->business_zip_code,
                    'country' => $businessDetails->business_country,
                    'email' => $seller->email,
                    'phone' => $businessDetails->business_phone ?? $seller->phone,
                ];
                
                // Validate seller address if enabled
                if (config('shipping.validation.address_validation.enabled', true)) {
                    $addressValidation = app(AddressValidationService::class);
                    $validation = $addressValidation->validateAddress([
                        'address_line_1' => $address['address_line_1'],
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'zip_code' => $address['zip_code'],
                        'country' => $address['country']
                    ]);
                    
                    if (!$validation['valid']) {
                        Log::warning('Collaborator business address validation failed', [
                            'seller_id' => $seller->id,
                            'validation' => $validation
                        ]);
                        return null; // Return null if validation fails
                    }
                }
                
                return $address; // Return collaborator address
            }
        }

        // Handle admin business address
        if ($seller->role === 'admin') {
            $businessDetails = AdminBusinessDetails::where('user_id', $seller->id)->first();
            if ($businessDetails && $this->isValidAddress($businessDetails)) {
                $address = [
                    'name' => $seller->first_name . ' ' . $seller->last_name,
                    'address_line_1' => $businessDetails->business_address,
                    'city' => $businessDetails->business_city,
                    'state' => $businessDetails->business_state,
                    'zip_code' => $businessDetails->business_zip_code,
                    'country' => $businessDetails->business_country,
                    'email' => $businessDetails->business_email ?? $seller->email,
                    'phone' => $businessDetails->business_phone ?? $seller->phone,
                ];
                
                // Validate seller address if enabled
                if (config('shipping.validation.address_validation.enabled', true)) {
                    $addressValidation = app(AddressValidationService::class);
                    $validation = $addressValidation->validateAddress([
                        'address_line_1' => $address['address_line_1'],
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'zip_code' => $address['zip_code'],
                        'country' => $address['country']
                    ]);
                    
                    if (!$validation['valid']) {
                        Log::warning('Admin business address validation failed', [
                            'seller_id' => $seller->id,
                            'validation' => $validation
                        ]);
                        return null; // Return null if validation fails
                    }
                }
                
                return $address; // Return admin address
            }
        }

        // No default fallback - return null if no valid address found
        return null;
    }

    /**
     * Validate address components
     */
    private function isValidAddress($address): bool
    {
        return !empty($address->business_address) && 
               !empty($address->business_city) && 
               !empty($address->business_state) && 
               !empty($address->business_zip_code) && 
               !empty($address->business_country);
    }

    /**
     * Calculate package details (weight and dimensions)
     */
    private function calculatePackageDetails(array $items): array
    {
        $totalWeight = 0;
        $maxLength = 0;
        $maxWidth = 0;
        $maxHeight = 0;
        $requiresShipping = false;

        foreach ($items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            // Check if product requires shipping
            // If requires_shipping is explicitly set to 0/false, treat as digital product
            // Otherwise, treat as physical product that needs shipping
            if (!isset($product->requires_shipping) || $product->requires_shipping) {
                $requiresShipping = true;
                
                // Use product weight if available and > 0, otherwise use default based on product type
                $productWeight = $product->weight ?? 0;
                if ($productWeight <= 0) {
                    // Default weight estimation based on product name/type
                    if (stripos($product->name, 'book') !== false || stripos($product->name, 'guide') !== false) {
                        $productWeight = 1.0; // Books typically weigh around 1lb
                    } elseif (stripos($product->name, 'pdf') !== false || stripos($product->name, 'e-book') !== false) {
                        $productWeight = 0.1; // Digital products are very light
                    } else {
                        $productWeight = 2.0; // Default to 2lbs for other physical products
                    }
                }
                $totalWeight += $productWeight * $quantity;

                // Use product dimensions if available and > 0, otherwise use defaults
                $productLength = $product->length ?? 0;
                $productWidth = $product->width ?? 0;
                $productHeight = $product->height ?? 0;
                
                if ($productLength <= 0 || $productWidth <= 0 || $productHeight <= 0) {
                    // Default dimensions based on product type
                    if (stripos($product->name, 'book') !== false || stripos($product->name, 'guide') !== false) {
                        $defaultLength = 9; $defaultWidth = 6; $defaultHeight = 1; // Book dimensions
                    } elseif (stripos($product->name, 'pdf') !== false || stripos($product->name, 'e-book') !== false) {
                        $defaultLength = 1; $defaultWidth = 1; $defaultHeight = 0.1; // Digital products
                    } else {
                        $defaultLength = 10; $defaultWidth = 8; $defaultHeight = 4; // Default package dimensions
                    }
                    
                    $productLength = $productLength > 0 ? $productLength : $defaultLength;
                    $productWidth = $productWidth > 0 ? $productWidth : $defaultWidth;
                    $productHeight = $productHeight > 0 ? $productHeight : $defaultHeight;
                }

                // Use largest dimensions for packaging
                $maxLength = max($maxLength, $productLength);
                $maxWidth = max($maxWidth, $productWidth);
                $maxHeight = max($maxHeight, $productHeight);
            }
        }

        return [
            'weight' => $totalWeight,
            'length' => $maxLength,
            'width' => $maxWidth,
            'height' => $maxHeight,
            'requires_shipping' => $requiresShipping,
        ];
    }

    /**
     * Get shipping rates from Shippo API
     */
    private function getShippingRates(array $origin, array $destination, array $packageDetails): array
    {

        if (!$packageDetails['requires_shipping']) {
            return [
                'standard' => [
                    'amount' => 0,
                    'provider' => 'No Shipping Required',
                    'service' => 'Digital Product',
                    'estimated_days' => 0,
                ]
            ];
        }

        // Use real Shippo API call only
        try {
            $rates = $this->shippoService->getRates($origin, $destination, $packageDetails);
           
            return $rates;
        } catch (\Exception $e) {
            // Log error but don't fallback to mock rates
            \Log::error('Shippo API Error: ' . $e->getMessage());
            \Log::error('Error details: ' . $e->getTraceAsString());
            
            // Return empty array if API fails
            return [];
        }
    }

    /**
     * Mock shipping rates (replace with actual Shippo integration)
     */
    private function getMockShippingRates(array $origin, array $destination, array $packageDetails): array
    {
        return [
            'standard' => [
                'amount' => 9.96,
                'provider' => 'UPS',
                'service' => 'Ground Saver',
                'estimated_days' => 3,
            ],
            'express' => [
                'amount' => 14.51,
                'provider' => 'USPS',
                'service' => 'Priority Mail',
                'estimated_days' => 3,
            ],
            'overnight' => [
                'amount' => 63.94,
                'provider' => 'USPS',
                'service' => 'Priority Mail Express',
                'estimated_days' => 1,
            ]
        ];
    }

    /**
     * Get seller handling fee
     */
    private function getSellerHandlingFee(User $seller): float
    {
        // You can add a handling_fee column to users table or business details
        // For now, return default handling fee
        return config('shipping.default_handling_fee', 2.00);
    }

    /**
     * Pick the rate a seller is quoted on by default: standard when the carrier
     * offers it, otherwise the cheapest rate available.
     */
    public function resolveDefaultRateKey(array $rates): ?string
    {
        if (empty($rates)) {
            return null;
        }

        if (isset($rates['standard'])) {
            return 'standard';
        }

        $cheapestKey = null;
        foreach ($rates as $key => $rate) {
            if ($cheapestKey === null || (float) $rate['amount'] < (float) $rates[$cheapestKey]['amount']) {
                $cheapestKey = $key;
            }
        }

        return $cheapestKey;
    }

    /**
     * Apply the buyer's chosen delivery method to a seller's quote. An unknown or
     * missing key falls back to the seller's default rate so a seller is never
     * left without a shipping charge.
     */
    public function applySelectedRate(array $quote, ?string $rateKey): array
    {
        $rates = $quote['rates'] ?? [];

        if (!$rateKey || !isset($rates[$rateKey])) {
            $rateKey = $quote['default_rate_key'] ?? $this->resolveDefaultRateKey($rates);
        }

        $quote['selected_rate_key'] = $rateKey;
        $quote['selected_rate'] = $rateKey ? $rates[$rateKey] : null;

        if (!$quote['selected_rate']) {
            $quote['handling_fee'] = 0;
        }

        return $quote;
    }

    /**
     * What a single seller's quote adds to the buyer's shipping charge.
     * Checkout totals and sub-order totals must both go through this.
     */
    public function sellerShippingCharge(array $quote): float
    {
        if (empty($quote['selected_rate'])) {
            return 0;
        }

        return (float) $quote['selected_rate']['amount'] + (float) ($quote['handling_fee'] ?? 0);
    }

    /**
     * Calculate total shipping cost for all sellers
     */
    public function calculateTotalShippingCost(array $shippingQuotes): float
    {
        $total = 0;

        foreach ($shippingQuotes as $quote) {
            $total += $this->sellerShippingCharge($quote);
        }

        return $total;
    }

    /**
     * Validate seller shipping setup
     */
    public function validateSellerShippingSetup(User $seller): array
    {
        $errors = [];
        
        if ($seller->role === 'collaborator') {
            $businessDetails = CollaboratorBusinessDetails::where('user_id', $seller->id)->first();
            
            if (!$businessDetails) {
                $errors[] = 'Business details are required for shipping';
            } else {
                if (!$this->isValidAddress($businessDetails)) {
                    $errors[] = 'Complete business address is required';
                }
            }
        }

        if ($seller->role === 'admin') {
            $businessDetails = AdminBusinessDetails::where('user_id', $seller->id)->first();
            
            if (!$businessDetails) {
                $errors[] = 'Business details are required for shipping';
            } else {
                if (!$this->isValidAddress($businessDetails)) {
                    $errors[] = 'Complete business address is required';
                }
            }
        }

        // Check if seller has products with valid shipping information
        $products = Product::where('user_id', $seller->id)->get();
        foreach ($products as $product) {
            if ($product->requires_shipping && (!$product->weight || $product->weight <= 0)) {
                $errors[] = "Product '{$product->name}' requires valid weight for shipping calculation";
            }
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors,
        ];
    }
}
