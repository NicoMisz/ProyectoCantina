// ========================================
// HEADER CANTINA TONY'S - JavaScript
// ========================================

class HeaderManager {
    constructor() {
        this.header = document.getElementById('mainHeader');
        this.hamburgerBtn = document.getElementById('hamburgerBtn');
        this.navigation = document.getElementById('navigation');
        this.menuOverlay = document.getElementById('menuOverlay');
        this.scrollThreshold = 100;
        this.isMenuOpen = false;

        this.init();
    }

    init() {
        this.setupScrollListener();
        this.setupMenuListeners();
        this.setupKeyboardListeners();
        this.markActiveLink();
        this.setupCartAnimation();
    }

    // ========================================
    // SCROLL - Logo animado
    // ========================================
    setupScrollListener() {
        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    this.handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        this.handleScroll();
    }

    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > this.scrollThreshold) {
            this.header.classList.add('scrolled');
        } else {
            this.header.classList.remove('scrolled');
        }
    }

    // ========================================
    // MENÚ HAMBURGUESA
    // ========================================
    setupMenuListeners() {
        this.hamburgerBtn.addEventListener('click', () => this.toggleMenu());
        this.menuOverlay.addEventListener('click', () => this.closeMenu());

        const menuLinks = this.navigation.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.closeMenu();
            });
        });
    }

    toggleMenu() {
        this.isMenuOpen ? this.closeMenu() : this.openMenu();
    }

    openMenu() {
        this.isMenuOpen = true;
        this.hamburgerBtn.classList.add('active');
        this.navigation.classList.add('active');
        this.menuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        this.navigation.setAttribute('aria-hidden', 'false');
        this.hamburgerBtn.setAttribute('aria-expanded', 'true');
    }

    closeMenu() {
        this.isMenuOpen = false;
        this.hamburgerBtn.classList.remove('active');
        this.navigation.classList.remove('active');
        this.menuOverlay.classList.remove('active');
        document.body.style.overflow = '';

        this.navigation.setAttribute('aria-hidden', 'true');
        this.hamburgerBtn.setAttribute('aria-expanded', 'false');
    }

    // ========================================
    // TECLADO
    // ========================================
    setupKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isMenuOpen) {
                this.closeMenu();
            }
        });
    }

    // ========================================
    // LINK ACTIVO
    // ========================================
    markActiveLink() {
        const currentPath = window.location.pathname;
        const menuLinks = this.navigation.querySelectorAll('a');

        menuLinks.forEach(link => {
            const href = link.getAttribute('href');

            if (href === currentPath) {
                link.classList.add('active');
            } else if (currentPath.startsWith(href) && href !== '/') {
                link.classList.add('active');
            }
        });
    }

    // ========================================
    // ANIMACIÓN CARRITO
    // ========================================
    setupCartAnimation() {
        const cartIcon = document.querySelector('.cart-icon');

        if (cartIcon) {
            cartIcon.addEventListener('click', (e) => {
                cartIcon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    cartIcon.style.transform = '';
                }, 300);
            });
        }
    }

    // ========================================
    // API PÚBLICA
    // ========================================
    updateCartBadge(count) {
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

    forceCloseMenu() {
        this.closeMenu();
    }

    forceOpenMenu() {
        this.openMenu();
    }
}

// ========================================
// INICIALIZACIÓN
// ========================================
let headerManager;

document.addEventListener('DOMContentLoaded', () => {
    headerManager = new HeaderManager();
});

// ========================================
// API GLOBAL
// ========================================
window.updateCartCount = (count) => {
    if (headerManager) {
        headerManager.updateCartBadge(count);
    }
};

window.closeHeaderMenu = () => {
    if (headerManager) {
        headerManager.forceCloseMenu();
    }
};

window.openHeaderMenu = () => {
    if (headerManager) {
        headerManager.forceOpenMenu();
    }
};

// ========================================
// EJEMPLOS DE USO
// ========================================
/*
// Actualizar contador del carrito:
window.updateCartCount(5);

// Cerrar menú:
window.closeHeaderMenu();

// Abrir menú:
window.openHeaderMenu();

// Ejemplo con fetch al añadir al carrito:
function addToCart(productId) {
    fetch('/api/cart/add', {
        method: 'POST',
        body: JSON.stringify({ productId }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        window.updateCartCount(data.cartCount);
    });
}
*/