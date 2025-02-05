document.getElementById('logout').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default link behavior
    Swal.fire({
        // icon: 'warning',
        title: 'Signing out...',
        timer: 1000,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    }).then(() => {
            window.location.href = '../Online University Examination Website/logout.php'; // Redirect to logout.php
    });
});