<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">
            Our Locations
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Map 1 --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-gray-100   space-y-2">
                    <a href="https://maps.app.goo.gl/1cXGaXLE86aCyT2p7" target="_blank" rel="noopener noreferrer" class="space-y-2">
                            <h3 class="text-xl font-semibold text-gray-900 ">New York Office</h3>
                            <p class="text-gray-600 leading-tight hover:text-primary transition-colors block">
                                580 Park Avenue 
                                Suite 1E <br>
                                New York, NY 10065
                            </p>
                </div>
                    </a>
                    

                <div id="map1" class="w-full h-72 md:h-96 relative rounded-b-2xl"></div>
            </div>

            {{-- Map 2 --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-gray-100 ">
                    <a href="https://maps.app.goo.gl/BtRX2FRtfRZTyxdY6" target="_blank" rel="noopener noreferrer" class="space-y-2">
                    <h3 class="text-xl font-semibold text-gray-900">Shokan Office</h3>
                    <p class="text-gray-600 leading-tight hover:text-primary transition-colors block">
                        3103 Route 28 <br>
                        Shokan, NY 12481
                    </p>
                </a>
                </div>

                <div id="map2" class="w-full h-72 md:h-96 relative rounded-b-2xl"></div>
            </div>

        </div>
    </div>
</section>

<style>
    /* Custom Modern Zoom Buttons */
    .leaflet-control-zoom {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .leaflet-control-zoom-in,
    .leaflet-control-zoom-out {
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important; /* Tailwind gray-200 */
        color: #111827 !important; /* gray-900 */
        width: 42px !important;
        height: 42px !important;
        display: flex !important;
        justify-content: center;
        align-items: center;
        font-size: 22px !important;
        border-radius: 50% !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all .2s ease;
    }

    .leaflet-control-zoom-in:hover,
    .leaflet-control-zoom-out:hover {
        background-color: #f3f4f6 !important; /* gray-100 */
        transform: scale(1.08);
    }

    /* Hide attribution */
    .leaflet-control-attribution {
        display: none !important;
    }
</style>


<script>
document.addEventListener("DOMContentLoaded", () => {

    /* -------------------------
       LOCATION 1 MAP
    -------------------------- */
    const map1 = L.map('map1', {
        zoomControl: false
    }).setView([40.76436, -73.96751], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ''
    }).addTo(map1);

    L.marker([40.76436, -73.96751]).addTo(map1)
        .bindPopup("<b>580 Park Avenue</b><br>New York, NY 10065");

    // Custom Zoom Buttons
    L.control.zoom({ position: 'bottomright' }).addTo(map1);


    /* -------------------------
       LOCATION 2 MAP
    -------------------------- */
    const map2 = L.map('map2', {
        zoomControl: false
    }).setView([41.9783, -74.2147], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ''
    }).addTo(map2);

    L.marker([41.9783, -74.2147]).addTo(map2)
        .bindPopup("<b>3103 Route 28</b><br>Shokan, NY 12481");

    // Custom Zoom Buttons
    L.control.zoom({ position: 'bottomright' }).addTo(map2);

});
</script>
