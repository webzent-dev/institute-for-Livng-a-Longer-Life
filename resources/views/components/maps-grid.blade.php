@php 
    use App\Models\Location;
    $locations = Location::all();
@endphp

<section class="py-6 bg-gray-50">
   
        <div class="section-base max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 @foreach($locations as $index => $location)
                    <div class="conainer-base bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">

                        <div class="p-5 border-b bg-gray-100 space-y-2">
                            <a href="https://maps.google.com/?q={{ $location->latitude }},{{ $location->longitude }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="space-y-2 block">

                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ $location->name }}
                                </h3>

                                <p class="text-gray-600 leading-tight hover:text-primary transition-colors">
                                    {{ $location->address }} <br>
                                    {{ $location->city }}, {{ $location->state }}
                                </p>
                            </a>
                        </div>

                        {{-- Dynamic Map ID --}}
                        <div id="map{{ $index }}" class="w-full h-72 md:h-96 relative rounded-b-2xl"></div>

                    </div>
                @endforeach
        </div>
       

    </div>

</section>




<script>
    const locations = @json($locations);
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    locations.forEach((location, index) => {

        if (!location.latitude || !location.longitude) return;

        const map = L.map(`map${index}`, {
            zoomControl: false
        }).setView(
            [parseFloat(location.latitude), parseFloat(location.longitude)],
            14
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

        L.marker([location.latitude, location.longitude])
            .addTo(map)
            .bindPopup(`
                <b>${location.name}</b><br>
                ${location.address}<br>
                ${location.city}, ${location.state}
            `);

        // Custom Zoom Buttons (same as before)
        L.control.zoom({ position: 'bottomright' }).addTo(map);
    });

});
</script>

