document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../Online University Examination Website/create_exam.php", {
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
                //this.reset(); // Optionally reset the form
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: data.errors.join("<br>"),
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred.",
            });
        });
});
