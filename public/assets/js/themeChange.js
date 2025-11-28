class ThemeSwitcher {
    constructor() {
        // Obtenir tema guardado o utilitzar 'light' por defecto
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // Inicialitzar tema i observador del sistema
        this.applyTheme(this.theme);
        this.watchSystemTheme();
    }

    applyTheme(theme) {
        // Aplicar el tema al documento y guardar-lo
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
        const logos = document.querySelectorAll('.logo-image'); // Selecciona TODOS los logos

        logos.forEach(logoImg => {
            if (theme === 'dark') {
                logoImg.src = '/assets/media/Eb.png';
            } else {
                logoImg.src = '/assets/media/E.png';
            }
        });
    }

    toggle() {
        // Alternar entre tema claro y oscuro
        const newTheme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
        return newTheme;
    }

    setTheme(theme) {
        // Establecer un tema específico
        if (theme === 'light' || theme === 'dark') {
            this.applyTheme(theme);
        }
    }

    getTheme() {
        // Retornar el tema actual
        return this.theme;
    }

    watchSystemTheme() {
        // Detectar cambios en las preferencias del sistema
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        mediaQuery.addEventListener('change', (e) => {
            // Solo aplicar si el usuario no ha elegido manualmente
            if (!localStorage.getItem('theme')) {
                this.applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
}

// Instancia global del gestor de temas
const themeSwitcher = new ThemeSwitcher();

// Configurar botón de cambio de tema al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');

    if (toggleBtn) {
        // Actualizar icono inicial
        updateToggleIcon(toggleBtn);

        // Event listener para alternar tema
        toggleBtn.addEventListener('click', () => {
            themeSwitcher.toggle();
            updateToggleIcon(toggleBtn);
        });

        // Actualizar icono cuando cambia el tema
        document.addEventListener('themeChanged', () => {
            updateToggleIcon(toggleBtn);
        });
    }
});

function updateToggleIcon(btn) {
    // Actualizar el icono del botón según el tema actual
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