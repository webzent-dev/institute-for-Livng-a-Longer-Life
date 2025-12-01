@props(['type' => 'line', 'labels' => [], 'data' => []])

<canvas x-data 
        x-init="
            new Chart($el, {
                type: '{{ $type }}',
                data: {
                    labels: {{ json_encode($labels) }},
                    datasets: [{
                        data: {{ json_encode($data) }},
                        borderWidth: 2,
                        fill: false
                    }]
                }
            });
        "
></canvas>


{{-- --}}{{-- @livewire('ui.chart', ['type' => 'line', 'labels' => $labels, 'data' => $data]) --}}
{{-- how to use --}}

{{-- <x-ui.chart 
    type="bar"
    :labels="['Jan','Feb','Mar','Apr']"
    :data="[10, 20, 15, 30]"
/> --}}


{{-- <x-ui.chart 
    type="bar" 
    :labels="['January', 'February', 'March', 'April']" 
    :data="[10, 20, 15, 25]"
></x-ui.chart> --}}




