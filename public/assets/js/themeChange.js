//Clase para cambiar de tema
class ThemeSwitcher {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // Aplicar tema guardado al cargar
        this.applyTheme(this.theme);

        // Escuchar cambios en preferencia del sistema
        this.watchSystemTheme();
    }

    applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        this.theme = theme;
        localStorage.setItem('theme', theme);

        // Disparar evento personalizado para otros componentes
        document.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme }
        }));
    }

    toggle() {
        const newTheme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
        return newTheme;
    }

    setTheme(theme) {
        if (theme === 'light' || theme === 'dark') {
            this.applyTheme(theme);
        }
    }

    getTheme() {
        return this.theme;
    }

    // Detectar preferencia del sistema
    watchSystemTheme() {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        mediaQuery.addEventListener('change', (e) => {
            // Solo aplicar si el usuario no ha establecido preferencia
            if (!localStorage.getItem('theme')) {
                this.applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
}

// Inicializar el theme switcher
const themeSwitcher = new ThemeSwitcher();

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');

    if (toggleBtn) {
        // Actualizar icono inicial
        updateToggleIcon(toggleBtn);

        // Escuchar clicks
        toggleBtn.addEventListener('click', () => {
            themeSwitcher.toggle();
            updateToggleIcon(toggleBtn);
        });

        // Actualizar cuando cambie el tema desde otro lugar
        document.addEventListener('themeChanged', () => {
            updateToggleIcon(toggleBtn);
        });
    }
});

function updateToggleIcon(btn) {
    const theme = themeSwitcher.getTheme();
    const lightIcon = btn.querySelector('.icon-light');
    const darkIcon = btn.querySelector('.icon-dark');

    if (theme === 'dark') {
        lightIcon.style.display = 'none';
        darkIcon.style.display = 'inline';
    } else {
        lightIcon.style.display = 'inline';
        darkIcon.style.display = 'none';
    }
}

//Funciones globales
window.toggleTheme = () => themeSwitcher.toggle();
window.setTheme = (theme) => themeSwitcher.setTheme(theme);
window.getTheme = () => themeSwitcher.getTheme();

