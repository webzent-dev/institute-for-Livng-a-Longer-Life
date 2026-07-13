<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippoService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.goshippo.com/';

    public function __construct()
    {
        $this->apiKey = config('shipping.carriers.shippo.api_key');
        $this->baseUrl = 'https://api.goshippo.com/';
    }

    /**
     * Get shipping rates from Shippo API
     */
    public function getRates(array $origin, array $destination, array $packageDetails): array
    {
        
        try {
            // Use real Shippo API only
            $shipment = $this->createShipment($origin, $destination, $packageDetails);

            return $this->extractRatesFromShipment($shipment);

        } catch (\Exception $e) {
            // Return empty array if API fails
            Log::error('Shippo API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return [];
        }
    }

    /**
     * Create address in Shippo
     */
    private function createAddress(array $address): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'ShippoToken ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'addresses/', [
            'name' => $address['name'] ?? 'Customer',
            'street1' => $address['address_line_1'],
            'street2' => $address['address_line_2'] ?? '',
            'city' => $address['city'],
            'state' => $address['state'],
            'zip' => $address['zip_code'],
            'country' => $address['country'],
            'validate' => true,
        ]);

        return $response->json();
    }

    /**
     * Create parcel in Shippo
     */
    private function createParcel(array $packageDetails): array
    {
        $parcelData = [
            'length' => $packageDetails['length'] ?? 10,
            'width' => $packageDetails['width'] ?? 8,
            'height' => $packageDetails['height'] ?? 4,
            'distance_unit' => 'in',
            'weight' => $packageDetails['weight'] ?? 1,
            'mass_unit' => 'lb',
        ];

        $response = Http::withHeaders([
            'Authorization' => 'ShippoToken ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'parcels/', $parcelData);

        return $response->json();
    }

    /**
     * Create shipment in Shippo
     */
    private function createShipment(array $addressFrom, array $addressTo, array $parcel): array
    {
        // Convert address format for Shippo API
        $shippoAddressFrom = [
            'name' => $addressFrom['name'] ?? 'Sender',
            'street1' => $addressFrom['address_line_1'],
            'street2' => $addressFrom['address_line_2'] ?? '',
            'city' => $addressFrom['city'],
            'state' => $addressFrom['state'],
            'zip' => $addressFrom['zip_code'],
            'country' => $addressFrom['country'],
            'email' => $addressFrom['email'] ?? '',
            'phone' => $addressFrom['phone'] ?? '',
        ];
        
        $shippoAddressTo = [
            'name' => $addressTo['name'] ?? 'Recipient',
            'street1' => $addressTo['address_line_1'],
            'street2' => $addressTo['address_line_2'] ?? '',
            'city' => $addressTo['city'],
            'state' => $addressTo['state'],
            'zip' => $addressTo['zip_code'],
            'country' => $addressTo['country'],
        ];

        // Create parcel data directly (not calling parcel API)
        $shippoParcel = [
            'length' => $parcel['length'] ?? 10,
            'width' => $parcel['width'] ?? 8,
            'height' => $parcel['height'] ?? 4,
            'distance_unit' => 'in',
            'weight' => $parcel['weight'] ?? 1,
            'mass_unit' => 'lb',
        ];
        
        $shipmentData = [
            'address_from' => $shippoAddressFrom,
            'address_to' => $shippoAddressTo,
            'parcels' => [$shippoParcel],
            'async' => false,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'ShippoToken ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'shipments/', $shipmentData);

        $result = $response->json();

        if (empty($result['rates'])) {
            Log::warning('No rates found in Shippo response', [
                'messages' => $result['messages'] ?? null,
            ]);
        }

        return $result;
    }

    /**
     * Extract rates from Shippo shipment
     */
    private function extractRatesFromShipment(array $shipment): array
    {
        if (!isset($shipment['rates'])) {
            return [];
        }

        $formattedRates = [];
        foreach ($shipment['rates'] as $rate) {
            $serviceKey = $this->getServiceKey($rate['servicelevel']['name']);
            
            $formattedRates[$serviceKey] = [
                'amount' => $rate['amount'],
                'provider' => $rate['provider'],
                'service' => $rate['servicelevel']['name'],
                'estimated_days' => $rate['estimated_days'] ?? null,
                'rate_id' => $rate['object_id'],
                'currency' => $rate['currency'],
            ];
        }

        return $formattedRates;
    }

    /**
     * Get service key for standardized service names
     */
    private function getServiceKey(string $serviceName): string
    {
        $serviceMap = [
            // USPS Services
            'Ground Advantage' => 'standard',
            'Ground Saver' => 'standard',
            'Priority Mail' => 'express',
            'Priority Mail Express' => 'overnight',
            'Priority Mail International' => 'express',
            'Priority Mail Express International' => 'overnight',
            'First-Class Mail' => 'standard',
            'First-Class Package Service' => 'standard',
            'Media Mail' => 'standard',
            'Library Mail' => 'standard',
            'Parcel Select' => 'standard',
            'Parcel Select Ground' => 'standard',
            'Retail Ground' => 'standard',
            'USPS Ground Advantage' => 'standard',
            
            // UPS Services
            'Ground' => 'standard',
            'UPS Ground' => 'standard',
            '3 Day Select' => 'express',
            'UPS 3 Day Select' => 'express',
            '2nd Day Air' => 'express',
            'UPS 2nd Day Air' => 'express',
            '2nd Day Air AM' => 'express',
            'UPS 2nd Day Air AM' => 'express',
            'Next Day Air' => 'overnight',
            'UPS Next Day Air' => 'overnight',
            'Next Day Air Saver' => 'overnight',
            'UPS Next Day Air Saver' => 'overnight',
            'Next Day Air Early' => 'overnight',
            'UPS Next Day Air Early' => 'overnight',
            'UPS Ground Freight' => 'standard',
            'UPS Standard' => 'standard',
            'UPS Worldwide Express' => 'overnight',
            'UPS Worldwide Express Plus' => 'overnight',
            'UPS Worldwide Expedited' => 'express',
            'UPS Worldwide Saver' => 'express',
            'UPS Today Standard' => 'express',
            'UPS Today Express' => 'overnight',
            'UPS Today Express Saver' => 'overnight',
            
            // FedEx Services
            'FedEx Ground' => 'standard',
            'Ground' => 'standard',
            'FedEx Home Delivery' => 'standard',
            'FedEx Express Saver' => 'express',
            'FedEx 2Day' => 'express',
            'FedEx 2Day AM' => 'express',
            'FedEx 2Day Freight' => 'express',
            'FedEx Standard Overnight' => 'overnight',
            'FedEx Priority Overnight' => 'overnight',
            'FedEx First Overnight' => 'overnight',
            'FedEx International Ground' => 'standard',
            'FedEx International Economy' => 'express',
            'FedEx International Priority' => 'overnight',
            'FedEx International First' => 'overnight',
            'FedEx Freight' => 'standard',
            'FedEx Freight Economy' => 'standard',
            'FedEx Freight Priority' => 'express',
            'FedEx Same Day City' => 'overnight',
            'FedEx Same Day' => 'overnight',
            'FedEx Same Day Freight' => 'overnight',
            'FedEx SmartPost' => 'standard',
            'FedEx Ground Economy' => 'standard',
            
            // DHL Services (if available)
            'DHL Express Worldwide' => 'overnight',
            'DHL Express 12:00' => 'overnight',
            'DHL Express Worldwide' => 'overnight',
            'DHL eCommerce' => 'standard',
            'DHL eCommerce Asia' => 'standard',
            'DHL eCommerce Europe' => 'standard',
            
            // Other generic services
            'Standard' => 'standard',
            'Express' => 'express',
            'Overnight' => 'overnight',
            'Economy' => 'standard',
            'Priority' => 'express',
            'First Class' => 'standard',
            'International' => 'express',
        ];

        return $serviceMap[$serviceName] ?? 'standard';
    }

    /**
     * Purchase shipping label
     */
    public function purchaseLabel(string $rateId): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'ShippoToken ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'transactions/', [
            'rate' => $rateId,
            'label_file_type' => 'PDF',
            'async' => false,
        ]);

        $result = $response->json();

        if (($result['status'] ?? null) !== 'SUCCESS') {
            Log::error('Shippo label purchase failed', [
                'rate_id' => $rateId,
                'status' => $result['status'] ?? null,
                'messages' => $result['messages'] ?? null,
            ]);
        }

        return $result;
    }

    /**
     * Validate address using Shippo API
     */
    public function validateAddress(array $address): array
    {
        if (!$this->apiKey) {
            return [
                'is_valid' => true,
                'validated_address' => $address,
                'messages' => ['Mock validation - address considered valid'],
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'ShippoToken ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . 'addresses/', [
                'name' => $address['name'] ?? 'Customer',
                'street1' => $address['address_line_1'],
                'street2' => $address['address_line_2'] ?? '',
                'city' => $address['city'],
                'state' => $address['state'],
                'zip' => $address['zip_code'],
                'country' => $address['country'],
                'validate' => true,
            ]);

            $result = $response->json();

            return [
                'is_valid' => $result['validation_results']['is_valid'] ?? false,
                'validated_address' => $result,
                'messages' => $result['validation_results']['messages'] ?? [],
            ];

        } catch (\Exception $e) {
            return [
                'is_valid' => false,
                'validated_address' => null,
                'messages' => ['Address validation failed: ' . $e->getMessage()],
            ];
        }
    }

    /**
     * Track shipment
     */
    public function trackShipment(string $trackingNumber, string $carrier): array
    {
        if (!$this->apiKey) {
            return [
                'tracking_status' => 'mock_delivered',
                'tracking_history' => [
                    ['status' => 'DELIVERED', 'location' => 'Destination City', 'date' => now()->format('Y-m-d H:i:s')],
                    ['status' => 'IN_TRANSIT', 'location' => 'Transit Hub', 'date' => now()->subDays(1)->format('Y-m-d H:i:s')],
                    ['status' => 'PICKED_UP', 'location' => 'Origin City', 'date' => now()->subDays(2)->format('Y-m-d H:i:s')],
                ],
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'ShippoToken ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . 'tracks/', [
                'carrier' => $carrier,
                'tracking_number' => $trackingNumber,
            ]);

            return $response->json();

        } catch (\Exception $e) {
            return [
                'error' => 'Tracking failed: ' . $e->getMessage(),
            ];
        }
    }
}