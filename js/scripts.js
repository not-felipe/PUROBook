document.addEventListener('DOMContentLoaded', function() {
    const foto = document.getElementById('userMenuToggle');
    const dropdown = document.getElementById('userMenuDropdown');
    if (foto && dropdown) {
        foto.addEventListener('click', function(e) {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            e.stopPropagation();
        });
        document.addEventListener('click', function() {
            dropdown.style.display = 'none';
        });
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});