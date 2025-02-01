document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita la recarga de la página

        const formData = new FormData(form);

        fetch("/app/controller/registerController.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/index.php"; // Redirigir al login
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: data.message
                });
            }
        })
        .catch(error => console.error("Error en la petición:", error));
    });
});
