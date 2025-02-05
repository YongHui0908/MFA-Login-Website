document.addEventListener("DOMContentLoaded", function () {
    // Get the original values of the fields
    const originalValues = {
        phonenumber: document.getElementById("phonenumber").value.trim(),
        homeaddress: document.getElementById("homeaddress").value.trim(),
    };

    document.getElementById("profileForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const phonenumber = document.getElementById("phonenumber").value.trim();
        const homeaddress = document.getElementById("homeaddress").value.trim();
        const phoneRegex = /^\+?[0-9]{7,15}$/;

        // Check for no changes
        if (
            phonenumber === originalValues.phonenumber &&
            homeaddress === originalValues.homeaddress
        ) {
            Swal.fire({
                icon: "info",
                title: "No Changes Detected",
                text: "You haven't made any changes to your profile.",
            });
            return; // Stop form submission
        }

        if (!phonenumber) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Phone number cannot be empty.",
            });
            return; // Stop form submission
        }

        if (!phoneRegex.test(phonenumber)) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Invalid phone number format. Please enter a valid phone number.",
            });
            return; // Stop form submission
        }

        if (homeaddress.length < 10) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Home address must be at least 10 characters long.",
            });
            return; // Stop form submission
        }


        const formData = new FormData(this);

        fetch("../Online University Examination Website/profile_update.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                    }).then(() => {
                        // Refresh the page after the user clicks "OK"
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message,
                    });
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An unexpected error occurred",
                });
            });
    });
});
