document.addEventListener('DOMContentLoaded', () => {
    // Fungsi untuk memicu animasi keluar
    const triggerExitAnimation = () => {
        document.body.classList.add('page-exit');
    };

    // Tangani semua klik pada tag anchor <a>
    document.querySelectorAll('a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Abaikan link yang:
            // 1. Membuka tab baru
            // 2. Merupakan link mailto: atau tel:
            // 3. Merupakan anchor link ke ID halaman yang sama (#)
            // 4. Menuju domain yang berbeda
            // 5. Dibuka dengan tombol modifier (Ctrl/Cmd click)
            // 6. Berada di dalam carousel track (agar swipe tidak memicu navigasi)
            if (
                this.target === '_blank' ||
                this.href.startsWith('mailto:') ||
                this.href.startsWith('tel:') ||
                this.getAttribute('href') === '#' ||
                this.getAttribute('href').startsWith('#') ||
                this.hostname !== window.location.hostname ||
                this.hasAttribute('data-location') ||
                this.closest('#carousel-koleksi-track') ||
                e.ctrlKey || e.metaKey || e.shiftKey
            ) {
                return;
            }

            e.preventDefault();
            const targetUrl = this.href;

            // Tambahkan class animasi keluar
            triggerExitAnimation();

            // Tunggu animasi selesai lalu pindah halaman
            // 150ms sesuai dengan durasi animasi di app.css (0.15s)
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 150);
        });
    });

    // Tangani submit form agar transisinya juga mulus
    document.addEventListener('submit', function (e) {
        // Abaikan form yang membuka di tab baru
        if (e.target.target === '_blank') return;

        e.preventDefault(); // Cegah submit langsung
        triggerExitAnimation(); // Mainkan animasi keluar

        // Tunggu animasi selesai, lalu submit form
        setTimeout(() => {
            e.target.submit();
        }, 150);
    });
});

// Global Fuzzy Matching & Typo Auto-Correction Utilities
window.normalizeTypo = function(str) {
    if (!str) return '';
    const typoMap = { '0': 'o', '1': 'i', '3': 'e', '4': 'a', '5': 's', '7': 't', '8': 'b', '@': 'a' };
    return str.toLowerCase().replace(/[0134578@]/g, m => typoMap[m] || m);
};

window.levenshtein = function(a, b) {
    if (a.length === 0) return b.length;
    if (b.length === 0) return a.length;
    const matrix = [];
    for (let i = 0; i <= b.length; i++) matrix[i] = [i];
    for (let j = 0; j <= a.length; j++) matrix[0][j] = j;
    for (let i = 1; i <= b.length; i++) {
        for (let j = 1; j <= a.length; j++) {
            if (b.charAt(i - 1) === a.charAt(j - 1)) {
                matrix[i][j] = matrix[i - 1][j - 1];
            } else {
                matrix[i][j] = Math.min(
                    matrix[i - 1][j - 1] + 1,
                    matrix[i][j - 1] + 1,
                    matrix[i - 1][j] + 1
                );
            }
        }
    }
    return matrix[b.length][a.length];
};

window.isFuzzyMatch = function(targetText, searchQuery) {
    if (!searchQuery) return true;
    if (!targetText) return false;

    const normTarget = window.normalizeTypo(targetText);
    const normQuery = window.normalizeTypo(searchQuery);

    if (normTarget.includes(normQuery)) return true;

    const queryWords = normQuery.split(/\s+/).filter(w => w.length > 0);
    const targetWords = normTarget.split(/\s+/).filter(w => w.length > 0);

    return queryWords.every(qWord => {
        if (targetWords.some(tWord => tWord.includes(qWord))) return true;

        if (qWord.length >= 4) {
            const maxDistance = qWord.length <= 5 ? 1 : 2;
            return targetWords.some(tWord => {
                if (Math.abs(tWord.length - qWord.length) <= maxDistance) {
                    return window.levenshtein(qWord, tWord) <= maxDistance;
                }
                return false;
            });
        }
        return false;
    });
};
