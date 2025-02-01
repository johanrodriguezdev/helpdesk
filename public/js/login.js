document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const registroUsuario = document.getElementById("registroUsuario");

    registroUsuario.addEventListener("click", function (event) {
        event.preventDefault();
        window.location.href = "/app/view/registro.php";
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita que la página se recargue

        const formData = new FormData(form);

        fetch("/app/controller/loginController.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "¡Bienvenido!",
                        text: "Inicio de sesión exitoso",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "/app/view/dashboard.php"; // Redirección al dashboard
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema con la conexión al servidor."
                });
                console.error("Error en la solicitud:", error);
            });
    });


});
