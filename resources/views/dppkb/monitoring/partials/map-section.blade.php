<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Map Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                Peta Sebaran Stunting
            </h3>
            <div class="flex items-center space-x-2">
                <button onclick="toggleMapView('heat')" 
                    id="btnHeatMap"
                    class="px-3 py-1.5 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm rounded-lg transition">
                    Heat Map
                </button>
                <button onclick="toggleMapView('marker')" 
                    id="btnMarkerMap"
                    class="px-3 py-1.5 bg-white text-blue-700 text-sm rounded-lg transition font-medium">
                    Markers
                </button>
            </div>
        </div>
    </div>

    {{-- Map Container --}}
    <div class="relative">
        <div id="mapContainer" class="w-full h-[500px] bg-gray-100">
            {{-- Simplified SVG Map of Parepare --}}
            <svg viewBox="0 0 800 600" class="w-full h-full" id="parepareSvgMap">
                <defs>
                    <linearGradient id="gradGreen" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="gradYellow" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="gradOrange" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#fb923c;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="gradRed" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#f87171;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#ef4444;stop-opacity:1" />
                    </linearGradient>
                </defs>

                {{-- Background --}}
                <rect width="800" height="600" fill="#e5e7eb"/>

                {{-- Kecamatan Regions (Placeholder shapes) --}}
                
                {{-- Bacukiki (Top Left) --}}
                <g id="kec-bacukiki" class="kecamatan-region cursor-pointer" 
                    onclick="selectKecamatan('Bacukiki')" 
                    onmouseover="highlightKecamatan(this)" 
                    onmouseout="unhighlightKecamatan(this)">
                    <path d="M 50 50 L 350 50 L 350 280 L 50 280 Z" 
                        fill="url(#gradGreen)" 
                        stroke="#fff" 
                        stroke-width="3" 
                        opacity="0.8"/>
                    <text x="200" y="150" 
                        text-anchor="middle" 
                        font-size="18" 
                        font-weight="bold" 
                        fill="#fff">
                        Bacukiki
                    </text>
                    <text x="200" y="175" 
                        text-anchor="middle" 
                        font-size="14" 
                        fill="#fff" 
                        id="textBacukiki">
                        0 Stunting (0%)
                    </text>
                </g>

                {{-- Bacukiki Barat (Top Right) --}}
                <g id="kec-bacukiki-barat" class="kecamatan-region cursor-pointer" 
                    onclick="selectKecamatan('Bacukiki Barat')" 
                    onmouseover="highlightKecamatan(this)" 
                    onmouseout="unhighlightKecamatan(this)">
                    <path d="M 370 50 L 750 50 L 750 280 L 370 280 Z" 
                        fill="url(#gradYellow)" 
                        stroke="#fff" 
                        stroke-width="3" 
                        opacity="0.8"/>
                    <text x="560" y="150" 
                        text-anchor="middle" 
                        font-size="18" 
                        font-weight="bold" 
                        fill="#fff">
                        Bacukiki Barat
                    </text>
                    <text x="560" y="175" 
                        text-anchor="middle" 
                        font-size="14" 
                        fill="#fff" 
                        id="textBacukikiBarat">
                        0 Stunting (0%)
                    </text>
                </g>

                {{-- Ujung (Bottom Left) --}}
                <g id="kec-ujung" class="kecamatan-region cursor-pointer" 
                    onclick="selectKecamatan('Ujung')" 
                    onmouseover="highlightKecamatan(this)" 
                    onmouseout="unhighlightKecamatan(this)">
                    <path d="M 50 300 L 350 300 L 350 550 L 50 550 Z" 
                        fill="url(#gradOrange)" 
                        stroke="#fff" 
                        stroke-width="3" 
                        opacity="0.8"/>
                    <text x="200" y="410" 
                        text-anchor="middle" 
                        font-size="18" 
                        font-weight="bold" 
                        fill="#fff">
                        Ujung
                    </text>
                    <text x="200" y="435" 
                        text-anchor="middle" 
                        font-size="14" 
                        fill="#fff" 
                        id="textUjung">
                        0 Stunting (0%)
                    </text>
                </g>

                {{-- Soreang (Bottom Right) --}}
                <g id="kec-soreang" class="kecamatan-region cursor-pointer" 
                    onclick="selectKecamatan('Soreang')" 
                    onmouseover="highlightKecamatan(this)" 
                    onmouseout="unhighlightKecamatan(this)">
                    <path d="M 370 300 L 750 300 L 750 550 L 370 550 Z" 
                        fill="url(#gradRed)" 
                        stroke="#fff" 
                        stroke-width="3" 
                        opacity="0.8"/>
                    <text x="560" y="410" 
                        text-anchor="middle" 
                        font-size="18" 
                        font-weight="bold" 
                        fill="#fff">
                        Soreang
                    </text>
                    <text x="560" y="435" 
                        text-anchor="middle" 
                        font-size="14" 
                        fill="#fff" 
                        id="textSoreang">
                        0 Stunting (0%)
                    </text>
                </g>
            </svg>
        </div>

        {{-- Map Legend --}}
        <div class="absolute bottom-4 left-4 bg-white rounded-lg shadow-lg p-4 border border-gray-200">
            <h4 class="text-sm font-bold text-gray-900 mb-3">Tingkat Prevalensi</h4>
            <div class="space-y-2">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded" style="background: linear-gradient(135deg, #10b981, #059669)"></div>
                    <span class="text-xs text-gray-700">&lt; 14% (Rendah)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded" style="background: linear-gradient(135deg, #fbbf24, #f59e0b)"></div>
                    <span class="text-xs text-gray-700">14-20% (Sedang)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded" style="background: linear-gradient(135deg, #fb923c, #f97316)"></div>
                    <span class="text-xs text-gray-700">20-30% (Tinggi)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 rounded" style="background: linear-gradient(135deg, #f87171, #ef4444)"></div>
                    <span class="text-xs text-gray-700">&gt; 30% (Sangat Tinggi)</span>
                </div>
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div id="mapLoadingOverlay" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent mb-3"></div>
                <p class="text-gray-700 font-medium">Memuat data peta...</p>
            </div>
        </div>
    </div>
</div>