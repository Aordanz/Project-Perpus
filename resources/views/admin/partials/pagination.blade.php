<div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-200">
    <!-- Limit Selector -->
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
        <span>Tampilkan:</span>
        <div class="relative inline-block text-left" id="admin-limit-dropdown">
            <!-- Dropdown Trigger Button -->
            <button type="button" id="admin-limit-trigger" onclick="const menu = document.getElementById('admin-limit-menu'); if (menu) { menu.classList.toggle('hidden'); const caret = this.querySelector('.ph-caret-down'); if (caret) caret.classList.toggle('rotate-180'); } event.stopPropagation();" class="flex items-center justify-between gap-4 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-full pl-4 pr-3 py-2 outline-none cursor-pointer hover:border-[#106c38] focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all shadow-sm min-w-[75px]">
                <span id="admin-limit-label">{{ request('limit', 10) == 'all' ? 'Semua' : request('limit', 10) }}</span>
                <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
            </button>
            
            <!-- Dropdown Options Menu -->
            <div id="admin-limit-menu" class="hidden absolute left-0 bottom-full mb-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 transition-all">
                @foreach([10, 25, 50, 'all'] as $val)
                    @php
                        $currentLimit = request('limit', 10);
                        $isSelected = $currentLimit == $val;
                        $label = $val == 'all' ? 'Semua' : $val;
                        $url = request()->fullUrlWithQuery(['limit' => $val, 'page' => 1]);
                    @endphp
                    <a href="{{ $url }}" onclick="if(window.performSearch){ event.preventDefault(); const inp = document.getElementById('admin-limit-select'); if(inp) inp.value='{{ $val }}'; document.getElementById('admin-limit-menu').classList.add('hidden'); window.performSearch(); }" class="admin-limit-option w-full text-left px-4 py-2.5 text-xs transition flex items-center justify-between no-underline {{ $isSelected ? 'text-[#106c38] font-bold bg-green-50/50' : 'text-slate-600 font-semibold hover:bg-green-50 hover:text-[#106c38]' }}">
                        <span>{{ $label }}</span>
                        <i class="ph ph-check text-[12px] limit-active-check {{ $isSelected ? '' : 'hidden' }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Page Navigation Buttons -->
    @if ($paginator->hasPages())
        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold text-slate-300 bg-white border border-slate-100 rounded-full cursor-not-allowed select-none">
                    <i class="ph ph-caret-left"></i> Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" onclick="if(window.performSearch){ event.preventDefault(); window.performSearch(this.href); }" class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-full hover:border-[#106c38] hover:text-[#106c38] transition shadow-sm cursor-pointer no-underline">
                    <i class="ph ph-caret-left"></i> Sebelumnya
                </a>
            @endif

            {{-- Pagination Elements (Sliding Window of size at most 5) --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                
                $start = $currentPage - 2;
                $end = $currentPage + 2;
                
                if ($start < 1) {
                    $end = min($lastPage, $end + (1 - $start));
                    $start = 1;
                }
                
                if ($end > $lastPage) {
                    $start = max(1, $start - ($end - $lastPage));
                    $end = $lastPage;
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span class="w-8 h-8 rounded-full bg-[#106c38] flex items-center justify-center text-xs font-bold text-white shadow-md shadow-[#106c38]/20 select-none">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}" onclick="if(window.performSearch){ event.preventDefault(); window.performSearch(this.href); }" class="w-8 h-8 rounded-full border border-slate-200 bg-white hover:border-[#106c38] hover:text-[#106c38] flex items-center justify-center text-xs font-bold text-slate-600 transition shadow-sm cursor-pointer no-underline">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" onclick="if(window.performSearch){ event.preventDefault(); window.performSearch(this.href); }" class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-full hover:border-[#106c38] hover:text-[#106c38] transition shadow-sm cursor-pointer no-underline">
                    Berikutnya <i class="ph ph-caret-right"></i>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-4 py-2 text-xs font-bold text-slate-300 bg-white border border-slate-100 rounded-full cursor-not-allowed select-none">
                    Berikutnya <i class="ph ph-caret-right"></i>
                </span>
            @endif
        </div>
    @endif
</div>

<script>
    // Global click listener to close limit dropdown
    document.addEventListener('click', () => {
        const menu = document.getElementById('admin-limit-menu');
        if (menu) {
            menu.classList.add('hidden');
            const triggerBtn = document.getElementById('admin-limit-trigger');
            if (triggerBtn) {
                const caret = triggerBtn.querySelector('.ph-caret-down');
                if (caret) caret.classList.remove('rotate-180');
            }
        }
    });
</script>
