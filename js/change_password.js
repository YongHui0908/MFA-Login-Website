// Regular expression to validate password
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

const passwordField = document.getElementById('newPassword');
const passwordHelp = document.getElementById('passwordHelpInline');

// Validate password on input
passwordField.addEventListener('input', () => {
    if (passwordRegex.test(passwordField.value)) {
        passwordHelp.textContent = ' * Password is strong.';
        passwordHelp.style.color = 'green';
    } else {
        passwordHelp.textContent = ' * Password is weak';
        passwordHelp.style.color = 'red';
    }
});

document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('../Online University Examination Website/change_password.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Password Changed',
                text: data.message,
                confirmButtonText: 'OK',
            }).then(() => {
                document.getElementById('changePasswordForm').reset(); // Reset the form on success
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
        });
    });
});

