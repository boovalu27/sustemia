document.addEventListener('DOMContentLoaded', function () {
    // Para la nueva contraseña en el formulario de login
    const togglePasswordButtonLogin = document.getElementById('toggle-password-login');
    const passwordFieldLogin = document.getElementById('password');
    const iconLogin = document.getElementById('toggle-icon-login');

    if (togglePasswordButtonLogin && passwordFieldLogin && iconLogin) {
      togglePasswordButtonLogin.addEventListener('click', function () {
        if (passwordFieldLogin.type === 'password') {
          passwordFieldLogin.type = 'text';
          iconLogin.classList.remove('bi-eye-slash');
          iconLogin.classList.add('bi-eye');
        } else {
          passwordFieldLogin.type = 'password';
          iconLogin.classList.remove('bi-eye');
          iconLogin.classList.add('bi-eye-slash');
        }
      });
    } else {
      console.error('Los elementos de contraseña del formulario de login no se han encontrado correctamente.');
    }

    // Para la nueva contraseña en el formulario de restablecimiento de contraseña
    const togglePasswordButtonReset = document.getElementById('toggle-password-reset');
    const passwordFieldReset = document.getElementById('password');
    const iconReset = document.getElementById('toggle-icon-reset');

    if (togglePasswordButtonReset && passwordFieldReset && iconReset) {
      togglePasswordButtonReset.addEventListener('click', function () {
        if (passwordFieldReset.type === 'password') {
          passwordFieldReset.type = 'text';
          iconReset.classList.remove('bi-eye-slash');
          iconReset.classList.add('bi-eye');
        } else {
          passwordFieldReset.type = 'password';
          iconReset.classList.remove('bi-eye');
          iconReset.classList.add('bi-eye-slash');
        }
      });
    } else {
      console.error('Los elementos de nueva contraseña del formulario de restablecimiento no se han encontrado correctamente.');
    }

    // Para el campo de confirmar nueva contraseña en el formulario de restablecimiento de contraseña
    const toggleConfirmationPasswordButtonReset = document.getElementById('toggle-confirm-password-reset');
    const confirmationPasswordFieldReset = document.getElementById('password_confirmation');
    const confirmationIconReset = document.getElementById('toggle-confirm-icon-reset');

    if (toggleConfirmationPasswordButtonReset && confirmationPasswordFieldReset && confirmationIconReset) {
      toggleConfirmationPasswordButtonReset.addEventListener('click', function () {
        if (confirmationPasswordFieldReset.type === 'password') {
          confirmationPasswordFieldReset.type = 'text';
          confirmationIconReset.classList.remove('bi-eye-slash');
          confirmationIconReset.classList.add('bi-eye');
        } else {
          confirmationPasswordFieldReset.type = 'password';
          confirmationIconReset.classList.remove('bi-eye');
          confirmationIconReset.classList.add('bi-eye-slash');
        }
      });
    } else {
      console.error('Los elementos de confirmación de contraseña del formulario de restablecimiento no se han encontrado correctamente.');
    }
  });
