// Initialize AOS Scroll Animation
document.addEventListener("DOMContentLoaded", function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }

    // Swiper Slider Init
    if (typeof Swiper !== 'undefined') {
        var swiper = new Swiper(".videoSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: { el: ".swiper-pagination", clickable: true },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    }

    // Dark Mode Toggle Logic with LocalStorage
    const themeToggleBtn = document.getElementById('themeToggle');
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-bs-theme', currentTheme);
    updateThemeIcons(currentTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-bs-theme');
            let targetTheme = theme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
            updateThemeIcons(targetTheme);
        });
    }

    function updateThemeIcons(theme) {
        const icon = document.querySelector('#themeToggle i');
        if (icon) {
            icon.className = theme === 'dark' ? 'fa-solid fa-sun text-warning' : 'fa-solid fa-moon';
        }
    }

    // Article Reading Scroll Progress Indicator
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        if (height > 0) {
            let scrolled = (winScroll / height) * 100;
            let progress = document.getElementById("readingProgress");
            if(progress) progress.style.width = scrolled + "%";
        }
    };
});

// Fullscreen Search Overlay Functions
function openSearch() {
    const el = document.getElementById('searchOverlay');
    if(el) {
        el.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            const input = document.getElementById('searchInput');
            if(input) input.focus();
        }, 100);
    }
}

function closeSearch() {
    const el = document.getElementById('searchOverlay');
    if(el) {
        el.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Font Dynamic Resizing Logic
let currentFontSize = 19;
function adjustFont(delta) {
    currentFontSize += delta;
    if(currentFontSize >= 15 && currentFontSize <= 26) {
        const body = document.getElementById("articleBody");
        if(body) body.style.fontSize = currentFontSize + "px";
    }
}
