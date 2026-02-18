{{-- STATUS PAGE SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stagger animation delays for cards and stats
    document.querySelectorAll('.sp-card').forEach((el, i) => {
        el.style.animationDelay = (0.15 + i * 0.05) + 's';
        el.classList.add('sp-anim');
    });
    // Animate progress bar fills after page load
    setTimeout(function() {
        document.querySelectorAll('.sp-prog-bar-fill').forEach(function(bar) {
            var w = bar.style.width;
            bar.style.width = '0';
            bar.style.transition = 'width .8s cubic-bezier(.16,1,.3,1)';
            requestAnimationFrame(function() { bar.style.width = w; });
        });
    }, 300);
});
</script>
