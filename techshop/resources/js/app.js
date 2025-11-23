import './bootstrap';

// Alpine-compatible advertCarousel component factory
// Usage in Blade: x-data="advertCarousel({{ $ads->toJson() }})" x-init="init()"
window.advertCarousel = function(initialAds) {
    return {
        ads: Array.isArray(initialAds) ? initialAds : (initialAds ? JSON.parse(initialAds) : []),
        index: 0,
        timer: null,
        init() {
            // start auto-rotate if there are ads
            if (this.ads && this.ads.length > 1) {
                this.start();
            }
        },
        start(interval = 5000) {
            this.stop();
            this.timer = setInterval(() => {
                this.next();
            }, interval);
        },
        stop() {
            if (this.timer) { clearInterval(this.timer); this.timer = null; }
        },
        go(i) {
            this.index = i % (this.ads.length || 1);
        },
        next() {
            this.index = (this.index + 1) % (this.ads.length || 1);
        },
        prev() {
            this.index = (this.index - 1 + (this.ads.length || 1)) % (this.ads.length || 1);
        }
    };
};

/**
 * ============================================
 * TECHSHOP - GLOBAL POPUP HANDLERS
 * ============================================
 */

// Required Login Popup Handler
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('required-login-popup');
    if (!popup) return;

    // Function to show popup
    window.showRequiredLoginPopup = function() {
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        popup.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    // Function to hide popup
    window.hideRequiredLoginPopup = function() {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        popup.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    // Trigger buttons (cart icon, order icon when not logged in)
    document.querySelectorAll('[data-trigger-login-popup]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            window.showRequiredLoginPopup();
        });
    });

    // Close buttons
    document.querySelectorAll('[data-close-login-popup]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            window.hideRequiredLoginPopup();
        });
    });

    // Close on backdrop click
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            window.hideRequiredLoginPopup();
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
            window.hideRequiredLoginPopup();
        }
    });
});

// Force show popup if session flag is set
if (typeof window !== 'undefined') {
    window.addEventListener('load', function() {
        // Check if Laravel session wants to force show login popup
        const forcePopup = document.querySelector('meta[name="force-login-popup"]');
        if (forcePopup && forcePopup.content === 'true') {
            if (typeof window.showRequiredLoginPopup === 'function') {
                window.showRequiredLoginPopup();
            }
        }
    });
}

/**
 * ============================================
 * CART COUNT UPDATE - REAL-TIME
 * ============================================
 */
window.updateCartCount = function() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.count !== undefined) {
            const badge = document.querySelector('.cart-count-badge');
            if (badge) {
                badge.textContent = data.count;
                // Add animation
                badge.classList.add('scale-125');
                setTimeout(() => badge.classList.remove('scale-125'), 200);
            }
        }
    })
    .catch(error => console.error('Error updating cart count:', error));
};

