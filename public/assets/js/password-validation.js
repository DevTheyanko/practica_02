form.addEventListener('submit', function (e) {
    let allValid = true;

    passwordFields.forEach(passwordInput => {
        if (form.contains(passwordInput)) {
            const password = passwordInput.value;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*]/.test(password)
            };

            const fieldValid = Object.values(requirements).every(valid => valid);
            allValid = allValid && fieldValid;

            if (!fieldValid) {
                const validationContainer = passwordInput.nextElementSibling;
                if (validationContainer && validationContainer.classList.contains('password-validation-container')) {
                    validationContainer.classList.add('active');
                    validationContainer.style.animation = 'shake 0.5s';
                    setTimeout(() => {
                        validationContainer.style.animation = '';
                    }, 500);
                }
                passwordInput.focus();
            }
        }
    });

    if (!allValid) {
        e.preventDefault();

        // ✅ Mostrar notificación tipo popup (SweetAlert2)
        Swal.fire({
            icon: 'warning',
            title: 'Contraseña inválida',
            text: 'Por favor, asegúrate de que todas las contraseñas cumplan con los requisitos de seguridad.',
            confirmButtonColor: '#f39c12'
        });
    }
});
