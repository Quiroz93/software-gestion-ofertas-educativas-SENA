/**
 * Public Area JavaScript
 * Scripts para vistas públicas con lazy loading
 */

document.addEventListener('DOMContentLoaded', function() {
    // Lazy Loading Images
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyImages.forEach(img => {
            img.src = img.dataset.src || img.src;
            img.classList.add('loaded');
        });
    }

    // Search functionality (if search input exists)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.public-card');
            
            cards.forEach(card => {
                const title = card.querySelector('.public-card-title')?.textContent.toLowerCase() || '';
                const text = card.querySelector('.public-card-text')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || text.includes(searchTerm)) {
                    card.closest('.col-md-4, .col-lg-3, .col-12')?.style.setProperty('display', 'block');
                } else {
                    card.closest('.col-md-4, .col-lg-3, .col-12')?.style.setProperty('display', 'none');
                }
            });
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Add fade-in animation to cards as they appear
    const cards = document.querySelectorAll('.public-card');
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('fade-in-up');
                }, index * 100);
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => cardObserver.observe(card));
});
