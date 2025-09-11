document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    
    if (!nombreInput) {
        return;
    }

    nombreInput.focus();
    
    nombreInput.addEventListener('input', function() {
        const value = this.value.trim();
        const maxLength = 100;
        
        const remaining = maxLength - value.length;
        
        const helperTextContainer = this.closest('.relative').nextElementSibling;
        let helperText = null;

        if (helperTextContainer && helperTextContainer.tagName.toLowerCase() === 'p') {
             helperText = helperTextContainer;
        } else if (helperTextContainer && helperTextContainer.nextElementSibling && helperTextContainer.nextElementSibling.tagName.toLowerCase() === 'p') {
            helperText = helperTextContainer.nextElementSibling;
        }

        if (helperText && helperText.textContent.includes('Máximo') || helperText.textContent.includes('restantes')) {
            if (remaining < 20) {
                helperText.textContent = `${remaining} caracteres restantes`;
                helperText.className = remaining < 10 ? 'text-red-500 text-xs' : 'text-yellow-600 text-xs';
            } else {
                helperText.textContent = 'Máximo 100 caracteres';
                helperText.className = 'text-gray-500 text-xs';
            }
        }
    });
});