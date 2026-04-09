
/* =========================================================
   THEME INIT — eseguito PRIMA del render
   ========================================================= */

window.__initialTheme = (function () {

    // 1. Tema da cookie
    const match = document.cookie.match(/theme=([^;]+)/);
    let theme = match ? match[1] : null;

    // 2. Se non c'è cookie → preferenza browser
    if (!theme) {
        theme = window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    // 3. Caricamento CSS
    const head = document.head;

    const light = document.createElement('link');
    light.rel = 'stylesheet';
    light.href = 'frontend/stile/style-light.css';
    light.id = 'theme-light';

    const dark = document.createElement('link');
    dark.rel = 'stylesheet';
    dark.href = 'frontend/stile/style-dark.css';
    dark.id = 'theme-dark';

    if (theme === 'dark') {
        light.disabled = true;
    } else {
        dark.disabled = true;
    }

    head.appendChild(light);
    head.appendChild(dark);

    return theme;

})();


/* =========================================================
   APPLY THEME — applica UI (logo + icona)
   ========================================================= */

function applyTheme(theme) {

    const lightLink = document.getElementById('theme-light');
    const darkLink  = document.getElementById('theme-dark');
    const themeIcon = document.getElementById('theme-icon');
    const logo      = document.getElementById('sidebar-logo');

    if (!lightLink || !darkLink) return;

    if (theme === 'dark') {

        lightLink.disabled = true;
        darkLink.disabled  = false;

        if (logo) {
            logo.src = 'frontend/img/logoblu.png';
        }

        if (themeIcon) {
            themeIcon.classList.remove('bi-sun-fill');
            themeIcon.classList.add('bi-moon-stars-fill');
        }

    } else {

        lightLink.disabled = false;
        darkLink.disabled  = true;

        if (logo) {
            logo.src = 'frontend/img/logonero.png';
        }

        if (themeIcon) {
            themeIcon.classList.remove('bi-moon-stars-fill');
            themeIcon.classList.add('bi-sun-fill');
        }
    }

    // Persistenza
    document.cookie = "theme=" + theme + "; path=/; max-age=31536000";

    const iframe = document.querySelector('iframe[src*="grafico.php"]');
    if (iframe) {
        iframe.contentWindow.postMessage({ theme }, '*');
    }
}


/* =========================================================
   TOGGLE BUTTON
   ========================================================= */

function toggleTheme() {

    const lightLink = document.getElementById('theme-light');
    if (!lightLink) return;

    const newTheme = lightLink.disabled ? 'light' : 'dark';
    applyTheme(newTheme);
}


/* =========================================================
   DOM READY — sincronizza UI al primo caricamento
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    applyTheme(window.__initialTheme);
});

/* =========================================================
   SIDEBAR MOBILE TOGGLE
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (!toggle || !sidebar || !overlay) return;

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden'; // blocca scroll pagina
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    // Chiudi su navigazione (SPA-like)
    sidebar.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    // Chiudi se si ruota il dispositivo e si passa a landscape
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });
});