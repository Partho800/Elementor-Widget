/**
 * Testimonials Marquee Interactive Scripts
 * Handles interactive slowdown and Elementor live editor hooks.
 */

document.addEventListener('DOMContentLoaded', function () {
    initTestimonialsMarquee();
});

// ─── TESTIMONIALS MARQUEE INTERACTIVE SLOWDOWN ───
function initTestimonialsMarquee() {
    const rows = document.querySelectorAll('.pns-testimonials-marquee-row');
    rows.forEach(row => {
        if (row.classList.contains('js-marquee-initialized')) return;
        row.classList.add('js-marquee-initialized');

        const track = row.querySelector('.pns-testimonials-marquee-track');
        if (!track) return;

        row.addEventListener('mouseenter', () => {
            if (typeof track.getAnimations === 'function') {
                const animations = track.getAnimations();
                animations.forEach(anim => {
                    anim.playbackRate = 0.25; // Slow down to 25% speed (4x slower)
                });
            }
        });

        row.addEventListener('mouseleave', () => {
            if (typeof track.getAnimations === 'function') {
                const animations = track.getAnimations();
                animations.forEach(anim => {
                    anim.playbackRate = 1.0; // Reset to normal speed
                });
            }
        });
    });
}

// Support Elementor edit mode live preview
if (window.jQuery) {
    jQuery(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend) {
            elementorFrontend.hooks.addAction('frontend/element_ready/pns_testimonials.default', function () {
                initTestimonialsMarquee();
            });
        }
    });
}
