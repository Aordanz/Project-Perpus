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

<!-- AI Assistant Chatbot -->
<div id="ai-chatbot-container" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end pointer-events-none">
    
    <!-- Chat Window -->
    <div id="ai-chat-window" class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-[320px] h-[400px] mb-4 flex flex-col overflow-hidden transition-all duration-300 origin-bottom-right scale-0 opacity-0 pointer-events-auto">
        <!-- Header -->
        <div class="bg-[#106c38] text-white p-3.5 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="ph ph-robot text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm tracking-wide">USU Library AI</h4>
                    <p class="text-[9px] text-green-100">Asisten Virtual Perpustakaan</p>
                </div>
            </div>
            <button id="ai-close-btn" class="text-white/80 hover:text-white transition-colors focus:outline-none">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <!-- Chat Area -->
        <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 flex flex-col gap-3 text-sm">
            <!-- Initial Message -->
            <div class="flex items-start gap-2 max-w-[85%]">
                <div class="w-6 h-6 rounded-full bg-[#106c38] text-white flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="ph ph-robot text-xs"></i>
                </div>
                <div class="bg-white border border-slate-200 text-slate-700 px-3 py-2 rounded-2xl rounded-tl-sm shadow-sm text-[13px] leading-relaxed">
                    Halo! Saya asisten virtual Perpustakaan USU. Ada yang bisa saya bantu mengenai informasi perpustakaan?
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-slate-100 flex items-center gap-2">
            <input type="text" id="ai-chat-input" placeholder="Ketik pesan Anda..." class="flex-grow px-3 py-2 bg-slate-100 border-none rounded-full text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#106c38]/30 transition-all">
            <button id="ai-send-btn" class="w-8 h-8 rounded-full bg-[#106c38] text-white flex items-center justify-center hover:bg-green-800 transition-colors shadow-sm focus:outline-none flex-shrink-0">
                <i class="ph ph-paper-plane-tilt text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="ai-toggle-btn" class="w-14 h-14 rounded-full bg-[#106c38] text-white flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-105 transition-all focus:outline-none pointer-events-auto border-4 border-white">
        <i class="ph ph-chat-teardrop-text text-2xl"></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('ai-toggle-btn');
        const closeBtn = document.getElementById('ai-close-btn');
        const chatWindow = document.getElementById('ai-chat-window');
        const chatInput = document.getElementById('ai-chat-input');
        const sendBtn = document.getElementById('ai-send-btn');
        const messagesContainer = document.getElementById('ai-chat-messages');

        // Toggle chat window
        function toggleChat() {
            if (chatWindow.classList.contains('scale-0')) {
                chatWindow.classList.remove('scale-0', 'opacity-0');
                chatWindow.classList.add('scale-100', 'opacity-100');
                setTimeout(() => chatInput.focus(), 300);
            } else {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-0', 'opacity-0');
            }
        }

        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Send message
        function sendMessage() {
            const text = chatInput.value.trim();
            if (!text) return;

            // Add User Message
            addMessage(text, 'user');
            chatInput.value = '';

            // Simulate typing delay
            setTimeout(() => {
                const response = getAIResponse(text.toLowerCase());
                addMessage(response, 'bot');
            }, 800);
        }

        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });

        // Add message to DOM
        function addMessage(text, sender) {
            const msgDiv = document.createElement('div');
            
            if (sender === 'user') {
                msgDiv.className = "flex justify-end w-full";
                msgDiv.innerHTML = `
                    <div class="max-w-[85%] bg-[#106c38] text-white px-3 py-2 rounded-2xl rounded-tr-sm shadow-sm text-[13px] leading-relaxed">
                        ${text}
                    </div>
                `;
            } else {
                msgDiv.className = "flex items-start gap-2 max-w-[85%]";
                msgDiv.innerHTML = `
                    <div class="w-6 h-6 rounded-full bg-[#106c38] text-white flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="ph ph-robot text-xs"></i>
                    </div>
                    <div class="bg-white border border-slate-200 text-slate-700 px-3 py-2 rounded-2xl rounded-tl-sm shadow-sm text-[13px] leading-relaxed">
                        ${text}
                    </div>
                `;
            }

            messagesContainer.appendChild(msgDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Mock AI Logic
        function getAIResponse(text) {
            const knowledgeBase = [
                { keywords: ['jam', 'buka', 'waktu', 'operasional'], response: 'Jam operasional Perpustakaan USU adalah Senin - Jumat dari jam 08.00 hingga 16.00 WIB. Hari Sabtu, Minggu, dan Libur Nasional tutup.' },
                { keywords: ['lokasi', 'dimana', 'alamat'], response: 'Perpustakaan Universitas Sumatera Utara berlokasi di Jl. Perpustakaan No.1, Kampus USU, Padang Bulan, Kota Medan, Sumatera Utara.' },
                { keywords: ['pinjam', 'meminjam', 'peminjaman'], response: 'Untuk meminjam buku, Anda harus terdaftar sebagai anggota perpustakaan (mahasiswa/dosen USU) dan membawa KTM. Anda dapat meminjam maksimal 3 buku selama 1 minggu.' },
                { keywords: ['denda', 'terlambat'], response: 'Keterlambatan pengembalian buku akan dikenakan denda sesuai dengan peraturan yang berlaku di Perpustakaan USU. Pastikan mengembalikan buku tepat waktu.' },
                { keywords: ['syarat', 'anggota', 'mendaftar'], response: 'Mahasiswa aktif USU secara otomatis menjadi anggota perpustakaan menggunakan Kartu Tanda Mahasiswa (KTM). Silakan aktivasi KTM Anda di meja sirkulasi.' },
                { keywords: ['opac', 'cari buku', 'katalog'], response: 'Anda dapat mencari koleksi buku kami melalui fitur pencarian di OPAC ini. Gunakan judul, nama pengarang, atau ISBN.' },
                { keywords: ['kontak', 'hubungi', 'email'], response: 'Anda dapat menghubungi kami melalui halaman Kontak Kami di menu navigasi, atau mengirim email ke library@usu.ac.id.' },
                { keywords: ['halo', 'hai', 'pagi', 'siang', 'sore'], response: 'Halo! Ada yang bisa saya bantu terkait Perpustakaan USU hari ini?' },
                { keywords: ['terima kasih', 'makasih', 'oke', 'baik'], response: 'Sama-sama! Jika ada pertanyaan lain seputar perpustakaan, jangan ragu untuk bertanya.' }
            ];

            for (const item of knowledgeBase) {
                if (item.keywords.some(kw => text.includes(kw))) {
                    return item.response;
                }
            }

            return 'Maaf, saya hanya diprogram untuk menjawab pertanyaan seputar informasi dasar Perpustakaan Universitas Sumatera Utara. Bisakah Anda memberikan pertanyaan yang lebih spesifik?';
        }
    });
</script>
