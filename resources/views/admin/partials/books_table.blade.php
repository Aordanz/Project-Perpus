<!-- Books Table -->
<div class="overflow-x-auto rounded-2xl border border-slate-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold text-xs uppercase tracking-wider">
                <th class="px-5 py-4">Informasi Buku</th>
                <th class="px-5 py-4">No. Panggil / ISBN</th>
                <th class="px-5 py-4 text-center">Eksemplar</th>
                <th class="px-5 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-600">
            @forelse($books as $book)
                <tr class="hover:bg-slate-50/30 transition">
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
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('books.show', $book->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-green-50 text-slate-600 hover:text-usu-green flex items-center justify-center border border-slate-200/60 transition" title="Lihat Halaman Detail">
                                <i class="ph ph-eye text-base"></i>
                            </a>

                            <a href="{{ route('admin.books.edit', $book->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 flex items-center justify-center border border-slate-200/60 transition" title="Edit Buku">
                                <i class="ph ph-pencil-simple text-base"></i>
                            </a>
                            
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeleteBook(this)" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-600 flex items-center justify-center border border-slate-200/60 transition cursor-pointer" title="Hapus Buku">
                                    <i class="ph ph-trash text-base"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
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
