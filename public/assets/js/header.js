class HeaderManager {
    constructor() {
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
        this.setupScrollListener();
        this.setupMenuListeners();
        this.setupCartListeners();
        this.setupKeyboardListeners();
        this.markActiveLink();
        this.setupCartAnimation();
    }

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
        // Cerrar carrito si está abierto
        if (this.isCartOpen) {
            this.closeCart();
        }

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

        // Solo restaurar scroll si el carrito tampoco está abierto
        if (!this.isCartOpen) {
            document.body.style.overflow = '';
        }

        this.navigation.setAttribute('aria-hidden', 'true');
        this.hamburgerBtn.setAttribute('aria-expanded', 'false');
    }

    setupCartListeners() {
        // Verificar que los elementos existen
        if (!this.carreto || !this.cartOverlay || !this.closeCartBtn) {
            console.warn('Elementos del carrito no encontrados');
            return;
        }

        // Botón cerrar carrito
        this.closeCartBtn.addEventListener('click', () => this.closeCart());

        // Overlay del carrito
        this.cartOverlay.addEventListener('click', () => this.closeCart());

        // Botón abrir carrito
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.addEventListener('click', (e) => {
                e.preventDefault();
                this.openCart();
            });
        }
    }

    openCart() {
        if (this.isMenuOpen) {
            this.closeMenu();
        }

        this.isCartOpen = true;
        this.carreto.classList.add('active');
        this.cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';

        this.carreto.setAttribute('aria-hidden', 'false');
    }

    closeCart() {
        this.isCartOpen = false;
        this.carreto.classList.remove('active');
        this.cartOverlay.classList.remove('active');
        if (!this.isMenuOpen) {
            document.body.style.overflow = '';
        }

        this.carreto.setAttribute('aria-hidden', 'true');
    }

    toggleCart() {
        this.isCartOpen ? this.closeCart() : this.openCart();
    }

    setupKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (this.isMenuOpen) {
                    this.closeMenu();
                }
                if (this.isCartOpen) {
                    this.closeCart();
                }
            }
        });
    }

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

    setupCartAnimation() {
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

    forceCloseCart() {
        this.closeCart();
    }

    forceOpenCart() {
        this.openCart();
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

window.openCart = () => {
    if (headerManager) {
        headerManager.forceOpenCart();
    }
};

window.closeCart = () => {
    if (headerManager) {
        headerManager.forceCloseCart();
    }
};