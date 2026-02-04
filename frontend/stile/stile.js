// Applica subito il tema (PRIMA del render)
(function () {
    const match = document.cookie.match(/theme=([^;]+)/);
    let theme = match ? match[1] : null;

    if (!theme) {
        theme = window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    // Scrive subito i link abilitando solo il giusto
    if (theme === 'dark') {
        document.write('<link id="theme-dark" rel="stylesheet" href="frontend/stile/style-dark.css">');
        document.write('<link id="theme-light" rel="stylesheet" href="frontend/stile/style-light.css" disabled>');
    } else {
        document.write('<link id="theme-light" rel="stylesheet" href="frontend/stile/style-light.css">');
        document.write('<link id="theme-dark" rel="stylesheet" href="frontend/stile/style-dark.css" disabled>');
    }
})();

// Funzione per cambiare tema al volo
function applyTheme(theme) {
    const lightLink = document.getElementById('theme-light');
    const darkLink = document.getElementById('theme-dark');
    const themeIcon = document.getElementById('theme-icon');

    if (!lightLink || !darkLink) return;

    if (theme === 'dark') {
        lightLink.disabled = true;
        darkLink.disabled = false;
        if (themeIcon) {
            themeIcon.classList.remove('bi-sun-fill');
            themeIcon.classList.add('bi-moon-stars-fill');
        }
    } else {
        lightLink.disabled = false;
        darkLink.disabled = true;
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
