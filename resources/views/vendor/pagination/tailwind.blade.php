@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center w-full my-6">

        <div class="flex items-center gap-2 sm:gap-3">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-400 bg-transparent border border-slate-200 rounded-full cursor-not-allowed select-none">
                    <i class="ph ph-caret-left text-base"></i>
                    <span class="hidden sm:block">Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-full hover:border-slate-300 hover:text-slate-800 hover:shadow-sm focus:outline-none active:bg-slate-50 transition-all ease-in-out duration-200 select-none" aria-label="{{ __('pagination.previous') }}">
                    <i class="ph ph-caret-left text-base"></i>
                    <span class="hidden sm:block">Sebelumnya</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-1 sm:gap-2">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-sm font-medium text-slate-400 select-none">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-sm font-bold text-white bg-[#106c38] rounded-full shadow-md select-none">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-sm font-semibold text-slate-600 hover:text-[#106c38] hover:bg-[#106c38]/10 rounded-full transition-all ease-in-out duration-200 select-none" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-full hover:border-slate-300 hover:text-slate-800 hover:shadow-sm focus:outline-none active:bg-slate-50 transition-all ease-in-out duration-200 select-none" aria-label="{{ __('pagination.next') }}">
                    <span class="hidden sm:block">Berikutnya</span>
                    <i class="ph ph-caret-right text-base"></i>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-400 bg-transparent border border-slate-200 rounded-full cursor-not-allowed select-none">
                    <span class="hidden sm:block">Berikutnya</span>
                    <i class="ph ph-caret-right text-base"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
