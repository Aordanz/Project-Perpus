<!-- Book Gallery Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
    @forelse($books as $book)
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm book-card flex flex-col h-full group relative">
            <!-- Cover Image -->
            <div class="w-full aspect-[2/3] bg-slate-100 relative">
                @if($book->cover_image)
                    <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-2">
                        <i class="ph ph-book text-4xl"></i>
                        <span class="text-[10px] font-semibold uppercase tracking-wider">No Cover</span>
                    </div>
                @endif
                
                <!-- Overlay Actions -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                     <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-[#106c38]/85 hover:bg-[#106c38] text-white text-xs font-bold py-1.5 px-3 rounded-lg backdrop-blur-sm transition flex items-center gap-1.5">
                         <i class="ph ph-pencil-simple"></i> Edit
                     </a>
                </div>

                <!-- Status Badge -->
                @php
                    $avail = $book->items->where('status', 'Tersedia')->count();
                    $copies = $book->items->count();
                @endphp
                <div class="absolute top-2 left-2 {{ $avail > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                    {{ $avail > 0 ? $avail . ' Tersedia' : 'Habis' }}
                </div>
            </div>
            
            <!-- Book Info -->
            <div class="p-3 flex flex-col flex-grow justify-between gap-2">
                <div>
                    <h3 class="font-bold text-slate-800 text-xs leading-snug line-clamp-2" title="{{ $book->title }}">{{ $book->title }}</h3>
                    <p class="text-[10px] text-slate-500 mt-1 truncate" title="{{ $book->author }}">{{ $book->author }}</p>
                </div>
                <div class="text-[9px] font-mono font-semibold text-slate-400">
                    {{ $book->call_number ?: '-' }}
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-400">
            <i class="ph ph-books text-6xl mb-3 text-slate-200"></i>
            <p class="font-semibold text-lg text-slate-500">Tidak ada buku ditemukan</p>
            <p class="text-sm">Silakan tambahkan buku baru atau sesuaikan pencarian Anda.</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $books->links('admin.partials.pagination') }}
</div>
