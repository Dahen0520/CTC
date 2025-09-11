// Simulación de efectos interactivos al enfocar un campo del formulario
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', function() {
        this.style.transform = 'translateY(-1px)';
    });

    input.addEventListener('blur', function() {
        this.style.transform = 'translateY(0)';
    });
});