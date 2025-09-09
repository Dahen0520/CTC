<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="max-w-6xl mx-auto space-y-8 p-4 sm:p-6">

        {{-- Formulario principal mejorado --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            {{-- Header del formulario --}}
            <div class="bg-gradient-to-br from-chorotega-blue via-blue-600 to-chorotega-blue-light p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="absolute top-0 right-0 transform translate-x-16 -translate-y-8">
                    <div class="w-32 h-32 bg-white bg-opacity-10 rounded-full"></div>
                </div>
                <div class="absolute bottom-0 left-0 transform -translate-x-8 translate-y-8">
                    <div class="w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                </div>
                
                <div class="relative flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white border-opacity-30">
                            <i class="fas fa-clipboard-list text-white text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 sm:ml-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">Registrar Nueva Visita</h2>
                        <p class="text-blue-100 text-sm sm:text-base">Selecciona los tipos de visita y cantidades necesarias</p>
                    </div>
                </div>
            </div>

            {{-- Contenido del formulario --}}
            <div class="p-4 sm:p-6 lg:p-8">
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-sm">
                    {{-- Error content --}}
                </div>
                @endif

                <form id="visita-form" method="POST" action="{{ route('visitas.store') }}" class="space-y-6 sm:space-y-8">
                    @csrf
                    
                    <div class="flex items-center mb-4 sm:mb-6">
                        <div class="flex-grow h-px bg-gray-200"></div>
                        <h3 class="px-4 sm:px-6 text-base sm:text-lg font-semibold text-gray-700 bg-white">Tipos de Visita Disponibles</h3>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>
                    
                    {{-- Lista vertical de tipos de visita --}}
                    <div id="visita-counters-list" class="space-y-4 sm:space-y-6">
                        @foreach($tiposVisita as $tipo)
                        <div id="tipo-visita-{{ $tipo->id }}" class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-4 sm:p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-blue-300">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- Información del tipo de visita --}}
                                <div class="flex items-center flex-1">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-chorotega-blue to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow mr-4 sm:mr-6">
                                        <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-1 truncate">{{ $tipo->nombre }}</h4>
                                        <div class="flex flex-col sm:flex-row sm:items-center">
                                            <span class="text-2xl sm:text-3xl font-bold text-chorotega-blue">L. {{ number_format($tipo->precio, 2) }}</span>
                                            <span class="text-sm text-gray-500 sm:ml-2">por visita</span>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Controles de cantidad --}}
                                <div class="flex items-center justify-center space-x-4 bg-white rounded-xl p-4 shadow-sm flex-shrink-0">
                                    <button type="button" class="decrement-btn w-12 h-12 sm:w-14 sm:h-14 bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95" data-id="{{ $tipo->id }}">
                                        <i class="fas fa-minus text-lg font-bold"></i>
                                    </button>
                                    
                                    <div class="text-center min-w-[80px] sm:min-w-[100px]">
                                        <span class="counter-display text-3xl sm:text-4xl font-bold text-gray-800 block leading-none" data-id="{{ $tipo->id }}">0</span>
                                        <span class="text-sm text-gray-500 mt-1 block">cantidad</span>
                                    </div>
                                    
                                    <button type="button" class="increment-btn w-12 h-12 sm:w-14 sm:h-14 bg-green-100 hover:bg-green-200 text-green-600 hover:text-green-700 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95" data-id="{{ $tipo->id }}">
                                        <i class="fas fa-plus text-lg font-bold"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <input type="hidden" name="visitas[{{ $tipo->id }}]" value="0" class="visita-input-field">

                            @if ($tipo->nombre === 'Afiliado')
                            <div id="afiliado-dni-container" class="mt-4 sm:mt-6 space-y-3 sm:space-y-4"></div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- Sección de resumen --}}
                    <div id="precio-info" class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 sm:p-8 hidden shadow-lg">
                       <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-500 rounded-2xl flex items-center justify-center shadow-md flex-shrink-0">
                                    <i class="fas fa-calculator text-white text-lg sm:text-xl"></i>
                                </div>
                                <div class="ml-4 sm:ml-6">
                                    <h4 class="text-lg sm:text-xl font-bold text-gray-800 mb-1">Resumen de Pago</h4>
                                    <p class="text-gray-600 text-sm sm:text-base">Total a pagar por todas las visitas</p>
                                </div>
                            </div>
                            <div class="text-center sm:text-right">
                                <p class="text-sm text-gray-600 mb-1">Total</p>
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600">
                                    L. <span id="precio-display">0.00</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-6 sm:pt-8 border-t border-gray-200">
                        <button type="button" id="submit-btn" disabled class="flex-1 bg-gray-400 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold cursor-not-allowed flex items-center justify-center text-base sm:text-lg transition-all duration-300 shadow-lg order-2 sm:order-1">
                            <i class="fas fa-save mr-2 sm:mr-3 text-lg sm:text-xl"></i>
                            <span class="hidden xs:inline">Guardar Visita</span>
                            <span class="xs:hidden">Guardar</span>
                        </button>
                        
                        <a href="{{ route('visitas.index') }}" class="flex-1 sm:flex-initial bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold transition-all duration-300 flex items-center justify-center text-base sm:text-lg shadow-lg hover:shadow-xl order-1 sm:order-2">
                            <i class="fas fa-times mr-2 sm:mr-3 text-lg sm:text-xl"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('visita-form');
            const submitBtn = document.getElementById('submit-btn');
            const precioDisplay = document.getElementById('precio-display');
            const precioInfo = document.getElementById('precio-info');
            const tiposVisita = @json($tiposVisita->keyBy('id'));
            const afiliadoId = Object.values(tiposVisita).find(tipo => tipo.nombre === 'Afiliado')?.id;
            const afiliadoContainer = document.getElementById('tipo-visita-' + afiliadoId);
            const afiliadoDniContainer = afiliadoContainer?.querySelector('#afiliado-dni-container');
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

            function updateAfiliadoDniFields() {
                const afiliadoCount = cantidades[afiliadoId] || 0;
                if (!afiliadoDniContainer) return;
                
                const existingFields = Array.from(afiliadoDniContainer.querySelectorAll('input[type="text"]'));
                const dniValues = existingFields.map(input => input.value);
                
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
                        input.placeholder = `Identidad Afiliado ${i + 1}`;
                        input.maxLength = 13;
                        input.className = 'flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-base font-medium';
                        
                        const dniValue = dniValues[i] || '';
                        input.value = dniValue;
                        
                        const buttonsContainer = document.createElement('div');
                        buttonsContainer.className = 'flex space-x-2 flex-shrink-0';

                        const checkBtn = document.createElement('button');
                        checkBtn.type = 'button';
                        checkBtn.innerHTML = '<i class="fas fa-check"></i>';
                        
                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'delete-dni-btn px-4 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors';
                        deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                        
                        input.addEventListener('input', function() {
                            this.value = this.value.replace(/[^0-9]/g, '');
                            if (this.value.length === 13) {
                                verificarDni(this.value, input, checkBtn);
                            }
                        });

                        deleteBtn.addEventListener('click', function() {
                            inputGroup.remove();
                            const mainDecrementBtn = document.querySelector(`.decrement-btn[data-id="${afiliadoId}"]`);
                            if(mainDecrementBtn) mainDecrementBtn.click();
                        });

                        checkBtn.addEventListener('click', function() {
                            verificarDni(input.value, input, checkBtn);
                        });
                        
                        buttonsContainer.appendChild(checkBtn);
                        buttonsContainer.appendChild(deleteBtn);
                        inputGroup.appendChild(input);
                        inputGroup.appendChild(buttonsContainer);
                        afiliadoDniContainer.appendChild(inputGroup);
                        
                        checkBtn.className = 'check-dni-btn px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors';
                        if (dniVerificationStatus[dniValue] === true) {
                            checkBtn.innerHTML = '<i class="fas fa-check text-green-600"></i>';
                            checkBtn.className = 'check-dni-btn px-4 py-3 bg-green-100 hover:bg-green-200 text-green-600 rounded-xl border border-green-200';
                            input.readOnly = true;
                            input.classList.add('bg-green-50', 'border-green-300');
                        } else if (dniVerificationStatus[dniValue] === false) {
                            checkBtn.innerHTML = '<i class="fas fa-times text-red-600"></i>';
                            checkBtn.className = 'check-dni-btn px-4 py-3 bg-red-100 hover:bg-red-200 text-red-600 rounded-xl border border-red-200';
                            input.classList.add('bg-red-50', 'border-red-300');
                        }
                    }
                }
            }
            
            function verificarDni(dni, inputElement, buttonElement) {
                const cleanDni = dni.replace(/[^0-9]/g, '');
                if (cleanDni.length !== 13) return;
                
                buttonElement.innerHTML = '<i class="fas fa-sync fa-spin"></i>';
                buttonElement.disabled = true;
                inputElement.disabled = true;

                fetch("{{ route('afiliados.verificar') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ dni: cleanDni })
                })
                .then(response => response.json())
                .then(data => {
                    buttonElement.disabled = false;
                    inputElement.disabled = false;
                    dniVerificationStatus[cleanDni] = data.success;
                    updateAfiliadoDniFields();
                    updateTotalPrice(); 
                })
                .catch(error => {
                    buttonElement.disabled = false;
                    inputElement.disabled = false;
                    dniVerificationStatus[cleanDni] = false;
                    updateAfiliadoDniFields();
                    updateTotalPrice(); 
                    Swal.fire({ title: 'Error', text: 'Ocurrió un error de conexión al verificar.', icon: 'error' });
                });
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
                    if (dniInputs.length !== afiliadoCount || dniInputs.some(input => dniVerificationStatus[input.value] !== true)) {
                        allAfiliadosAreValid = false;
                    }
                }

                if (hasSelections && allAfiliadosAreValid) {
                    precioDisplay.textContent = total.toFixed(2);
                    precioInfo.classList.remove('hidden');
                    precioInfo.classList.add('animate-fade-in');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-gradient-to-r', 'from-chorotega-blue', 'to-chorotega-blue-light', 'hover:shadow-xl', 'transform', 'hover:-translate-y-0.5');
                } else {
                    if (hasSelections) {
                        precioDisplay.textContent = total.toFixed(2);
                        precioInfo.classList.remove('hidden');
                        precioInfo.classList.add('animate-fade-in');
                    } else {
                        precioInfo.classList.add('hidden');
                    }
                    submitBtn.disabled = true;
                    submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    submitBtn.classList.remove('bg-gradient-to-r', 'from-chorotega-blue', 'to-chorotega-blue-light', 'hover:shadow-xl', 'transform', 'hover:-translate-y-0.5');
                }
            }

            document.querySelectorAll('.increment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    cantidades[id] = (cantidades[id] || 0) + 1;
                    document.querySelector(`.counter-display[data-id="${id}"]`).textContent = cantidades[id];
                    document.querySelector(`input[name="visitas[${id}]"]`).value = cantidades[id];
                    if (id == afiliadoId) {
                        updateAfiliadoDniFields();
                    }
                    updateTotalPrice();
                });
            });

            document.querySelectorAll('.decrement-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    if ((cantidades[id] || 0) > 0) {
                        cantidades[id]--;
                        document.querySelector(`.counter-display[data-id="${id}"]`).textContent = cantidades[id];
                        document.querySelector(`input[name="visitas[${id}]"]`).value = cantidades[id];
                        if (id == afiliadoId) {
                            updateAfiliadoDniFields();
                        }
                        updateTotalPrice();
                    }
                });
            });
            
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) return response.json().then(err => Promise.reject(err));
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            resetForm();
                        });
                    } else {
                         Swal.fire({ title: 'Error', text: data.message || 'Ocurrió un error al guardar.', icon: 'error' });
                    }
                })
                .catch(error => {
                    const errorMessage = error.message || Object.values(error.errors || {'': 'Ocurrió un error inesperado.'}).join('\n');
                    Swal.fire({ title: 'Error', text: errorMessage, icon: 'error' });
                });
            });
            
            updateTotalPrice();
        });
    </script>

    <style>
        @keyframes fade-in {
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Breakpoint personalizado para pantallas muy pequeñas */
        @media (min-width: 480px) {
            .xs\:inline { display: inline; }
            .xs\:hidden { display: none; }
        }
        
        @media (max-width: 479px) {
            .xs\:inline { display: none; }
            .xs\:hidden { display: inline; }
        }
    </style>
</x-app-layout>