<script>
function clearFilters() {
    window.location.href = '{{ route('orangtua.anak.index') }}';
}

// Auto-submit on Enter key
document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});
</script>