<script>
// Real-time search (debounced)
let searchTimeout;
const searchInput = document.getElementById('searchInput');

if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        // Debounce 500ms
        searchTimeout = setTimeout(() => {
            // Auto-submit form if user stops typing
            // Uncomment if you want auto-submit
            // this.form.submit();
        }, 500);
    });
    
    // Submit on Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.form.submit();
        }
    });
}

// Clear search button
function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
        searchInput.form.submit();
    }
}
</script>