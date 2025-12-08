<script>
// Auto-submit on Enter key
document.querySelectorAll('input[name="search"]').forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.form.submit();
        }
    });
});

// Clear search function
function clearSearch() {
    document.querySelector('input[name="search"]').value = '';
}
</script>