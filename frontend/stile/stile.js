// Applica subito il tema (PRIMA del render)
(function () {
    const match = document.cookie.match(/theme=([^;]+)/);
    let theme = match ? match[1] : null;

    if (!theme) {
        theme = window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

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
})();

// Funzione per cambiare tema al volo
function applyTheme(theme) {
    const lightLink = document.getElementById('theme-light');
    const darkLink = document.getElementById('theme-dark');
    const themeIcon = document.getElementById('theme-icon');
    const logo = document.getElementById('sidebar-logo');

    if (!lightLink || !darkLink) return;

    if (theme === 'dark') {
        lightLink.disabled = true;
        darkLink.disabled = false;
        logo.src = 'frontend/img/logoblu.png'; // Cambia logo per tema scuro
        if (themeIcon) {
            themeIcon.classList.remove('bi-sun-fill');
            themeIcon.classList.add('bi-moon-stars-fill');
        }
    } else {
        lightLink.disabled = false;
        darkLink.disabled = true;
        logo.src = 'frontend/img/logonero.png'; // Cambia logo per tema chiaro
        if (themeIcon) {
            themeIcon.classList.remove('bi-moon-stars-fill');
            themeIcon.classList.add('bi-sun-fill');
        }
    }

    document.cookie = "theme=" + theme + "; path=/; max-age=31536000";
}

// Toggle bottone
function toggleTheme() {
    const lightLink = document.getElementById('theme-light');
    const newTheme = lightLink.disabled ? 'light' : 'dark';
    applyTheme(newTheme);
}

// Dopo il load possiamo aggiornare solo l'icona
document.addEventListener('DOMContentLoaded', () => {
    const match = document.cookie.match(/theme=([^;]+)/);
    const theme = match ? match[1] : null;
    if (theme) applyTheme(theme);
});
