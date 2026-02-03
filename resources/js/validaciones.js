// Validaciones en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    
    // NOMBRE
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('name-error');
    const nameHelp = document.getElementById('name-help');
    
    nameInput.addEventListener('input', function() {
        const value = this.value.trim();
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/;
        
        if (value === '') {
            nameInput.classList.remove('input-valid', 'input-error');
            nameError.textContent = '';
            nameHelp.style.display = 'block';
        } else if (value.length < 3) {
            nameInput.classList.add('input-error');
            nameInput.classList.remove('input-valid');
            nameError.textContent = '❌ Debe tener al menos 3 caracteres';
            nameHelp.style.display = 'none';
        } else if (!regex.test(value)) {
            nameInput.classList.add('input-error');
            nameInput.classList.remove('input-valid');
            nameError.textContent = '❌ Solo letras y espacios';
            nameHelp.style.display = 'none';
        } else {
            nameInput.classList.add('input-valid');
            nameInput.classList.remove('input-error');
            nameError.textContent = '';
            nameHelp.style.display = 'block';
        }
    });

    // EMAIL
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const emailHelp = document.getElementById('email-help');
    
    emailInput.addEventListener('input', function() {
        const value = this.value.trim();
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (value === '') {
            emailInput.classList.remove('input-valid', 'input-error');
            emailError.textContent = '';
            emailHelp.style.display = 'block';
        } else if (!regex.test(value)) {
            emailInput.classList.add('input-error');
            emailInput.classList.remove('input-valid');
            emailError.textContent = '❌ Formato de correo inválido';
            emailHelp.style.display = 'none';
        } else {
            emailInput.classList.add('input-valid');
            emailInput.classList.remove('input-error');
            emailError.textContent = '';
            emailHelp.style.display = 'block';
        }
    });

    // TELÉFONO
    const telefonoInput = document.getElementById('telefono');
    const telefonoError = document.getElementById('telefono-error');
    const telefonoHelp = document.getElementById('telefono-help');
    
    telefonoInput.addEventListener('input', function() {
        const value = this.value.trim();
        const regex = /^[0-9]{10}$/;
        
        // Solo números
        this.value = this.value.replace(/[^0-9]/g, '');
        
        if (value === '') {
            telefonoInput.classList.remove('input-valid', 'input-error');
            telefonoError.textContent = '';
            telefonoHelp.style.display = 'block';
        } else if (value.length !== 10) {
            telefonoInput.classList.add('input-error');
            telefonoInput.classList.remove('input-valid');
            telefonoError.textContent = '❌ Debe tener exactamente 10 dígitos';
            telefonoHelp.style.display = 'none';
        } else if (!regex.test(value)) {
            telefonoInput.classList.add('input-error');
            telefonoInput.classList.remove('input-valid');
            telefonoError.textContent = '❌ Solo números';
            telefonoHelp.style.display = 'none';
        } else {
            telefonoInput.classList.add('input-valid');
            telefonoInput.classList.remove('input-error');
            telefonoError.textContent = '';
            telefonoHelp.style.display = 'block';
        }
    });

    // CONTRASEÑA
    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('password-error');
    const passwordHelp = document.getElementById('password-help');
    
    passwordInput.addEventListener('input', function() {
        const value = this.value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
        
        if (value === '') {
            passwordInput.classList.remove('input-valid', 'input-error');
            passwordError.textContent = '';
            passwordHelp.style.display = 'block';
        } else if (value.length < 8) {
            passwordInput.classList.add('input-error');
            passwordInput.classList.remove('input-valid');
            passwordError.textContent = '❌ Mínimo 8 caracteres';
            passwordHelp.style.display = 'none';
        } else if (!regex.test(value)) {
            passwordInput.classList.add('input-error');
            passwordInput.classList.remove('input-valid');
            passwordError.textContent = '❌ Falta: mayúscula, minúscula o número';
            passwordHelp.style.display = 'none';
        } else {
            passwordInput.classList.add('input-valid');
            passwordInput.classList.remove('input-error');
            passwordError.textContent = '';
            passwordHelp.style.display = 'block';
        }
        
        // Validar confirmación si ya tiene valor
        if (passwordConfirmationInput.value !== '') {
            passwordConfirmationInput.dispatchEvent(new Event('input'));
        }
    });

    // CONFIRMAR CONTRASEÑA
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const passwordConfirmationError = document.getElementById('password_confirmation-error');
    const passwordConfirmationHelp = document.getElementById('password_confirmation-help');
    
    passwordConfirmationInput.addEventListener('input', function() {
        const value = this.value;
        const passwordValue = passwordInput.value;
        
        if (value === '') {
            passwordConfirmationInput.classList.remove('input-valid', 'input-error');
            passwordConfirmationError.textContent = '';
            passwordConfirmationHelp.style.display = 'block';
        } else if (value !== passwordValue) {
            passwordConfirmationInput.classList.add('input-error');
            passwordConfirmationInput.classList.remove('input-valid');
            passwordConfirmationError.textContent = '❌ Las contraseñas no coinciden';
            passwordConfirmationHelp.style.display = 'none';
        } else {
            passwordConfirmationInput.classList.add('input-valid');
            passwordConfirmationInput.classList.remove('input-error');
            passwordConfirmationError.textContent = '';
            passwordConfirmationHelp.style.display = 'block';
        }
    });

    // VALIDAR ANTES DE ENVIAR
    const form = document.getElementById('registroForm');
    
    form.addEventListener('submit', function(e) {
        let hayErrores = false;
        
        // Disparar validaciones
        nameInput.dispatchEvent(new Event('input'));
        emailInput.dispatchEvent(new Event('input'));
        if (telefonoInput.value !== '') {
            telefonoInput.dispatchEvent(new Event('input'));
        }
        passwordInput.dispatchEvent(new Event('input'));
        passwordConfirmationInput.dispatchEvent(new Event('input'));
        
        // Verificar errores
        const errores = document.querySelectorAll('.input-error');
        
        if (errores.length > 0) {
            e.preventDefault();
            alert('Por favor corrige los errores antes de continuar');
            hayErrores = true;
        }
        
        // Verificar campos requeridos vacíos
        if (nameInput.value.trim() === '' || 
            emailInput.value.trim() === '' || 
            passwordInput.value === '' || 
            passwordConfirmationInput.value === '') {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios');
            hayErrores = true;
        }
    });
});