document.addEventListener('DOMContentLoaded', function() {
    // Para la nueva contraseña
    const togglePasswordButton = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    const icon = document.getElementById('toggle-icon');

    if (togglePasswordButton && passwordField && icon) {
      togglePasswordButton.addEventListener('click', function() {
        if (passwordField.type === 'password') {
          passwordField.type = 'text';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        } else {
          passwordField.type = 'password';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        }
      });
    } else {
      console.error('Los elementos de contraseña no se han encontrado correctamente.');
    }

    // Para el campo de confirmar nueva contraseña
    const toggleConfirmationPasswordButton = document.getElementById('toggle-confirmation-password');
    const confirmationPasswordField = document.getElementById('password_confirmation');
    const confirmationIcon = document.getElementById('toggle-confirmation-icon');

    if (toggleConfirmationPasswordButton && confirmationPasswordField && confirmationIcon) {
      toggleConfirmationPasswordButton.addEventListener('click', function() {
        if (confirmationPasswordField.type === 'password') {
          confirmationPasswordField.type = 'text';
          confirmationIcon.classList.remove('bi-eye-slash');
          confirmationIcon.classList.add('bi-eye');
        } else {
          confirmationPasswordField.type = 'password';
          confirmationIcon.classList.remove('bi-eye');
          confirmationIcon.classList.add('bi-eye-slash');
        }
      });
    } else {
      console.error('Los elementos de confirmar contraseña no se han encontrado correctamente.');
    }
  });
