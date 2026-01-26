// resources/js/login.js

document.addEventListener('DOMContentLoaded', function() {
    // Función para generar CAPTCHA
    function generateCaptcha() {
        const captchaQuestion = document.getElementById('captcha-question');
        const captchaToken = document.getElementById('captcha-token');
        const captchaAnswer = document.getElementById('captcha-answer');
        
        // Verificar que los elementos existan
        if (!captchaQuestion || !captchaToken || !captchaAnswer) {
            console.error('Elementos de CAPTCHA no encontrados');
            return;
        }
        
        captchaQuestion.textContent = 'Cargando...';
        
        fetch('/captcha/generate', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                captchaQuestion.textContent = data.question;
                captchaToken.value = data.token;
                captchaAnswer.value = '';
                captchaAnswer.focus();
            } else {
                throw new Error(data.error || 'Error desconocido');
            }
        })
        .catch(error => {
            console.error('Error al generar CAPTCHA:', error);
            captchaQuestion.textContent = 'Error al cargar. Haz clic en 🔄';
            captchaQuestion.style.color = '#e74c3c';
        });
    }
    
    // Botón de refrescar CAPTCHA
    const refreshButton = document.getElementById('refresh-captcha');
    if (refreshButton) {
        refreshButton.addEventListener('click', function(e) {
            e.preventDefault();
            generateCaptcha();
        });
    }
    
    // Generar CAPTCHA al cargar
    generateCaptcha();
    
    // Validación del formulario
    const form = document.querySelector('.login-card');
    if (form) {
        form.addEventListener('submit', function(e) {
            const captchaAnswer = document.getElementById('captcha-answer');
            const captchaToken = document.getElementById('captcha-token');
            
            if (!captchaAnswer || !captchaAnswer.value.trim()) {
                e.preventDefault();
                alert('Por favor resuelve la operación matemática');
                return false;
            }
            
            if (!captchaToken || !captchaToken.value) {
                e.preventDefault();
                alert('Error en el CAPTCHA. Por favor recarga la página');
                return false;
            }
        });
    }
});