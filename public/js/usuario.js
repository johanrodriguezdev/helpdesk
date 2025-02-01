document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalPerfil');
    const openModalButton = document.getElementById('openModalButtonPerfil');
    const closeModalButton = document.getElementById('closeModalButtonPerfil');
    const formEditarPerfil = document.getElementById('formEditarPerfil');

    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        traerDatos();
        limpiarFormulario();
    });

    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
        limpiarFormulario();
    });


    formEditarPerfil.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(formEditarPerfil);

        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará tu información de perfil.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("/app/controller/usuarioController.php", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 🔹 Ocultar el modal antes de mostrar la alerta
                            modal.classList.add('hidden');

                            // 🔹 Asegurar que SweetAlert2 esté sobre el modal
                            Swal.fire({
                                title: "Éxito",
                                text: data.message,
                                icon: "success",
                                heightAuto: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            });

                            limpiarFormulario();
                        } else {
                            modal.classList.add('hidden');

                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error",
                                heightAuto: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: "Error",
                            text: "Error al procesar la solicitud.",
                            icon: "error",
                            heightAuto: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    });
            }
        });
    });

    document.getElementById('logoutButton').addEventListener('click', function() {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Tu sesión se cerrará y tendrás que iniciar sesión nuevamente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, cerrar sesión",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php';
            }
        });
    });
    

    function limpiarFormulario() {
        formEditarPerfil.reset();
        document.getElementById('usuario_id').value = '';
    }

});

function traerDatos() {
    fetch("/app/controller/usuarioController.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("usuario_id").value = data.usuario_id;
                document.getElementById("nombre").value = data.usuario_nombre;
                document.getElementById("correo").value = data.usuario_email;
            } else {
                console.log("Error:", data.message);
            }
        })
        .catch(error => console.error('Error en la petición:', error));
}