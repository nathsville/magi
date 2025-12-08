<script>
// Auto-submit on Enter key for search inputs
document.querySelectorAll('select[name]').forEach(select => {
    select.addEventListener('change', function() {
        // Optional: auto-submit on select change
        // this.form.submit();
    });
});
</script>