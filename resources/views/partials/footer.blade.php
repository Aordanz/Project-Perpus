<!-- Footer -->
<footer class="bg-[#106c38] py-2.5 sm:py-4 text-white text-center text-[10px] sm:text-xs md:text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="mb-1 sm:mb-1.5 text-white/90">
            &copy; 2025 University of Sumatera Utara Library | OPAC. All rights reserved.
        </p>
        <div class="flex flex-wrap justify-center gap-x-2 gap-y-1 items-center text-white/80">
            <a href="https://www.usu.ac.id/" target="_blank" class="hover:text-white transition">Universitas Sumatera Utara</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id" target="_blank" class="hover:text-white transition">Perpustakaan USU</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://repositori.usu.ac.id/" target="_blank" class="hover:text-white transition">USU-IR</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="hover:text-white transition">Scientific eJournals</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="hover:text-white transition">Scientific eBooks</a>
            @guest
                <span class="text-white/30 hidden sm:inline">|</span>
                <a href="{{ route('login') }}" class="text-white/40 hover:text-white/80 transition text-[9px] sm:text-xs select-none decoration-none">Pustakawan</a>
            @endguest
        </div>
    </div>
</footer>

<!-- Global Live Search Logic (Fuzzy & Levenshtein) -->
<script>
    // Fungsi perhitungan jarak Levenshtein untuk mengukur tingkat "typo"
    window.getLevenshteinDistance = (a, b) => {
        if(a.length === 0) return b.length;
        if(b.length === 0) return a.length;

        const matrix = [];
        for(let i = 0; i <= b.length; i++){ matrix[i] = [i]; }
        for(let j = 0; j <= a.length; j++){ matrix[0][j] = j; }

        for(let i = 1; i <= b.length; i++){
            for(let j = 1; j <= a.length; j++){
                if(b.charAt(i-1) === a.charAt(j-1)){
                    matrix[i][j] = matrix[i-1][j-1];
                } else {
                    matrix[i][j] = Math.min(matrix[i-1][j-1] + 1, Math.min(matrix[i][j-1] + 1, matrix[i-1][j] + 1));
                }
            }
        }
        return matrix[b.length][a.length];
    };

    // Fungsi pencocokan canggih yang menoleransi typo dan spasi/tanda hubung
    window.isFuzzyMatch = (text, query) => {
        if (!query) return true;
        
        // Normalisasi: ubah karakter spesial (seperti tanda hubung) jadi spasi dan bersihkan
        const normText = text.replace(/[^a-z0-9]/gi, ' ').replace(/\s+/g, ' ').trim();
        const normQuery = query.replace(/[^a-z0-9]/gi, ' ').replace(/\s+/g, ' ').trim();
        
        if (normText.includes(normQuery)) return true;

        const queryWords = normQuery.split(' ');
        const textWords = normText.split(' ');

        let allWordsMatched = true;
        for (let qWord of queryWords) {
            if (qWord.length === 0) continue;
            
            let wordMatched = false;
            for (let tWord of textWords) {
                if (tWord.includes(qWord)) {
                    wordMatched = true;
                    break;
                }
                
                // Batas toleransi typo: jika kata pendek max typo 1 huruf, jika panjang max 2 huruf
                const maxTypo = qWord.length <= 4 ? 1 : 2;
                if (Math.abs(tWord.length - qWord.length) <= maxTypo) {
                    if (window.getLevenshteinDistance(tWord, qWord) <= maxTypo) {
                        wordMatched = true;
                        break;
                    }
                }
            }
            
            if (!wordMatched) {
                allWordsMatched = false;
                break;
            }
        }

        return allWordsMatched;
    };

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('live-search-input');
        const bookCards = document.querySelectorAll('.book-card');

        if(searchInput && bookCards.length > 0) {
            searchInput.addEventListener('input', function(e) {
                const keyword = e.target.value.toLowerCase().trim();

                bookCards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const author = card.getAttribute('data-author') || '';
                    const publisher = card.getAttribute('data-publisher') || '';

                    // Cek apakah ada kecocokan typo di salah satu data
                    if (window.isFuzzyMatch(title, keyword) || window.isFuzzyMatch(author, keyword) || window.isFuzzyMatch(publisher, keyword)) {
                        card.classList.remove('!hidden');
                    } else {
                        card.classList.add('!hidden');
                    }
                });
            });
        }
    });
</script>
