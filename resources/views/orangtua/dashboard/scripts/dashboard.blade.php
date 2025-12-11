<script>
// Auto-refresh notifications every 30 seconds
setInterval(function() {
    // You can implement AJAX to refresh notification count
    // For now, just a placeholder
}, 30000);

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>