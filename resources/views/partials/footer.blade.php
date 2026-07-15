<!-- Footer -->
<footer class="bg-[#106c38] py-2.5 sm:py-3.5 text-white text-center text-xs sm:text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="mb-1.5 sm:mb-2 text-white/90">
            &copy; 2025 {{ __('University of Sumatera Utara Library') }} | OPAC. {{ __('All rights reserved.') }}
        </p>
        <div class="flex flex-wrap justify-center gap-x-3 gap-y-1 sm:gap-x-2 sm:gap-y-1 items-center text-white/80">
            <a href="https://www.usu.ac.id/" target="_blank" class="hover:text-white transition inline-block py-0.5 px-1.5 rounded hover:bg-white/5">{{ __('Universitas Sumatera Utara') }}</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id" target="_blank" class="hover:text-white transition inline-block py-0.5 px-1.5 rounded hover:bg-white/5">{{ __('Perpustakaan USU') }}</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://repositori.usu.ac.id/" target="_blank" class="hover:text-white transition inline-block py-0.5 px-1.5 rounded hover:bg-white/5">USU-IR</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id/jurnal-elektronik" target="_blank" class="hover:text-white transition inline-block py-0.5 px-1.5 rounded hover:bg-white/5">{{ __('Scientific eJournals') }}</a>
            <span class="text-white/30 hidden sm:inline">|</span>
            <a href="https://library.usu.ac.id/id/buku-elektronik" target="_blank" class="hover:text-white transition inline-block py-0.5 px-1.5 rounded hover:bg-white/5">{{ __('Scientific eBooks') }}</a>
            @guest
                <span class="text-white/30 hidden sm:inline">|</span>
                <a href="{{ route('login') }}" class="hover:text-white transition text-white/80 inline-block py-0.5 px-1.5 rounded hover:bg-white/5">{{ __('Pustakawan') }}</a>
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

</script>

