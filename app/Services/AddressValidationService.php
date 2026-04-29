<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AddressValidationService
{
    protected $googleMapsApiKey;
    protected $uspsUserId;
    protected $cacheTtl = 3600; // 1 hour

    public function __construct()
    {
        $this->googleMapsApiKey = config('shipping.validation.google_maps_api_key');
        $this->uspsUserId = config('shipping.validation.usps_user_id');
    }

    /**
     * Validate address using Google Maps Geocoding API
     */
    public function validateWithGoogleMaps(array $address): array
    {
        if (!$this->googleMapsApiKey) {
            return ['valid' => true, 'message' => 'Google Maps API not configured'];
        }

        $cacheKey = 'google_address_' . md5(json_encode($address));
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($address) {
            try {
                $formattedAddress = $this->formatAddressForGoogle($address);
                
                $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $formattedAddress,
                    'key' => $this->googleMapsApiKey,
                    'components' => $this->getAddressComponents($address)
                ]);

                $data = $response->json();

                if ($data['status'] === 'OK' && !empty($data['results'])) {
                    $result = $data['results'][0];
                    
                    return [
                        'valid' => true,
                        'formatted_address' => $result['formatted_address'],
                        'components' => $this->parseGoogleComponents($result['address_components']),
                        'coordinates' => [
                            'lat' => $result['geometry']['location']['lat'],
                            'lng' => $result['geometry']['location']['lng']
                        ],
                        'confidence' => $this->getGoogleConfidence($result),
                        'provider' => 'google_maps'
                    ];
                } else {
                    return [
                        'valid' => false,
                        'message' => $this->getGoogleErrorMessage($data['status']),
                        'provider' => 'google_maps'
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Google Maps API Error: ' . $e->getMessage());
                return [
                    'valid' => false,
                    'message' => 'Google Maps validation failed',
                    'provider' => 'google_maps'
                ];
            }
        });
    }

    /**
     * Validate address using USPS Address Information API
     */
    public function validateWithUSPS(array $address): array
    {
        if (!$this->uspsUserId) {
            return ['valid' => true, 'message' => 'USPS API not configured'];
        }

        $cacheKey = 'usps_address_' . md5(json_encode($address));
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($address) {
            try {
                $xmlRequest = $this->buildUSPSAddressRequest($address);
                
                $response = Http::asForm()->post('https://secure.shippingapis.com/ShippingAPI.dll', [
                    'API' => 'Verify',
                    'XML' => $xmlRequest
                ]);

                $xml = simplexml_load_string($response->body());
                
                if ($xml && isset($xml->Address->Address2)) {
                    $validatedAddress = $xml->Address;
                    
                    return [
                        'valid' => true,
                        'formatted_address' => $this->formatUSPSAddress($validatedAddress),
                        'components' => $this->parseUSPSComponents($validatedAddress),
                        'dpv_confirmation' => (string)($validatedAddress->DPVConfirmation ?? ''),
                        'carrier_route' => (string)($validatedAddress->CarrierRoute ?? ''),
                        'provider' => 'usps'
                    ];
                } else {
                    return [
                        'valid' => false,
                        'message' => 'Invalid address format',
                        'provider' => 'usps'
                    ];
                }
            } catch (\Exception $e) {
                Log::error('USPS API Error: ' . $e->getMessage());
                return [
                    'valid' => false,
                    'message' => 'USPS validation failed',
                    'provider' => 'usps'
                ];
            }
        });
    }

    /**
     * Validate US address with specific US rules
     */
    public function validateUSAddress(array $address): array
    {
        $errors = [];
        
        // Check if country is US
        if (!isset($address['country']) || !in_array(strtoupper($address['country']), ['US', 'USA', 'UNITED STATES'])) {
            return [
                'valid' => false,
                'message' => 'This validation is only for US addresses',
                'errors' => ['country' => 'Country must be United States']
            ];
        }
        
        // Validate required fields
        $requiredFields = ['address_line_1', 'city', 'state', 'zip_code'];
        foreach ($requiredFields as $field) {
            if (empty($address[$field])) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }
        
        // Validate US state
        if (!empty($address['state'])) {
            $validStates = $this->getUSStates();
            $stateCode = strtoupper($address['state']);
            if (!isset($validStates[$stateCode]) && !in_array($address['state'], $validStates)) {
                $errors['state'] = 'Invalid US state. Please use a valid 2-letter state code or full state name.';
            }
        }
        
        // Validate ZIP code format
        if (!empty($address['zip_code'])) {
            if (!$this->isValidUSZipCode($address['zip_code'])) {
                $errors['zip_code'] = 'Invalid US ZIP code format. Use 5 digits (12345) or ZIP+4 (12345-6789).';
            }
        }
        
        // Validate address line 1 format
        if (!empty($address['address_line_1'])) {
            if (!$this->isValidUSAddressLine($address['address_line_1'])) {
                $errors['address_line_1'] = 'Address line 1 appears to be invalid. Please include street number and name.';
            }
        }
        
        // If there are validation errors, return them
        if (!empty($errors)) {
            return [
                'valid' => false,
                'message' => 'US address validation failed',
                'errors' => $errors,
                'provider' => 'us_validation'
            ];
        }
        
        // If basic validation passes, proceed with API validation
        return $this->validateAddress($address);
    }
    
    /**
     * Get list of US states
     */
    private function getUSStates(): array
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming'
        ];
    }
    
    /**
     * Validate US ZIP code format
     */
    private function isValidUSZipCode(string $zipCode): bool
    {
        // Remove any spaces
        $zipCode = str_replace(' ', '', $zipCode);
        
        // Check 5-digit format (12345)
        if (preg_match('/^\d{5}$/', $zipCode)) {
            return true;
        }
        
        // Check ZIP+4 format (12345-6789)
        if (preg_match('/^\d{5}-\d{4}$/', $zipCode)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Validate US address line format
     */
    private function isValidUSAddressLine(string $addressLine): bool
    {
        // Check minimum length (at least 5 characters)
        if (strlen(trim($addressLine)) < 5) {
            return false;
        }
        
        // Check if address contains at least a number and some letters
        if (!preg_match('/\d.*[a-zA-Z]|[a-zA-Z].*\d/', $addressLine)) {
            return false;
        }
        
        // Enhanced patterns for US addresses
        $patterns = [
            // Standard: 123 Main Street
            '/^\d+\s+.*\s+(street|st|avenue|ave|road|rd|boulevard|blvd|lane|ln|drive|dr|court|ct|way|place|pl|circle|cir)/i',
            
            // Numbered streets: 58th Avenue, 23rd Street, 1st Avenue
            '/^\d+(st|nd|rd|th)\s+(street|st|avenue|ave|road|rd|boulevard|blvd|lane|ln|drive|dr|court|ct|way|place|pl|circle|cir)/i',
            
            // Multiple numbered streets: 58th Ave 23 St
            '/^\d+(st|nd|rd|th)\s+(ave|avenue|st|street|rd|road|blvd|boulevard|ln|lane|dr|drive|ct|court)\s+\d+(st|nd|rd|th)\s+(ave|avenue|st|street|rd|road|blvd|boulevard|ln|lane|dr|drive|ct|court)/i',
            
            // Basic number + street name: 123 Main
            '/^\d+\s+[a-zA-Z0-9\s]+/',
            
            // Street name + number: Main Street 123
            '/^[a-zA-Z0-9\s]+\s+\d+/',
            
            // Highway addresses: 123 Highway 101
            '/^\d+\s+(highway|hwy|route|rt)\s+\d+/i',
            
            // PO Box: PO Box 123
            '/^(po\s+box|p\.o\.\s*box)\s+\d+/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $addressLine)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Comprehensive address validation using multiple providers
     */
    public function validateAddress(array $address): array
    {
        $results = [];
        
        // Try Google Maps first (primary provider)
        $googleResult = $this->validateWithGoogleMaps($address);
        $results['google_maps'] = $googleResult;
        
        // Try USPS only if enabled and Google Maps fails
        $uspsResult = ['valid' => false, 'message' => 'USPS validation disabled'];
        if (config('shipping.validation.address_validation.providers.usps.enabled', false)) {
            $uspsResult = $this->validateWithUSPS($address);
            $results['usps'] = $uspsResult;
        }
        
        // Determine overall validity (prioritize Google Maps)
        $overallValid = $googleResult['valid'];
        
        // If Google Maps fails and fallback is enabled, try USPS
        if (!$overallValid && config('shipping.validation.address_validation.fallback_to_google', true) && $uspsResult['valid']) {
            $overallValid = true;
        }
        
        return [
            'valid' => $overallValid,
            'results' => $results,
            'suggestions' => $this->getAddressSuggestions($results),
            'best_match' => $this->getBestMatch($results),
            'primary_provider' => 'google_maps'
        ];
    }

    /**
     * Validate seller pickup address for shipping
     */
    public function validateSellerAddress(User $seller): array
    {
        $address = [
            'address_line_1' => $seller->address_line_1 ?? '',
            'address_line_2' => $seller->address_line_2 ?? '',
            'city' => $seller->city ?? '',
            'state' => $seller->state ?? '',
            'zip_code' => $seller->zip_code ?? '',
            'country' => $seller->country ?? 'US'
        ];
        
        // Check if required fields are present
        $requiredFields = ['address_line_1', 'city', 'state', 'zip_code'];
        foreach ($requiredFields as $field) {
            if (empty($address[$field])) {
                return [
                    'valid' => false,
                    'message' => "Missing required field: {$field}",
                    'field' => $field
                ];
            }
        }
        
        // Validate with Google Maps
        $validation = $this->validateAddress($address);
        
        // Add seller-specific information
        $validation['seller_id'] = $seller->id;
        $validation['seller_name'] = $seller->first_name . ' ' . $seller->last_name;
        $validation['is_pickup_point'] = true;
        
        return $validation;
    }

    /**
     * Format address for Google Maps API
     */
    private function formatAddressForGoogle(array $address): string
    {
        $parts = [];
        
        if (!empty($address['address_line_1'])) {
            $parts[] = $address['address_line_1'];
        }
        
        if (!empty($address['address_line_2'])) {
            $parts[] = $address['address_line_2'];
        }
        
        $cityParts = [];
        if (!empty($address['city'])) {
            $cityParts[] = $address['city'];
        }
        if (!empty($address['state'])) {
            $cityParts[] = $address['state'];
        }
        if (!empty($address['zip_code'])) {
            $cityParts[] = $address['zip_code'];
        }
        
        if (!empty($cityParts)) {
            $parts[] = implode(', ', $cityParts);
        }
        
        if (!empty($address['country'])) {
            $parts[] = $address['country'];
        }
        
        return implode(', ', $parts);
    }

    /**
     * Get address components for Google Maps API
     */
    private function getAddressComponents(array $address): array
    {
        $components = [];
        
        if (!empty($address['country'])) {
            $components['country'] = $address['country'];
        }
        
        if (!empty($address['state'])) {
            $components['administrative_area'] = $address['state'];
        }
        
        if (!empty($address['city'])) {
            $components['locality'] = $address['city'];
        }
        
        if (!empty($address['zip_code'])) {
            $components['postal_code'] = $address['zip_code'];
        }
        
        return $components;
    }

    /**
     * Parse Google Maps address components
     */
    private function parseGoogleComponents(array $components): array
    {
        $parsed = [];
        
        foreach ($components as $component) {
            $types = $component['types'];
            
            if (in_array('street_number', $types)) {
                $parsed['street_number'] = $component['long_name'];
            }
            
            if (in_array('route', $types)) {
                $parsed['route'] = $component['long_name'];
            }
            
            if (in_array('locality', $types)) {
                $parsed['city'] = $component['long_name'];
            }
            
            if (in_array('administrative_area_level_1', $types)) {
                $parsed['state'] = $component['short_name'];
            }
            
            if (in_array('postal_code', $types)) {
                $parsed['zip_code'] = $component['long_name'];
            }
            
            if (in_array('country', $types)) {
                $parsed['country'] = $component['short_name'];
            }
        }
        
        return $parsed;
    }

    /**
     * Get confidence score from Google Maps result
     */
    private function getGoogleConfidence(array $result): float
    {
        // Google Maps doesn't provide explicit confidence scores
        // We'll estimate based on address components completeness
        $components = $result['address_components'];
        $requiredTypes = ['street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code'];
        
        $foundTypes = 0;
        foreach ($components as $component) {
            if (array_intersect($component['types'], $requiredTypes)) {
                $foundTypes++;
            }
        }
        
        return min($foundTypes / count($requiredTypes), 1.0);
    }

    /**
     * Get error message from Google Maps API response
     */
    private function getGoogleErrorMessage(string $status): string
    {
        $messages = [
            'ZERO_RESULTS' => 'Address not found',
            'OVER_QUERY_LIMIT' => 'API quota exceeded',
            'REQUEST_DENIED' => 'API key invalid or permissions denied',
            'INVALID_REQUEST' => 'Invalid request parameters',
            'UNKNOWN_ERROR' => 'Server error, please try again'
        ];
        
        return $messages[$status] ?? 'Unknown error occurred';
    }

    /**
     * Build USPS XML request
     */
    private function buildUSPSAddressRequest(array $address): string
    {
        $xml = new \SimpleXMLElement('<AddressValidateRequest USERID="' . htmlspecialchars($this->uspsUserId) . '"/>');
        
        $addressXml = $xml->addChild('Address');
        $addressXml->addAttribute('ID', '0');
        
        if (!empty($address['address_line_1'])) {
            $addressXml->addChild('Address1', htmlspecialchars($address['address_line_1']));
        }
        
        if (!empty($address['address_line_2'])) {
            $addressXml->addChild('Address2', htmlspecialchars($address['address_line_2']));
        } else {
            $addressXml->addChild('Address2', ''); // Required field
        }
        
        $addressXml->addChild('City', htmlspecialchars($address['city'] ?? ''));
        $addressXml->addChild('State', htmlspecialchars($address['state'] ?? ''));
        $addressXml->addChild('Zip5', htmlspecialchars(substr($address['zip_code'] ?? '', 0, 5)));
        $addressXml->addChild('Zip4', htmlspecialchars(substr($address['zip_code'] ?? '', 5)));
        
        return $xml->asXML();
    }

    /**
     * Format USPS address
     */
    private function formatUSPSAddress(\SimpleXMLElement $address): string
    {
        $parts = [];
        
        if (!empty($address->Address2)) {
            $parts[] = (string)$address->Address2;
        }
        
        if (!empty($address->Address1)) {
            $parts[] = (string)$address->Address1;
        }
        
        $cityParts = [];
        if (!empty($address->City)) {
            $cityParts[] = (string)$address->City;
        }
        if (!empty($address->State)) {
            $cityParts[] = (string)$address->State;
        }
        if (!empty($address->Zip5)) {
            $zip = (string)$address->Zip5;
            if (!empty($address->Zip4)) {
                $zip .= '-' . (string)$address->Zip4;
            }
            $cityParts[] = $zip;
        }
        
        if (!empty($cityParts)) {
            $parts[] = implode(', ', $cityParts);
        }
        
        return implode(', ', $parts);
    }

    /**
     * Parse USPS address components
     */
    private function parseUSPSComponents(\SimpleXMLElement $address): array
    {
        return [
            'address_line_1' => (string)($address->Address2 ?? ''),
            'address_line_2' => (string)($address->Address1 ?? ''),
            'city' => (string)($address->City ?? ''),
            'state' => (string)($address->State ?? ''),
            'zip_code' => (string)($address->Zip5 ?? ''),
            'zip4' => (string)($address->Zip4 ?? ''),
        ];
    }

    /**
     * Get address suggestions from validation results
     */
    private function getAddressSuggestions(array $results): array
    {
        $suggestions = [];
        
        foreach ($results as $provider => $result) {
            if ($result['valid'] && isset($result['formatted_address'])) {
                $suggestions[] = [
                    'address' => $result['formatted_address'],
                    'provider' => $provider,
                    'confidence' => $result['confidence'] ?? 0.8
                ];
            }
        }
        
        return $suggestions;
    }

    /**
     * Get best match from validation results
     */
    private function getBestMatch(array $results): array
    {
        $bestMatch = null;
        $highestConfidence = 0;
        
        foreach ($results as $provider => $result) {
            if ($result['valid']) {
                $confidence = $result['confidence'] ?? 0.5;
                if ($confidence > $highestConfidence) {
                    $highestConfidence = $confidence;
                    $bestMatch = $result;
                }
            }
        }
        
        return $bestMatch ?? ['valid' => false, 'message' => 'No valid address found'];
    }
}
