@if($books->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100 mt-4">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
            <i class="ph ph-books text-4xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-2">{{ __('Koleksi Tidak Ditemukan') }}</h3>
        <p class="text-slate-500">{{ __('Maaf, tidak ada buku yang sesuai dengan pencarian Anda.') }}</p>
    </div>
@else
    <!-- Grid Layout -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
        @foreach($books as $book)
            <a href="{{ route('books.show', $book->id) }}" class="book-card bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col group"
               data-title="{{ strtolower($book->title) }}" 
               data-author="{{ strtolower($book->author) }}" 
               data-publisher="{{ strtolower($book->publisher) }}">
                
                <!-- Image Container -->
                <div class="aspect-[4/5] bg-[#e6f7f0] relative border-b border-slate-100/80 flex items-center justify-center overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        @include('partials.no-cover')
                    @endif
                    
                    <!-- Top Left Badge (Type) -->
                    <div class="absolute top-3 left-3 sm:top-3.5 sm:left-3.5 {{ $book->jenis_badge_color }} text-[10px] sm:text-[11px] font-bold px-2.5 sm:px-3 py-1 rounded-lg sm:rounded-xl shadow-sm tracking-wide uppercase z-10">
                        {{ $book->jenis_label }}
                    </div>

                    <!-- Category Badge on bottom left -->
                    <div class="absolute bottom-3 left-3 sm:bottom-3.5 sm:left-3.5 bg-white text-slate-800 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-lg sm:rounded-xl shadow-sm border border-slate-100/80 z-10 max-w-[85%] truncate">
                        {{ __($book->category ?: 'Umum') }}
                    </div>
                </div>

                <!-- Content Container -->
                <div class="p-3.5 sm:p-5 flex flex-col flex-grow justify-between">
                    <div>
                        <!-- Title -->
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 line-clamp-2 leading-snug mb-1.5 group-hover:text-[#106c38] transition-colors" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h3>

                        <!-- Author -->
                        <div class="text-xs sm:text-sm font-medium text-slate-400 mb-3 truncate" title="{{ $book->author }}">
                            {{ $book->author ?: '-' }}
                        </div>
                    </div>

                    <!-- Publisher Row -->
                    <div class="mt-auto flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-slate-500">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-50 text-[#106c38] flex items-center justify-center flex-shrink-0 border border-emerald-100/80">
                            <i class="ph ph-buildings text-[10px] sm:text-xs"></i>
                        </div>
                        <span class="truncate font-medium text-slate-600">{{ $book->publisher ?: '-' }}</span>
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
        <div class="flex items-center gap-1 sm:gap-1.5 flex-nowrap justify-center max-w-full">
            @if ($books->onFirstPage())
                <span class="p-2 sm:px-4 sm:py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed flex-shrink-0">
                    <i class="ph ph-caret-left text-base sm:text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                </span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="p-2 sm:px-4 sm:py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm flex-shrink-0">
                    <i class="ph ph-caret-left text-base sm:text-lg"></i> <span class="hidden sm:inline">{{ __('Sebelumnya') }}</span>
                </a>
            @endif

            <!-- Page Numbers -->
            <div class="flex items-center gap-1 flex-nowrap">
                @php
                    $current = $books->currentPage();
                    $last    = $books->lastPage();
                @endphp

                <!-- Mobile Page Numbers (5 compact buttons) -->
                <div class="flex sm:hidden items-center gap-1">
                    @php
                        $mWindow = 5;
                        $mHalf = (int) floor($mWindow / 2);
                        $mStart = max(1, min($current - $mHalf, $last - $mWindow + 1));
                        $mEnd = min($last, $mStart + $mWindow - 1);
                    @endphp
                    @for($p = $mStart; $p <= $mEnd; $p++)
                        @if($p == $current)
                            <span class="w-8 h-8 rounded-full bg-[#106c38] text-white flex items-center justify-center text-xs font-bold shadow-md shadow-green-900/20">{{ $p }}</span>
                        @else
                            <a href="{{ $books->url($p) }}" class="w-8 h-8 rounded-full border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 flex items-center justify-center text-xs font-bold transition-colors">{{ $p }}</a>
                        @endif
                    @endfor
                </div>

                <!-- Desktop Page Numbers -->
                <div class="hidden sm:flex items-center gap-1">
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
            </div>

            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="p-2 sm:px-4 sm:py-2 rounded-full border border-slate-200 text-slate-600 text-xs sm:text-sm font-medium flex items-center gap-1.5 hover:bg-slate-50 hover:text-[#106c38] transition-colors shadow-sm flex-shrink-0">
                    <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-base sm:text-lg"></i>
                </a>
            @else
                <span class="p-2 sm:px-4 sm:py-2 rounded-full border border-slate-100 text-slate-300 text-xs sm:text-sm font-medium flex items-center gap-1.5 bg-slate-50 cursor-not-allowed flex-shrink-0">
                    <span class="hidden sm:inline">{{ __('Berikutnya') }}</span> <i class="ph ph-caret-right text-base sm:text-lg"></i>
                </span>
            @endif
        </div>
    </div>
@endif
