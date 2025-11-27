// ========================================
// THEME SWITCHER SIMPLE
// ========================================

class ThemeSwitcher {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        this.applyTheme(this.theme);
        this.watchSystemTheme();
    }

    applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        this.theme = theme;
        localStorage.setItem('theme', theme);

        // Cambiar imagen del logo
        this.updateLogo(theme);

        // Disparar evento
        document.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme }
        }));
    }

    // Cambiar logo según el tema
    updateLogo(theme) {
        const logoImg = document.querySelector('.logo-image');

        if (logoImg) {
            if (theme === 'dark') {
                logoImg.src = '/assets/media/Eb.png';
            } else {
                logoImg.src = '/assets/media/E.png';
            }
        }
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

    watchSystemTheme() {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                this.applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
}

// Inicializar
const themeSwitcher = new ThemeSwitcher();

// ========================================
// BOTÓN DE TOGGLE
// ========================================
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');

    if (toggleBtn) {
        updateToggleIcon(toggleBtn);

        toggleBtn.addEventListener('click', () => {
            themeSwitcher.toggle();
            updateToggleIcon(toggleBtn);
        });

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
        if (lightIcon) lightIcon.style.display = 'none';
        if (darkIcon) darkIcon.style.display = 'inline';
    } else {
        if (lightIcon) lightIcon.style.display = 'inline';
        if (darkIcon) darkIcon.style.display = 'none';
    }
}

// Funciones globales
window.toggleTheme = () => themeSwitcher.toggle();
window.setTheme = (theme) => themeSwitcher.setTheme(theme);
window.getTheme = () => themeSwitcher.getTheme();