<!-- AI Assistant Chatbot -->
<div id="ai-chatbot-container" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end pointer-events-none">
    
    <!-- Chat Window -->
    <div id="ai-chat-window" class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-[320px] h-[400px] mb-4 flex flex-col overflow-hidden transition-all duration-300 origin-bottom-right scale-0 opacity-0 pointer-events-auto">
        <!-- Header (draggable) -->
        <div id="ai-chat-header" class="bg-[#106c38] text-white p-3.5 flex items-center justify-between shadow-sm cursor-grab active:cursor-grabbing select-none">
            <div class="flex items-center gap-2 sm:gap-3">
                <button id="ai-expand-btn" class="text-white/80 hover:text-white transition-colors focus:outline-none" title="{{ __('Perbesar Layar') }}">
                    <i class="ph ph-corners-out text-lg" id="ai-expand-icon"></i>
                </button>
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="ph ph-headset text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm tracking-wide">USU Library AI</h4>
                    <p class="text-[9px] text-green-100">{{ __('Asisten Virtual Perpustakaan') }}</p>
                </div>
            </div>
            <button id="ai-close-btn" class="text-white/80 hover:text-white transition-colors focus:outline-none" title="{{ __('Tutup') }}">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>

        <!-- Chat Area -->
        <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 flex flex-col gap-3 text-sm">
            <!-- Initial Message -->
            <div class="flex items-start gap-2 max-w-[90%]">
                <div class="w-6 h-6 rounded-full bg-[#106c38] text-white flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="ph ph-headset text-xs"></i>
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <div class="bg-white border border-slate-200 text-slate-700 pl-3 pr-3 pt-2 pb-7 rounded-2xl rounded-tl-sm shadow-sm text-[13px] leading-relaxed relative group">
                        <span>{{ __('Halo! Saya asisten virtual Perpustakaan USU. Ada yang bisa saya bantu mengenai informasi perpustakaan?') }}</span>
                        <button id="ai-suggestions-toggle" aria-label="{{ __('Tampilkan Rekomendasi Pertanyaan') }}" class="absolute bottom-1 right-1 w-6 h-6 flex items-center justify-center rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors border border-slate-200 focus:outline-none flex-shrink-0 shadow-sm">
                            <i class="ph ph-caret-down text-xs transition-transform duration-300" id="ai-suggestions-icon"></i>
                        </button>
                    </div>
                    
                    <!-- Suggestions Dropdown -->
                    <div id="ai-suggestions-list" class="hidden flex-col gap-1.5 mt-1 ml-1 scale-y-0 opacity-0 transform origin-top transition-all duration-300">
                        <button class="ai-suggestion-btn text-left px-3 py-2 bg-green-50 hover:bg-green-100 text-[#106c38] text-xs rounded-xl border border-green-200/50 transition-colors shadow-sm">
                            {{ __('Jam berapa perpustakaan buka?') }}
                        </button>
                        <button class="ai-suggestion-btn text-left px-3 py-2 bg-green-50 hover:bg-green-100 text-[#106c38] text-xs rounded-xl border border-green-200/50 transition-colors shadow-sm">
                            {{ __('Apa saja syarat peminjaman buku?') }}
                        </button>
                        <button class="ai-suggestion-btn text-left px-3 py-2 bg-green-50 hover:bg-green-100 text-[#106c38] text-xs rounded-xl border border-green-200/50 transition-colors shadow-sm">
                            {{ __('Fasilitas apa yang tersedia di perpustakaan?') }}
                        </button>
                        <button class="ai-suggestion-btn text-left px-3 py-2 bg-green-50 hover:bg-green-100 text-[#106c38] text-xs rounded-xl border border-green-200/50 transition-colors shadow-sm">
                            {{ __('Berapa batas maksimal pinjam buku?') }}
                        </button>
                        <button class="ai-suggestion-btn text-left px-3 py-2 bg-green-50 hover:bg-green-100 text-[#106c38] text-xs rounded-xl border border-green-200/50 transition-colors shadow-sm">
                            {{ __('Apakah ada denda keterlambatan?') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-slate-100 flex items-center gap-2">
            <input type="text" id="ai-chat-input" placeholder="{{ __('Ketik pesan Anda...') }}" class="flex-grow px-3 py-2 bg-slate-100 border-none rounded-full text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#106c38]/30 transition-all">
            <button id="ai-send-btn" aria-label="{{ __('Kirim Pesan') }}" class="w-8 h-8 rounded-full bg-[#106c38] text-white flex items-center justify-center hover:bg-green-800 transition-colors shadow-sm focus:outline-none flex-shrink-0">
                <i class="ph ph-paper-plane-tilt text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Intro Bubble -->
    <div id="ai-intro-bubble" class="relative mb-4 mr-2 transition-all duration-500 scale-0 opacity-0 origin-bottom-right pointer-events-auto">
        <div class="bg-white text-slate-800 px-4 py-3.5 rounded-[18px] text-xs font-medium flex items-center gap-3 max-w-[280px] relative shadow-[0_2px_16px_rgba(0,0,0,0.12)]">
            <div class="w-9 h-9 rounded-full bg-[#F3C300] text-[#106c38] flex items-center justify-center flex-shrink-0 font-bold">
                <i class="ph ph-headset text-lg"></i>
            </div>
            <div class="flex-grow min-w-0">
                <p class="font-bold text-[#106c38] text-[11px] mb-0.5">{{ __('USU Library AI') }}</p>
                <p class="text-slate-500 text-[10px] leading-relaxed">{{ __('Ada yang bisa dibantu? Tanya asisten AI di sini!') }}</p>
            </div>
            <button id="ai-close-bubble-btn" aria-label="{{ __('Tutup Balon Info') }}" class="text-slate-300 hover:text-slate-500 transition-colors focus:outline-none ml-0.5 cursor-pointer self-start mt-0.5">
                <i class="ph ph-x text-[10px]"></i>
            </button>
        </div>
        <!-- Speech bubble tail (bottom-right, curved like classic comic bubble) -->
        <svg class="absolute -bottom-[14px] right-[18px] w-[24px] h-[16px] drop-shadow-[0_2px_4px_rgba(0,0,0,0.06)]" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0 C4 0, 8 0, 12 0 C12 4, 14 10, 24 16 C16 14, 8 10, 4 6 C2 4, 0 2, 0 0 Z" fill="white"/>
        </svg>
    </div>

    <!-- Toggle Button -->
    <div id="ai-toggle-wrapper" class="relative pointer-events-auto group">
        <!-- Main Button -->
        <button id="ai-toggle-btn" aria-label="{{ __('Buka Asisten AI') }}" class="relative w-14 h-14 rounded-full bg-[#F3C300] hover:bg-[#e0b400] text-[#106c38] flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-105 transition-all focus:outline-none border-4 border-white cursor-pointer z-10">
            <i class="ph ph-chat-circle-dots text-2xl"></i>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('ai-toggle-btn');
        const toggleWrapper = document.getElementById('ai-toggle-wrapper');
        const pulseRing = document.getElementById('ai-pulse-ring');
        const introBubble = document.getElementById('ai-intro-bubble');
        const closeBubbleBtn = document.getElementById('ai-close-bubble-btn');
        
        const closeBtn = document.getElementById('ai-close-btn');
        const expandBtn = document.getElementById('ai-expand-btn');
        const expandIcon = document.getElementById('ai-expand-icon');
        const chatWindow = document.getElementById('ai-chat-window');
        const chatInput = document.getElementById('ai-chat-input');
        const sendBtn = document.getElementById('ai-send-btn');
        const messagesContainer = document.getElementById('ai-chat-messages');
        
        const suggestionsToggle = document.getElementById('ai-suggestions-toggle');
        const suggestionsIcon = document.getElementById('ai-suggestions-icon');
        const suggestionsList = document.getElementById('ai-suggestions-list');
        const suggestionBtns = document.querySelectorAll('.ai-suggestion-btn');

        if (suggestionsToggle) {
            suggestionsToggle.addEventListener('click', () => {
                const isHidden = suggestionsList.classList.contains('hidden');
                if (isHidden) {
                    suggestionsList.classList.remove('hidden');
                    setTimeout(() => {
                        suggestionsList.classList.remove('scale-y-0', 'opacity-0');
                    }, 10);
                    suggestionsIcon.classList.add('rotate-180');
                } else {
                    suggestionsList.classList.add('scale-y-0', 'opacity-0');
                    suggestionsIcon.classList.remove('rotate-180');
                    setTimeout(() => {
                        suggestionsList.classList.add('hidden');
                    }, 300);
                }
            });
        }

        suggestionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                chatInput.value = btn.textContent.trim();
                sendMessage();
                suggestionsList.classList.add('scale-y-0', 'opacity-0');
                suggestionsIcon.classList.remove('rotate-180');
                setTimeout(() => {
                    suggestionsList.classList.add('hidden');
                }, 300);
            });
        });

        // Bubble popup helpers
        let bubbleTimeout;
        function showIntroBubble() {
            if (introBubble && chatWindow.classList.contains('scale-0')) {
                introBubble.classList.remove('scale-0', 'opacity-0');
                introBubble.classList.add('scale-100', 'opacity-100');
                
                // Auto hide after 8 seconds
                bubbleTimeout = setTimeout(() => {
                    hideIntroBubble();
                }, 8000);
            }
        }

        function hideIntroBubble() {
            if (introBubble && !introBubble.classList.contains('scale-0')) {
                introBubble.classList.remove('scale-100', 'opacity-100');
                introBubble.classList.add('scale-0', 'opacity-0');
            }
        }

        if (closeBubbleBtn) {
            closeBubbleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (bubbleTimeout) clearTimeout(bubbleTimeout);
                hideIntroBubble();
            });
        }

        // Trigger showIntroBubble after 2 seconds only on first visit per session
        if (!sessionStorage.getItem('chatbotIntroSeen')) {
            setTimeout(showIntroBubble, 2000);
            sessionStorage.setItem('chatbotIntroSeen', 'true');
        }

        // --- Drag-to-move logic ---
        const chatHeader = document.getElementById('ai-chat-header');
        let isDragging = false;
        let dragOffsetX = 0;
        let dragOffsetY = 0;
        let hasDragPosition = false;

        function resetDragPosition() {
            chatWindow.style.position = '';
            chatWindow.style.left = '';
            chatWindow.style.top = '';
            chatWindow.style.right = '';
            chatWindow.style.bottom = '';
            hasDragPosition = false;
        }

        if (chatHeader) {
            chatHeader.addEventListener('mousedown', (e) => {
                // Don't drag if clicking buttons inside header or if expanded
                if (e.target.closest('button') || chatWindow.classList.contains('expanded-mode')) return;
                isDragging = true;
                const rect = chatWindow.getBoundingClientRect();
                dragOffsetX = e.clientX - rect.left;
                dragOffsetY = e.clientY - rect.top;
                chatWindow.style.transition = 'none';
                chatHeader.style.cursor = 'grabbing';
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                let newLeft = e.clientX - dragOffsetX;
                let newTop = e.clientY - dragOffsetY;

                // Keep within viewport bounds
                const ww = window.innerWidth;
                const wh = window.innerHeight;
                const cw = chatWindow.offsetWidth;
                const ch = chatWindow.offsetHeight;
                newLeft = Math.max(0, Math.min(newLeft, ww - cw));
                newTop = Math.max(0, Math.min(newTop, wh - ch));

                chatWindow.style.position = 'fixed';
                chatWindow.style.left = newLeft + 'px';
                chatWindow.style.top = newTop + 'px';
                chatWindow.style.right = 'auto';
                chatWindow.style.bottom = 'auto';
                hasDragPosition = true;
            });

            document.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    chatWindow.style.transition = '';
                    chatHeader.style.cursor = '';
                }
            });

            // Touch support for mobile
            chatHeader.addEventListener('touchstart', (e) => {
                if (e.target.closest('button') || chatWindow.classList.contains('expanded-mode')) return;
                isDragging = true;
                const touch = e.touches[0];
                const rect = chatWindow.getBoundingClientRect();
                dragOffsetX = touch.clientX - rect.left;
                dragOffsetY = touch.clientY - rect.top;
                chatWindow.style.transition = 'none';
            }, { passive: true });

            document.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                const touch = e.touches[0];
                let newLeft = touch.clientX - dragOffsetX;
                let newTop = touch.clientY - dragOffsetY;
                const ww = window.innerWidth;
                const wh = window.innerHeight;
                const cw = chatWindow.offsetWidth;
                const ch = chatWindow.offsetHeight;
                newLeft = Math.max(0, Math.min(newLeft, ww - cw));
                newTop = Math.max(0, Math.min(newTop, wh - ch));
                chatWindow.style.position = 'fixed';
                chatWindow.style.left = newLeft + 'px';
                chatWindow.style.top = newTop + 'px';
                chatWindow.style.right = 'auto';
                chatWindow.style.bottom = 'auto';
                hasDragPosition = true;
            }, { passive: false });

            document.addEventListener('touchend', () => {
                if (isDragging) {
                    isDragging = false;
                    chatWindow.style.transition = '';
                }
            });
        }

        // Toggle chat window
        function toggleChat() {
            if (chatWindow.classList.contains('scale-0')) {
                chatWindow.classList.remove('scale-0', 'opacity-0');
                chatWindow.classList.add('scale-100', 'opacity-100');
                if (pulseRing) pulseRing.classList.add('hidden');
                if (bubbleTimeout) clearTimeout(bubbleTimeout);
                hideIntroBubble();
                setTimeout(() => chatInput.focus(), 300);
            } else {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-0', 'opacity-0');
                if (pulseRing) pulseRing.classList.remove('hidden');
                
                // Return to normal size if closed while expanded
                if (chatWindow.classList.contains('expanded-mode')) {
                    toggleExpand();
                }
                // Reset drag position when closing
                resetDragPosition();
            }
        }

        // Toggle expand window
        function toggleExpand() {
            const isExpanded = chatWindow.classList.contains('expanded-mode');
            
            if (isExpanded) {
                // Return to normal bottom-right corner
                chatWindow.classList.remove('expanded-mode', '!fixed', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', '!w-[92vw]', '!h-[90vh]', 'sm:!w-[700px]', 'sm:!h-[85vh]', 'shadow-[0_0_0_100vmax_rgba(0,0,0,0.5)]');
                expandIcon.classList.remove('ph-corners-in');
                expandIcon.classList.add('ph-corners-out');
                if (toggleWrapper) toggleWrapper.classList.remove('opacity-0', 'pointer-events-none');
                // Re-enable drag cursor
                chatHeader.classList.add('cursor-grab');
                chatHeader.classList.add('active:cursor-grabbing');
                // Restore drag position if it had one
                if (!hasDragPosition) resetDragPosition();
            } else {
                // Reset drag position before expanding to center
                resetDragPosition();
                // Expand to center of screen
                chatWindow.classList.add('expanded-mode', '!fixed', 'top-1/2', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', '!w-[92vw]', '!h-[90vh]', 'sm:!w-[700px]', 'sm:!h-[85vh]', 'shadow-[0_0_0_100vmax_rgba(0,0,0,0.5)]');
                expandIcon.classList.remove('ph-corners-out');
                expandIcon.classList.add('ph-corners-in');
                if (toggleWrapper) toggleWrapper.classList.add('opacity-0', 'pointer-events-none');
                // Disable drag cursor
                chatHeader.classList.remove('cursor-grab');
                chatHeader.classList.remove('active:cursor-grabbing');
                chatHeader.style.cursor = 'default';
            }
        }

        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);
        expandBtn.addEventListener('click', toggleExpand);

        // Send message
        async function sendMessage() {
            const text = chatInput.value.trim();
            if (!text) return;

            // Add User Message
            addMessage(text, 'user');
            chatInput.value = '';

            // Add loading indicator
            const loadingId = 'loading-' + Date.now();
            addMessage('<div class="flex items-center gap-1"><div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></div><div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div><div class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div></div>', 'bot', loadingId);

            try {
                const response = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                });
                
                const data = await response.json();
                removeMessage(loadingId);
                
                if (response.status === 429) {
                    addMessage(data.jawaban || "{{ __('Kamu terlalu cepat mengirim pesan, tunggu sebentar ya!') }}", 'bot');
                    return;
                }
                
                if (!response.ok) throw new Error("{{ __('Terjadi kesalahan server') }}");
                
                addMessage(data.jawaban, 'bot');
                
            } catch (error) {
                removeMessage(loadingId);
                addMessage("{{ __('Maaf, sistem AI sedang offline atau GROQ_API_KEY di .env belum disetting.') }}", 'bot');
            }
        }

        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });

        // Add message to DOM
        function addMessage(text, sender, id = null) {
            const msgDiv = document.createElement('div');
            if (id) msgDiv.id = id;
            
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
                        <i class="ph ph-headset text-xs"></i>
                    </div>
                    <div class="bg-white border border-slate-200 text-slate-700 px-3 py-2 rounded-2xl rounded-tl-sm shadow-sm text-[13px] leading-relaxed">
                        ${text}
                    </div>
                `;
            }

            messagesContainer.appendChild(msgDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function removeMessage(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }
    });
</script>
