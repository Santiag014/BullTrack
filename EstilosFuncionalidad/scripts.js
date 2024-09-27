document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const resetMessage = document.getElementById('reset-message');
    const form = document.getElementById('login-form');
    const forgetPassword = document.getElementById('forget-password');

    const validateEmail = (email) => {
        const validacionCaracterEspecial = /[*%;$#:&()=¿?¡!]/;
        if (email.trim() === "") {
            return "Digite un correo electrónico válido.";
        } else if (validacionCaracterEspecial.test(email)) {
            return "No se admiten caracteres especiales.";
        } else {
            return '';
        }
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let emailErrorText = '';
        let passwordErrorText = '';

        if (emailInput.value.trim() === '') {
            emailErrorText = 'Correo electrónico es obligatorio.';
        }

        if (passwordInput.value.trim() === '') {
            passwordErrorText = 'La contraseña es obligatoria.';
        }

        if (emailErrorText || passwordErrorText) {
            emailError.textContent = emailErrorText;
            passwordError.textContent = passwordErrorText;
        } else {
            emailError.textContent = '';
            passwordError.textContent = '';

            console.log('Form submitted', {
                email: emailInput.value,
                password: passwordInput.value
            });

            // // Redireccionar a la página de Dashboard
            // window.location.href = '../Comercial/DashboardComercial.php';
        }
    });

    forgetPassword.addEventListener('click', () => {
        resetMessage.textContent = 'Contectese con Data, para Recuperar la Contraseña. \nPor favor';
    });

    emailInput.addEventListener('input', () => {
        emailError.textContent = validateEmail(emailInput.value);
    });
});
