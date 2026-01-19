
@extends('member.member')

@section('member-content')

<main class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-4 md:p-8">
    <div class="max-w-7xl w-full">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-primary mb-2">Manage Your Plan</h1>
            <p class="text-gray-600 text-lg">Upgrade or downgrade your membership</p>
        </div>

        <!-- Plans Container -->
         @php
                $plans = [
            [
              'name' => 'Standard Membership',
              'price' => '$183',
              'period' => '/Year',
              'url' => '/membership',
              'current' => false,
              'description' => 'Access to all video lessons',
              'features' => [
                'Access to 1 pre-recorded lecture a month',
                '$10 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free guides',
              ],
            ],
            [
              'name' => 'Premium Membership',
              'price' => '$387',
              'period' => '/Year',
              'url' => '/membership',
              'popular' => true,
              'current' => true,
              'description' => 'Everything in Essential',
              'features' => [
                'Access to all pre-recorded lectures for a year',
                '$15 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books',
                '10 free guides',
              ],
            ],
            [
              'name' => 'Lifetime Membership',
              'price' => '$799',
              'period' => 'Lifetime',
              'url' => '/membership',
              'current' => false,
              'description' => 'Everything in Premium',
              'features' => [
                'Access to all pre-recorded lectures for lifetime',
                '$20 Discount on Vital Boost',
                'Monthly Live Zoom Session',
                '3 free books, 10 free guides',
                '50% off on consultations',
              ],
            ],
          ];
        
        
        
        @endphp
            
            

        <div class="flex flex-col lg:flex-row gap-8 justify-center items-stretch">
            @foreach($plans as $plan)
                <x-membership-card :plan="$plan" />
            @endforeach
            
        </div>
        
         
    </div>
</main>
    <script>
        // Simple interactivity for buttons
        document.addEventListener('DOMContentLoaded', function() {
            const downgradeBtn = document.querySelector('button:first-of-type');
            const upgradeBtn = document.querySelector('button:last-of-type');
            
            downgradeBtn.addEventListener('click', function() {
                alert('Downgrade to Standard plan selected');
            });
            
            upgradeBtn.addEventListener('click', function() {
                alert('Upgrade to Lifetime plan selected');
            });
        });
    </script>
@endsection