<div 
    x-data="{ summaries: @js($residualSummary) }"
    class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-6"
>

    {{-- HIGH --}}
    <div class=" flex p-3 rounded-md bg-red-600 text-white text-center justify-center gap-5">
        <div class=" flex items-center">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="white"
                xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L1 21h22L12 2z"/>
            <rect x="11" y="8" width="2" height="7" fill="#000"/>
            <rect x="11" y="16.5" width="2" height="2" fill="#000"/>
            </svg>
        </div>

        <div>
            <p class="text-xs uppercase">High</p>
            <p class="text-2xl font-bold"
            x-text="summaries[activeDept]?.['High'] ?? 0"></p>
        </div>
    </div>

    {{-- MODERATE TO HIGH --}}
    <div class="p-3 rounded-md bg-orange-500 text-white text-center justify-center gap-5 flex">
        <div class=" flex items-center">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="white"
                xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10"/>
            <rect x="11" y="6" width="2" height="9" fill="#000"/>
            <rect x="11" y="16.5" width="2" height="2" fill="#000"/>
            </svg>
        </div>
        <div>
            <p class="text-xs uppercase">Mod–High</p>
            <p class="text-2xl font-bold"
            x-text="summaries[activeDept]?.['Moderate to High'] ?? 0"></p>
        </div>
    </div>

    {{-- MODERATE --}}
    <div class="p-3 rounded-md bg-yellow-500 text-white text-center justify-center gap-5 flex">
        <div class=" flex items-center">
            <svg width="35" height="35" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white" stroke-width="2">
            <path d="M12 3L2 21h20L12 3z"/>
            <line x1="12" y1="9" x2="12" y2="14"/>
            <circle cx="12" cy="17" r="1"/>
            </svg>
        </div>
        <div>
            <p class="text-xs uppercase">Moderate</p>
            <p class="text-2xl font-bold"
            x-text="summaries[activeDept]?.['Moderate'] ?? 0"></p>
        </div>
    </div>

    {{-- LOW TO MODERATE --}}
    <div class="p-3 rounded-md bg-green-500 text-white text-center justify-center gap-5 flex">
        <div class=" flex items-center">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="white"
                xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3v14"/>
            <path d="M6 13l6 6 6-6"/>
            </svg>

        </div>
        <div>
            <p class="text-xs uppercase">Low–Mod</p>
            <p class="text-2xl font-bold"
            x-text="summaries[activeDept]?.['Low to Moderate'] ?? 0"></p>
        </div>
    </div>

    {{-- LOW --}}
    <div class="p-3 rounded-md bg-green-700 text-white text-center justify-center gap-5 flex">
        <div class=" flex items-center">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="white"
                xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V6l8-4z"/>
            <path d="M9 12l2 2 4-4" stroke="#000" stroke-width="2" fill="none"/>
            </svg>
        </div>
        <div>
            <p class="text-xs uppercase">Low</p>
            <p class="text-2xl font-bold"
            x-text="summaries[activeDept]?.['Low'] ?? 0"></p>
        </div>
    </div>
</div>