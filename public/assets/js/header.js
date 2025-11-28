class HeaderManager {
    constructor() {
        // Elementos del header y menú
        this.header = document.getElementById('mainHeader');
        this.hamburgerBtn = document.getElementById('hamburgerBtn');
        this.navigation = document.getElementById('navigation');
        this.menuOverlay = document.getElementById('menuOverlay');
        this.scrollThreshold = 100;
        this.isMenuOpen = false;

        // Elementos del carrito
        this.carreto = document.getElementById('carreto');
        this.cartOverlay = document.getElementById('cartOverlay');
        this.closeCartBtn = document.getElementById('closeCart');
        this.isCartOpen = false;

        this.init();
    }

    init() {
        // Inicializar todos los listeners y funcionalidades
        this.configurarListenerScroll();
        this.configurarListenersMenu();
        this.configurarListenersCarret();
        this.configurarListenersTeclat();
        this.marcarEnllacActiu();
        this.configurarAnimacioCarret();
    }

    configurarListenerScroll() {
        // Optimizar scroll con requestAnimationFrame
        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    this.gestionarScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        this.gestionarScroll();
    }

    gestionarScroll() {
        // Añadir clase 'scrolled' al header al hacer scroll
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > this.scrollThreshold) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
    }

    configurarListenersMenu() {
        // Event listeners para abrir/cerrar menú hamburguesa
        this.hamburgerBtn.addEventListener('click', () => this.alternarMenu());
        this.menuOverlay.addEventListener('click', () => this.tancarMenu());

        const menuLinks = this.navigation.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.tancarMenu();
            });
        });
    }

    alternarMenu() {
        // Alternar entre abrir y cerrar el menú
        this.isMenuOpen ? this.tancarMenu() : this.obrirMenu();
    }

    obrirMenu() {
        // Cerrar carrito si está abierto
        if (this.isCartOpen) {
            this.tancarCarret();
        }

        // Abrir menú y bloquear scroll
        this.isMenuOpen = true;
        this.hamburgerBtn.classList.add('active');
        this.navigation.classList.add('active');
        this.menuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        this.navigation.setAttribute('aria-hidden', 'false');
        this.hamburgerBtn.setAttribute('aria-expanded', 'true');
    }

    tancarMenu() {
        // Cerrar menú y restaurar scroll si el carrito no está abierto
        this.isMenuOpen = false;
        this.hamburgerBtn.classList.remove('active');
        this.navigation.classList.remove('active');
        this.menuOverlay.classList.remove('active');

        // Solo restaurar scroll si el carrito tampoco está abierto
        if (!this.isCartOpen) {
            document.body.style.overflow = '';
        }

        this.navigation.setAttribute('aria-hidden', 'true');
        this.hamburgerBtn.setAttribute('aria-expanded', 'false');
    }

    configurarListenersCarret() {
        // Verificar que los elementos existen
        if (!this.carreto || !this.cartOverlay || !this.closeCartBtn) {
            console.warn('Elementos del carrito no encontrados');
            return;
        }

        // Botón cerrar carrito
        this.closeCartBtn.addEventListener('click', () => this.tancarCarret());

        // Overlay del carrito
        this.cartOverlay.addEventListener('click', () => this.tancarCarret());

        // Botón abrir carrito
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.addEventListener('click', (e) => {
                e.preventDefault();
                this.obrirCarret();
            });
        }
    }

    obrirCarret() {
        // Cerrar menú si está abierto
        if (this.isMenuOpen) {
            this.tancarMenu();
        }

        // Abrir carrito y bloquear scroll
        this.isCartOpen = true;
        this.carreto.classList.add('active');
        this.cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        this.carreto.setAttribute('aria-hidden', 'false');
    }

    tancarCarret() {
        // Cerrar carrito y restaurar scroll si el menú no está abierto
        this.isCartOpen = false;
        this.carreto.classList.remove('active');
        this.cartOverlay.classList.remove('active');
        if (!this.isMenuOpen) {
            document.body.style.overflow = '';
        }

        this.carreto.setAttribute('aria-hidden', 'true');
    }

    alternarCarret() {
        // Alternar entre abrir y cerrar el carrito
        this.isCartOpen ? this.tancarCarret() : this.obrirCarret();
    }

    configurarListenersTeclat() {
        // Cerrar menú y carrito con la tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (this.isMenuOpen) {
                    this.tancarMenu();
                }
                if (this.isCartOpen) {
                    this.tancarCarret();
                }
            }
        });
    }

    marcarEnllacActiu() {
        // Marcar el enlace activo según la ruta actual
        const currentPath = window.location.pathname;
        const menuLinks = this.navigation.querySelectorAll('a');

        menuLinks.forEach(link => {
            const href = link.getAttribute('href');

            // Coincidencia exacta o ruta que comienza con el href
            if (href === currentPath) {
                link.classList.add('active');
            } else if (currentPath.startsWith(href) && href !== '/') {
                link.classList.add('active');
            }
        });
    }

    configurarAnimacioCarret() {
        // Animación hover en el icono del carrito
        const cartIcon = document.querySelector('.cart-icon');

        if (cartIcon) {
            cartIcon.addEventListener('mouseenter', () => {
                cartIcon.style.transform = 'scale(1.1)';
            });

            cartIcon.addEventListener('mouseleave', () => {
                cartIcon.style.transform = '';
            });
        }
    }

    actualitzarBadgeCarret(count) {
        // Actualizar el badge del carrito con animación
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count === 0 ? 'none' : 'flex';

            badge.style.transform = 'scale(1.3)';
            setTimeout(() => {
                badge.style.transform = '';
            }, 200);
        }
    }

    forçarTancarMenu() {
        this.tancarMenu();
    }

    forçarObrirMenu() {
        this.obrirMenu();
    }

    forçarTancarCarret() {
        this.tancarCarret();
    }

    forçarObrirCarret() {
        this.obrirCarret();
    }
}

let headerManager;

// Inicializar el HeaderManager al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    headerManager = new HeaderManager();
});


// Funciones globales para actualizar el carrito desde otros scripts
window.updateCartCount = (count) => {
    if (headerManager) {
        headerManager.actualitzarBadgeCarret(count);
    }
};

window.closeHeaderMenu = () => {
    if (headerManager) {
        headerManager.forçarTancarMenu();
    }
};

window.openHeaderMenu = () => {
    if (headerManager) {
        headerManager.forçarObrirMenu();
    }
};

window.openCart = () => {
    if (headerManager) {
        headerManager.forçarObrirCarret();
    }
};

window.closeCart = () => {
    if (headerManager) {
        headerManager.forçarTancarCarret();
    }
};