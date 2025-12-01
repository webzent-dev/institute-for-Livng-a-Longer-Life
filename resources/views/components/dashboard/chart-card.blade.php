@props(['title' => 'Sales Overview', 'chartId' => 'chartDefault'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <p class="font-semibold text-lg mb-3">{{ $title }}</p>

    <canvas id="{{ $chartId }}" height="120"></canvas>

    {{ $slot }}
</div>





{{-- how to use --}}


{{-- <x-dashboard.chart-card title="Monthly Revenue" chartId="revenueChart" /> --}}



{{-- <x-dashboard.chart-card 
    title="Monthly Sales" 
    chartId="monthlySalesChart"
>
    <script>    
        var ctx = document.getElementById("monthlySalesChart").getContext("2d");
        var chart = new Chart(ctx, {
            // ...
        });
    </script>
</x-dashboard.chart-card> --}}      
{{-- <x-dashboard.chart-card 
    title="User Growth" 
    chartId="userGrowthChart"
>
    <script>    
        var ctx = document.getElementById("userGrowthChart").getContext("2d");
        var chart = new Chart(ctx, {    
            // ...
        }); 
    </script>    
</x-dashboard.chart-card> --}}  
{{-- <x-dashboard.chart-card 
    title="Revenue Breakdown" 
    chartId="revenueBreakdownChart"
>
    <script>    
        var ctx = document.getElementById("revenueBreakdownChart").getContext("2d");
        var chart = new Chart(ctx, {    
            // ...
        }); 
    </script>    
</x-dashboard.chart-card> --}}  
{{-- <x-dashboard.chart-card 
    title="Website Traffic" 
    chartId="websiteTrafficChart"
>
    <script>    
        var ctx = document.getElementById("websiteTrafficChart").getContext("2d");
        var chart = new Chart(ctx, {    
            // ...
        }); 
    </script>    
</x-dashboard.chart-card> --}}      

