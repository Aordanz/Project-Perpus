<!-- Books Table -->
<div class="overflow-x-auto rounded-2xl border border-slate-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-center w-12">No.</th>
                <th class="px-5 py-4">Informasi Buku</th>
                <th class="px-5 py-4">No. Panggil / ISBN</th>
                <th class="px-5 py-4 text-center">Eksemplar</th>
                <th class="px-5 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
            @forelse($books as $book)
                <tr class="hover:bg-slate-50/30 transition">
                    <!-- Number -->
                    <td class="px-5 py-4 text-center text-xs font-semibold text-slate-400 w-12">
                        {{ $loop->iteration + ($books->firstItem() - 1) }}
                    </td>
                    <!-- Book Title & Cover/Author -->
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-14 bg-slate-100 rounded-md border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400">
                                @if($book->cover_image)
                                    <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                @else
                                    <i class="ph ph-book text-xl"></i>
                                @endif
                            </div>
                            <div class="max-w-[200px]">
                                <a href="{{ route('books.show', $book->id) }}" class="block font-bold text-slate-800 hover:text-usu-green truncate" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </a>
                                <span class="block text-xs text-slate-400 truncate mt-0.5" title="{{ $book->author }}">{{ $book->author }}</span>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Call Number & ISBN -->
                    <td class="px-5 py-4">
                        <span class="block text-slate-700 text-xs font-mono font-semibold">{{ $book->call_number ?: '-' }}</span>
                        <span class="block text-xs text-slate-400 font-medium mt-0.5">ISBN: {{ $book->isbn ?: '-' }}</span>
                    </td>

                    <!-- Copies Count & Available -->
                    <td class="px-5 py-4 text-center">
                        @php
                            $copies = $book->items->count();
                            $avail = $book->items->where('status', 'Tersedia')->count();
                        @endphp
                        <span class="inline-flex items-center gap-1 bg-[#106c38]/5 text-usu-green font-bold px-2.5 py-0.5 rounded-full text-xs">
                            {{ $avail }} / {{ $copies }} {{ __('Tersedia') }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-4 text-center">
                        @php
                            $additionalImages = $book->images->pluck('image_path')->map(function($path) {
                                return asset('covers/' . $path);
                            })->toArray();
                        @endphp
                        <div class="flex items-center justify-center gap-2">
                            @if($book->cover_image)
                                <button type="button" onclick="openUploadCoverModal(this)" data-id="{{ $book->id }}" data-title="{{ $book->title }}" data-author="{{ $book->author }}" data-cover="{{ asset('covers/' . $book->cover_image) }}" data-additional="{{ json_encode($additionalImages) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm border-none cursor-pointer">
                                    <i class="ph ph-pencil-simple font-bold text-sm"></i> Ubah Cover
                                </button>
                                
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeleteCover(this)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm border-none cursor-pointer">
                                        <i class="ph ph-trash font-bold text-sm"></i> Hapus Cover
                                    </button>
                                </form>
                            @else
                                <button type="button" onclick="openUploadCoverModal(this)" data-id="{{ $book->id }}" data-title="{{ $book->title }}" data-author="{{ $book->author }}" data-cover="" data-additional="{{ json_encode($additionalImages) }}" class="bg-[#106c38] hover:bg-green-700 text-white font-bold text-xs px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm border-none cursor-pointer">
                                    <i class="ph ph-plus-circle font-bold text-sm"></i> Tambah Cover
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                        <i class="ph ph-warning-circle text-4xl mb-2 text-slate-300"></i>
                        <p class="text-sm font-semibold">Tidak ada data buku yang ditemukan.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Custom Pagination Links -->
<div class="mt-4">
    {{ $books->links('admin.partials.pagination') }}
</div>
