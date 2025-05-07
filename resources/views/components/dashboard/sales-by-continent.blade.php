@props([
    'salesByContinent' => [],
])


<div class="rounded-2xl border mb-4 border-gray-200 bg-white p-6 md:p-8 flex-1">
    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                <i class="fas fa-map text-blue-800"></i>
            </div>
            <div>
                <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Sales by Continent</h5>
                <p class="text-sm font-normal text-gray-500">Top Sales by continent</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        {{-- MAP --}}
        <div class="w-full md:w-2/3">
            <div id="sales-by-locations" class="w-full min-h-full" data-colors='["#5156be"]' style="height: 250px"></div>
        </div>

        {{-- PROGRESS BAR --}}
        <div class="w-full md:w-1/3 space-y-4">
            @php
                $continents = [
                    ['name' => 'Asia', 'value' => $salesByContinent['asia'], 'color' => '#f87171'],
                    ['name' => 'Europe', 'value' => $salesByContinent['europe'], 'color' => '#60a5fa'],
                    ['name' => 'America', 'value' => $salesByContinent['america'], 'color' => '#34d399'],
                    ['name' => 'Australia', 'value' => $salesByContinent['australia'], 'color' => '#c084fc'],
                    ['name' => 'Africa', 'value' => $salesByContinent['africa'], 'color' => '#facc15'],
                    ['name' => 'Undefined', 'value' => $salesByContinent['undefined'], 'color' => '#9ca3af '],
                ];
            @endphp
            @foreach ($continents as $continent)
                <div>
                    <p class="text-md text-gray-400 mb-1">{{ $continent['name'] }}</p>
                    <div class="w-full bg-gray-200 rounded-full">
                        <div class="text-xs font-medium text-white text-center p-0.5 leading-none rounded-full"
                            style="width: {{ $continent['value'] }}%; background-color: {{ $continent['color'] }};">
                            {{ $continent['value'] }}%
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@once
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('map/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('map/jquery-jvectormap-world-mill-en.js') }}"></script>

        <script>
            const continentMarkers = [{
                    latLng: [35.8617, 104.1954],
                    name: "Asia",
                    style: {
                        fill: "#f87171"
                    }
                }, // red-400
                {
                    latLng: [54.5260, 15.2551],
                    name: "Europe",
                    style: {
                        fill: "#60a5fa"
                    }
                }, // blue-400
                {
                    latLng: [37.0902, -95.7129],
                    name: "America",
                    style: {
                        fill: "#34d399"
                    }
                }, // green-400
                {
                    latLng: [-25.2744, 133.7751],
                    name: "Australia",
                    style: {
                        fill: "#c084fc"
                    }
                }, // purple-400
                {
                    latLng: [1.6508, 17.6791],
                    name: "Africa",
                    style: {
                        fill: "#facc15"
                    }
                } // yellow-400
            ];

            $('#sales-by-locations').vectorMap({
                map: 'world_mill_en',
                backgroundColor: 'transparent',
                regionStyle: {
                    initial: {
                        fill: '#e5e7eb' // light gray for countries
                    }
                },
                markers: continentMarkers,
                markerStyle: {
                    initial: {
                        r: 8,
                        stroke: '#fff',
                        'stroke-width': 2,
                        'fill-opacity': 0.9
                    },
                    hover: {
                        stroke: '#000',
                        'stroke-width': 2
                    }
                },
                onMarkerTipShow: function(event, label, index) {
                    label.html(`<strong>${continentMarkers[index].name}</strong>`);
                }
            });
        </script>
    @endpush
@endonce
