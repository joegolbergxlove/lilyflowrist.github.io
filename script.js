// Menunggu seluruh halaman dimuat sebelum menjalankan script
document.addEventListener('DOMContentLoaded', () => {

    const themeSwitcher = document.getElementById('theme-switcher');
    const body = document.body;

    // Fungsi untuk menerapkan tema
    const applyTheme = (theme) => {
        if (theme === 'dark') {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
    };

    // Cek tema yang tersimpan di localStorage saat halaman dimuat
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme) {
        applyTheme(currentTheme);
    } else {
        // Jika tidak ada tema tersimpan, gunakan 'light' sebagai default
        applyTheme('light');
    }

    // Event listener untuk tombol switch
    themeSwitcher.addEventListener('click', () => {
        // Cek apakah body sudah punya class 'dark-mode'
        const isDarkMode = body.classList.contains('dark-mode');
        
        if (isDarkMode) {
            // Jika ya, hapus class dan simpan preferensi ke 'light'
            applyTheme('light');
            localStorage.setItem('theme', 'light');
        } else {
            // Jika tidak, tambahkan class dan simpan preferensi ke 'dark'
            applyTheme('dark');
            localStorage.setItem('theme', 'dark');
        }
    });

});

// Tambahkan kode ini di dalam event listener DOMContentLoaded

document.querySelectorAll('.slider-container').forEach(slider => {
    const track = slider.querySelector('.slider-track');
    const prevButton = slider.querySelector('.slider-button.prev');
    const nextButton = slider.querySelector('.slider-button.next');
    const slides = Array.from(track.children);
    
    if (slides.length <= 1) return; // Jangan jalankan jika gambar cuma 1 atau tidak ada

    let currentIndex = 0;
    const slideWidth = slides[0].getBoundingClientRect().width;

    const moveToSlide = (index) => {
        track.style.transform = 'translateX(-' + slideWidth * index + 'px)';
        currentIndex = index;
    };

    nextButton.addEventListener('click', () => {
        const nextIndex = currentIndex + 1;
        if (nextIndex < slides.length) {
            moveToSlide(nextIndex);
        }
    });

    prevButton.addEventListener('click', () => {
        const prevIndex = currentIndex - 1;
        if (prevIndex >= 0) {
            moveToSlide(prevIndex);
        }
    });
});