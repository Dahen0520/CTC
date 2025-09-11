document.addEventListener('DOMContentLoaded', function() {
    const formContainer = document.getElementById('visita-form-container');
    if (!formContainer) return;

    const tiposVisita = JSON.parse(formContainer.dataset.tiposVisita);
    const verificarUrl = formContainer.dataset.verificarUrl;

    const form = document.getElementById('visita-form');
    const submitBtn = document.getElementById('submit-btn');
    const precioDisplay = document.getElementById('precio-display');
    const precioInfo = document.getElementById('precio-info');
    const afiliadoId = Object.values(tiposVisita).find(tipo => tipo.nombre === 'Afiliado')?.id;
    const afiliadoDniContainer = document.getElementById('afiliado-dni-container');

    const cantidades = {};
    let dniVerificationStatus = {};

    function resetForm() {
        document.querySelectorAll('.counter-display').forEach(span => span.textContent = '0');
        document.querySelectorAll('.visita-input-field').forEach(input => input.value = '0');
        if (afiliadoDniContainer) afiliadoDniContainer.innerHTML = '';
        Object.keys(cantidades).forEach(key => delete cantidades[key]);
        dniVerificationStatus = {};
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let total = 0;
        const hasSelections = Object.values(cantidades).some(c => c > 0);
        
        Object.keys(cantidades).forEach(id => {
            total += (cantidades[id] || 0) * parseFloat(tiposVisita[id].precio);
        });

        let allAfiliadosAreValid = true;
        const afiliadoCount = cantidades[afiliadoId] || 0;
        if (afiliadoCount > 0 && afiliadoDniContainer) {
            const dniInputs = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]'));
            if (dniInputs.length !== afiliadoCount || dniInputs.some(input => dniVerificationStatus[input.value.replace(/-/g, '')] !== true)) {
                allAfiliadosAreValid = false;
            }
        }

        if (hasSelections) {
            precioDisplay.textContent = total.toFixed(2);
            precioInfo.classList.remove('hidden');
        } else {
            precioInfo.classList.add('hidden');
        }
        
        if (hasSelections && allAfiliadosAreValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-gradient-to-r', 'from-chorotega-blue', 'to-chorotega-blue-light', 'hover:shadow-xl', 'transform', 'hover:-translate-y-0.5');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.remove('bg-gradient-to-r', 'from-chorotega-blue', 'to-chorotega-blue-light', 'hover:shadow-xl', 'transform', 'hover:-translate-y-0.5');
        }
    }

    function updateAfiliadoDniFields(dniValuesToPreserve = []) {
        const afiliadoCount = cantidades[afiliadoId] || 0;
        if (!afiliadoDniContainer) return;
        
        afiliadoDniContainer.innerHTML = '';
        
        if (afiliadoCount > 0) {
            const title = document.createElement('h5');
            title.className = 'text-base font-semibold text-gray-700 mt-4 mb-3 flex items-center';
            title.innerHTML = `<i class="fas fa-id-card text-blue-600 mr-2"></i>Números de Identidad de Afiliados (${afiliadoCount})`;
            afiliadoDniContainer.appendChild(title);
            
            for (let i = 0; i < afiliadoCount; i++) {
                const inputGroup = document.createElement('div');
                inputGroup.className = 'flex flex-col sm:flex-row gap-2 sm:gap-3 mb-3';
                
                const input = document.createElement('input');
                input.type = 'text';
                input.name = `afiliado_dni[${i}]`;
                input.placeholder = 'Ej: 0801-1990-12345';
                input.maxLength = 15; 
                input.className = 'flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-base font-medium';
                
                const dniValue = dniValuesToPreserve[i] || '';
                input.value = dniValue;
                
                const buttonsContainer = document.createElement('div');
                buttonsContainer.className = 'flex space-x-2 flex-shrink-0';

                const checkBtn = document.createElement('button');
                checkBtn.type = 'button';
                
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'delete-dni-btn px-4 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors';
                deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                
                input.addEventListener('input', function() {

                    let value = this.value.replace(/[^0-9]/g, '');

                    // Aplicar el formato XXXX-XXXX-XXXXX
                    let formattedValue = '';
                    if (value.length > 8) {
                        formattedValue = `${value.substring(0, 4)}-${value.substring(4, 8)}-${value.substring(8, 13)}`;
                    } else if (value.length > 4) {
                        formattedValue = `${value.substring(0, 4)}-${value.substring(4, 8)}`;
                    } else {
                        formattedValue = value;
                    }
                    
                    this.value = formattedValue;

                    if (this.value.length === 15) {
                        verificarDni(this.value.replace(/-/g, ''));
                    }
                });

                deleteBtn.addEventListener('click', function() {
                    const cleanDniValue = input.value.replace(/-/g, '');
                    if (cleanDniValue) {
                        delete dniVerificationStatus[cleanDniValue];
                    }
                    const currentDniValues = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]')).map(inp => inp.value);
                    const indexToRemove = currentDniValues.indexOf(input.value);
                    if (indexToRemove > -1) {
                        currentDniValues.splice(indexToRemove, 1);
                    }
                    
                    cantidades[afiliadoId]--;
                    document.querySelector(`.counter-display[data-id="${afiliadoId}"]`).textContent = cantidades[afiliadoId];
                    document.querySelector(`input[name="visitas[${afiliadoId}]"]`).value = cantidades[afiliadoId];
                    
                    updateAfiliadoDniFields(currentDniValues);
                    updateTotalPrice();
                });

                checkBtn.addEventListener('click', function() {
                    verificarDni(input.value.replace(/-/g, ''));
                });
                
                buttonsContainer.appendChild(checkBtn);
                buttonsContainer.appendChild(deleteBtn);
                inputGroup.appendChild(input);
                inputGroup.appendChild(buttonsContainer);
                afiliadoDniContainer.appendChild(inputGroup);
                
                const status = dniVerificationStatus[dniValue.replace(/-/g, '')];
                checkBtn.className = 'check-dni-btn px-4 py-3 rounded-xl transition-colors';
                if (status === true) {
                    checkBtn.innerHTML = '<i class="fas fa-check-circle"></i>';
                    checkBtn.classList.add('bg-green-100', 'text-green-600', 'border', 'border-green-200');
                    input.readOnly = true;
                    input.classList.add('bg-green-50', 'border-green-300');
                } else if (status === false) {
                    checkBtn.innerHTML = '<i class="fas fa-times-circle"></i>';
                    checkBtn.classList.add('bg-red-100', 'text-red-600', 'border', 'border-red-200');
                    input.classList.add('bg-red-50', 'border-red-300');
                } else if (status === 'verifying') {
                    checkBtn.innerHTML = '<i class="fas fa-sync fa-spin"></i>';
                    checkBtn.classList.add('bg-gray-200', 'text-gray-600');
                    checkBtn.disabled = true;
                    input.disabled = true;
                } else {
                    checkBtn.innerHTML = '<i class="fas fa-check"></i>';
                    checkBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                }
            }
        }
    }
    
    function verificarDni(dni) {
        const cleanDni = dni.replace(/[^0-9]/g, '');
        if (cleanDni.length !== 13) return;
        
        dniVerificationStatus[cleanDni] = 'verifying';
        const currentDniValues = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]')).map(inp => inp.value);
        updateAfiliadoDniFields(currentDniValues);

        fetch(verificarUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ dni: cleanDni })
        })
        .then(response => response.json())
        .then(data => {
            dniVerificationStatus[cleanDni] = data.success;
        })
        .catch(() => {
            dniVerificationStatus[cleanDni] = false;
            Swal.fire({ title: 'Error', text: 'Ocurrió un error de conexión al verificar.', icon: 'error' });
        })
        .finally(() => {
            const finalDniValues = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]')).map(inp => inp.value);
            updateAfiliadoDniFields(finalDniValues);
            updateTotalPrice();
        });
    }

    document.querySelectorAll('.increment-btn, .decrement-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const isIncrement = this.classList.contains('increment-btn');
            const currentCount = cantidades[id] || 0;

            if (isIncrement) {
                cantidades[id] = currentCount + 1;
            } else if (currentCount > 0) {
                cantidades[id] = currentCount - 1;
            } else {
                return;
            }
            
            document.querySelector(`.counter-display[data-id="${id}"]`).textContent = cantidades[id];
            document.querySelector(`input[name="visitas[${id}]"]`).value = cantidades[id];

            if (id == afiliadoId) {
                const currentDniValues = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]')).map(inp => inp.value);
                if (!isIncrement) {
                    const dniToRemove = currentDniValues.pop();
                    if (dniToRemove) {
                        delete dniVerificationStatus[dniToRemove.replace(/-/g, '')];
                    }
                }
                updateAfiliadoDniFields(currentDniValues);
            }
            updateTotalPrice();
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-sync fa-spin mr-2 sm:mr-3"></i> Guardando...';

        const formData = new FormData(form);
        
        // Antes de enviar, nos aseguramos que los DNI vayan sin guiones
        document.querySelectorAll('input[name^="afiliado_dni"]').forEach(input => {
            const name = input.name;
            const cleanValue = input.value.replace(/-/g, '');
            formData.set(name, cleanValue);
        });

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: formData
        })
        .then(response => response.json().then(data => ({ ok: response.ok, data })))
        .then(({ ok, data }) => {
            if (ok) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Entendido'
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetForm();
                    }
                });
            } else {
                const errorMessage = data.message || Object.values(data.errors || {'': 'Ocurrió un error inesperado.'}).join('<br>');
                Swal.fire({ title: 'Error de Validación', html: errorMessage, icon: 'error' });
            }
        })
        .catch(() => {
            Swal.fire({ title: 'Error de Conexión', text: 'No se pudo procesar la solicitud.', icon: 'error' });
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save mr-2 sm:mr-3"></i> <span class="hidden xs:inline">Guardar Visita</span><span class="xs:hidden">Guardar</span>';
            updateTotalPrice();
        });
    });
    
    updateTotalPrice();
});