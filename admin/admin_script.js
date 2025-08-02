document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Fungsi untuk menerapkan tema dari localStorage
    const applyTheme = () => {
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
    };

    // Event listener untuk tombol toggle
    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        // Simpan preferensi tema
        const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
        localStorage.setItem('theme', currentTheme);
    });

    // Terapkan tema saat halaman pertama kali dimuat
    applyTheme();
});

// Logika untuk expand/collapse kartu pesanan
document.querySelectorAll('.order-card').forEach(card => {
    card.addEventListener('click', function(event) {
        // Cek agar klik pada tombol tidak ikut menutup kartu
        if (!event.target.classList.contains('btn')) {
            this.classList.toggle('active');
        }
    });
});