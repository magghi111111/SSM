window.addEventListener('message', function (e) {
    if (e.data && e.data.theme) {
        const lightLink = document.getElementById('theme-light');
        const darkLink = document.getElementById('theme-dark');
        if (e.data.theme === 'dark') {
            lightLink.disabled = true;
            darkLink.disabled = false;
        } else {
            lightLink.disabled = false;
            darkLink.disabled = true;
        }
    }
});

(function () {
    const match = document.cookie.match(/theme=([^;]+)/);
    const theme = match ? match[1]
        : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

    const light = document.createElement('link');
    light.rel = 'stylesheet';
    light.href = '../stile/style-light.css';
    light.id = 'theme-light';

    const dark = document.createElement('link');
    dark.rel = 'stylesheet';
    dark.href = '../stile/style-dark.css';
    dark.id = 'theme-dark';

    if (theme === 'dark') light.disabled = true;
    else dark.disabled = true;

    document.head.appendChild(light);
    document.head.appendChild(dark);
})();