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

            $shippingQuotes[$sellerId] = [
                'seller_name' => $seller->first_name . ' ' . $seller->last_name,
                'seller_id' => $sellerId,
                'origin_address' => $originAddress,
                'items' => $sellerItems,
                'package_details' => $packageDetails,
                'rates' => $rates,
                'selected_rate' => $rates['standard'] ?? null,
                'handling_fee' => $this->getSellerHandlingFee($seller),
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

        foreach ($cart as $productId => $quantity) {
            $product = Product::with('user')->find($productId);
            if (!$product) continue;

            $sellerId = $product->user_id;
            
            if (!$groupedItems->has($sellerId)) {
                $groupedItems->put($sellerId, []);
            }

            $items = $groupedItems->get($sellerId);
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
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

            \Log::info('Processing product: ' . $product->name . ', requires_shipping: ' . ($product->requires_shipping ?? 'null'));
            
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

        \Log::info('Package details calculated:', [
            'weight' => $totalWeight,
            'length' => $maxLength,
            'width' => $maxWidth,
            'height' => $maxHeight,
            'requires_shipping' => $requiresShipping
        ]);

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
        \Log::info('getShippingRates called with:', [
            'origin' => $origin,
            'destination' => $destination,
            'package_details' => $packageDetails
        ]);

        if (!$packageDetails['requires_shipping']) {
            \Log::info('Product does not require shipping, returning zero rate');
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
            \Log::info('Calling ShippoService->getRates()');
            $rates = $this->shippoService->getRates($origin, $destination, $packageDetails);
            \Log::info('ShippoService returned rates:', $rates);
            
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
     * Calculate total shipping cost for all sellers
     */
    public function calculateTotalShippingCost(array $shippingQuotes): float
    {
        $total = 0;
        
        foreach ($shippingQuotes as $sellerId => $quote) {
            $selectedRate = $quote['selected_rate'];
            if ($selectedRate) {
                $total += $selectedRate['amount'] + $quote['handling_fee'];
            }
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
