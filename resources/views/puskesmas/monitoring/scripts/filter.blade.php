<script>
// Auto-submit on filter change (optional)
document.getElementById('status_gizi')?.addEventListener('change', function() {
    // You can auto-submit or wait for user to click button
    // document.getElementById('filterForm').submit();
});

// Enter key submit on search
document.getElementById('search')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});

// Clear search button
function clearSearch() {
    document.getElementById('search').value = '';
    document.getElementById('filterForm').submit();
}
</script>