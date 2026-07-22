@if($books->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100 mt-4">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
            <i class="ph ph-books text-4xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-2">{{ __('Koleksi Tidak Ditemukan') }}</h3>
        <p class="text-slate-500">{{ __('Maaf, tidak ada buku yang sesuai dengan pencarian Anda.') }}</p>
    </div>
@else
    <!-- Grid Layout mimicking Tokopedia -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3">
        @foreach($books as $book)
            <a href="{{ route('books.show', $book->id) }}" class="book-card bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col group"
               data-title="{{ strtolower($book->title) }}" 
               data-author="{{ strtolower($book->author) }}" 
               data-publisher="{{ strtolower($book->publisher) }}">
                
                <!-- Image Container -->
                <div class="aspect-[4/5] bg-slate-50 relative border-b border-slate-100 flex items-center justify-center overflow-hidden p-2">
                    @if($book->cover_image)
                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-md shadow-[0_4px_10px_rgba(0,0,0,0.1)] group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-300">
                            <i class="ph ph-book-open text-4xl mb-1"></i>
                            <span class="text-[9px] font-bold uppercase">{{ __('No Cover') }}</span>
                        </div>
                    @endif
                    
                    <!-- Top Left Badge (Type) -->
                    <div class="absolute top-0 left-0 bg-[#ef4444] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-br-lg shadow-sm">
                        {{ strtoupper(__($book->jenis)) }}
                    </div>

                    <!-- Category Badge on bottom left -->
                    <div class="absolute bottom-1 left-1 bg-white/90 backdrop-blur-sm text-slate-700 text-[8px] font-bold px-1.5 py-0.5 rounded shadow-sm border border-slate-100/50">
                        {{ __($book->category ?: 'Umum') }}
                    </div>
                </div>

                <!-- Content Container -->
                <div class="p-2 sm:p-2.5 flex flex-col flex-grow">
                    <!-- Title -->
                    <h3 class="text-[13px] sm:text-[15px] font-extrabold text-slate-900 line-clamp-2 leading-snug mb-1.5 group-hover:text-[#106c38] transition-colors" title="{{ $book->title }}">
                        {{ $book->title }}
                    </h3>

                    <!-- Author (acting as Price visual) -->
                    <div class="text-[12px] sm:text-[13px] font-medium text-slate-500 mb-0.5 truncate" title="{{ $book->author }}">
                        {{ $book->author ?: '-' }}
                    </div>

                    <!-- Availability (acting as promo text) -->
                    @php
                        $totalCopies = $book->items->count();
                        $availableCopies = $book->items->filter(function($item) { return strtolower($item->status) === 'tersedia'; })->count();
                    @endphp
                    
                    <div class="mt-auto">


                        <!-- Publisher Row (acting as Store Name) -->
                        <div class="flex items-center gap-1 text-[9px] sm:text-[10px] text-slate-500">
                            <div class="w-3.5 h-3.5 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100/60">
                                <i class="ph ph-buildings text-[9px]"></i>
                            </div>
                            <span class="truncate font-medium">{{ $book->publisher ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Custom Pagination -->
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100 pt-6">
        <!-- Items Per Page Dropdown -->
        <div class="flex items-center gap-3">
            <span class="text-sm font-semibold text-slate-500">{{ __('Tampilkan:') }}</span>
            <div class="relative">
                <!-- Dropdown Trigger Button -->
                <button type="button" id="per-dropdown-trigger" class="flex items-center justify-between gap-4 bg-white border border-emerald-600/35 text-slate-700 text-xs font-bold rounded-full pl-4 pr-3 py-1.5 outline-none cursor-pointer hover:border-emerald-600 focus:border-[#106c38] focus:ring-4 focus:ring-[#106c38]/10 transition-all shadow-sm min-w-[75px]">
                    <span id="per-selected-label">
                        {{ $perPage }}
                    </span>
                    <i class="ph ph-caret-down text-[10px] text-slate-400"></i>
                </button>
                
                <!-- Dropdown Options Menu -->
                <div id="per-dropdown-menu" class="hidden absolute left-0 bottom-full mb-2 w-28 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-50 transition-all">
                    @foreach([10, 24, 48, 100] as $val)
                        @php
                            $isSelected = ($perPage == $val);
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['per' => $val, 'page' => 1]) }}" 
                           class="w-full text-left px-4 py-2.5 text-xs font-bold transition flex items-center justify-between {{ $isSelected ? 'text-[#106c38] bg-green-50/50 hover:bg-green-50' : 'text-slate-600 hover:bg-green-50 hover:text-[#106c38]' }}">
                            <span>{{ $val }}</span>
                            <i class="ph ph-check text-[12px] {{ $isSelected ? '' : 'hidden' }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination Buttons -->
        <div class="flex items-center gap-1.5">
            @if ($books->onFirstPage())
                <span class="px-3 sm:px-4 py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed">
                    <i class="ph ph-caret-left text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                </span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="px-3 sm:px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm">
                    <i class="ph ph-caret-left text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                </a>
            @endif

            <!-- Page Numbers -->
            <div class="flex items-center gap-1">
                @php
                    $window = \Illuminate\Pagination\UrlWindow::make($books);
                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);
                @endphp
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-slate-400 text-xs sm:text-sm font-bold">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $books->currentPage())
                                <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#106c38] text-white flex items-center justify-center text-xs sm:text-sm font-bold shadow-md shadow-green-900/20">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full border border-transparent text-slate-600 hover:border-slate-200 hover:bg-slate-50 flex items-center justify-center text-xs sm:text-sm font-bold transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="px-3 sm:px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm">
                    <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-lg"></i>
                </a>
            @else
                <span class="px-3 sm:px-4 py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed">
                    <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-lg"></i>
                </span>
            @endif
        </div>
    </div>
@endif
