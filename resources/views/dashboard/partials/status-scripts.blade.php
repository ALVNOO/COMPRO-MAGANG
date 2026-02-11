{{--
    STATUS PAGE SCRIPTS
    Intersection Observer animations and interactive effects
--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for Staggered Animations
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const animateOnScroll = (entries, observer) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = `fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards`;
                    entry.target.classList.add('animate-visible');
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(animateOnScroll, observerOptions);

    // Observe all cards with data-animate attribute
    document.querySelectorAll('[data-animate]').forEach((el, index) => {
        el.style.transitionDelay = `${index * 0.1}s`;
        observer.observe(el);
    });

    // Animate progress line on load
    const progressLine = document.querySelector('.stepper-line-fill');
    if (progressLine) {
        progressLine.style.animation = 'progressFill 1.5s cubic-bezier(0.4, 0, 0.2, 1) 0.5s forwards';
    }

    // Add hover effect with subtle scale
    document.querySelectorAll('.step-circle, .card-icon, .contact-item-icon, .btn-primary, .btn-success').forEach(el => {
        el.addEventListener('mouseenter', function() {
            this.style.transition = 'transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
        });
    });

    // Parallax effect for orbs on mouse move
    document.addEventListener('mousemove', function(e) {
        const orbs = document.querySelectorAll('.orb');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;

        orbs.forEach((orb, index) => {
            const speed = (index + 1) * 15;
            const x = (mouseX - 0.5) * speed;
            const y = (mouseY - 0.5) * speed;
            orb.style.transform = `translate(${x}px, ${y}px)`;
        });
    });
});
</script>
