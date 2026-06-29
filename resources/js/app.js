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
