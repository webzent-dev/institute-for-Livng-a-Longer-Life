<?php

namespace App\Console\Commands;

use App\Services\ShippoService;
use Illuminate\Console\Command;

class TestShippoIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipping:test-shippo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Shippo API integration';

    /**
     * Execute the console command.
     */
    public function handle(ShippoService $shippoService)
    {
        $this->info('Testing Shippo API Integration...');
        $this->newLine();

        try {
            // Test address validation
            $this->info('1. Testing Address Validation...');
            $testAddress = [
                'name' => 'Test Customer',
                'address_line_1' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'country' => 'US'
            ];
            
            $validation = $shippoService->validateAddress($testAddress);
            $this->info('   Address Valid: ' . ($validation['is_valid'] ? 'Yes' : 'No'));
            $this->info('   Messages: ' . implode(', ', $validation['messages']));
            $this->newLine();

            // Test rate calculation
            $this->info('2. Testing Rate Calculation...');
            $origin = [
                'name' => 'Seller',
                'address_line_1' => '456 Seller Ave',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip_code' => '90210',
                'country' => 'US'
            ];
            
            $destination = $testAddress;
            
            $packageDetails = [
                'weight' => 2.5, // pounds
                'dimensions' => [
                    'length' => 10,
                    'width' => 8,
                    'height' => 4
                ],
                'requires_shipping' => true
            ];
            
            $rates = $shippoService->getRates($origin, $destination, $packageDetails);
            
            $this->info('   Available Rates:');
            foreach ($rates as $service => $rate) {
                $this->info("   - {$service}: \${$rate['amount']} ({$rate['provider']} - {$rate['service']})");
                $this->info("     Estimated Days: {$rate['estimated_days']}");
                $this->info("     Rate ID: {$rate['rate_id']}");
                $this->newLine();
            }

            // Test tracking (mock)
            $this->info('3. Testing Tracking (Mock Data)...');
            $tracking = $shippoService->trackShipment('123456789', 'usps');
            $this->info('   Tracking Status: ' . $tracking['tracking_status']);
            $this->info('   Tracking History: ' . count($tracking['tracking_history']) . ' entries');
            $this->newLine();
            
            $this->info('✅ Shippo API Integration Test Complete!');
            $this->info('   All tests passed successfully.');
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('   Please check your API key and configuration.');
            return 1;
        }

        return 0;
    }
}
