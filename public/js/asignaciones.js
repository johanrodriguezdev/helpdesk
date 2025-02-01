document.addEventListener('DOMContentLoaded', () => {
    cargarAsignaciones();

    const modal = document.getElementById('modal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const addAssignmentForm = document.getElementById('addAssignmentForm');

    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        limpiarFormulario();
    });

    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
        limpiarFormulario();
    });

    addAssignmentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addAssignmentForm);

        fetch("/app/controller/asignacionesController.php", {
            method: "POST",
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    modal.classList.add('hidden');
                    alerta("success", "Exito", data.message);
                    limpiarFormulario();
                    cargarAsignaciones();
                } else {
                    modal.classList.add('hidden');
                    alerta("error", "Error", data.message);
                }
            })
            .catch(error => {
                alerta("error", "Error", 'Error al procesar la solicitud.');
            });
    });

    function limpiarFormulario() {
        addAssignmentForm.reset();
        document.getElementById('asignacion-id').value = '';
        document.getElementById('submitButton').textContent = "Guardar";
        document.getElementById('modalTitle').textContent = 'Agregar Nueva Asignación';
    }

});

function cargarAsignaciones() {
    fetch("/app/controller/asignacionesController.php")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.asignaciones.length > 0) {
                limpiarTabla();
                cargarTabla(data.asignaciones);
            } else {
                console.warn("No hay asignaciones disponibles.");
                cargarTabla([]);
            }
        })
        .catch(error => console.error('Error al cargar asignaciones:', error));
}

function cargarTabla(data) {
    let html = "";
    data.forEach(asig => {
        html += `
            <tr>
                <td class="border border-gray-300 px-4 py-2">${asig.id}</td>
                <td class="border border-gray-300 px-4 py-2">${asig.cedula}</td>
                <td class="border border-gray-300 px-4 py-2">${asig.nombre}</td>
                <td class="border border-gray-300 px-4 py-2">${asig.correo}</td>
                <td class="border border-gray-300 px-4 py-2">${asig.telefono}</td>
                <td class="border border-gray-300 px-4 py-2">${asig.estado}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="editarAsignacion(${asig.id})">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </button>
                <button class="px-2 py-1 text-white rounded hover:bg-opacity-80" 
                    onclick="toggleAsignacion(${asig.id}, '${asig.estado}')" style="background-color: ${asig.estado == "Inactivo" ? '#28a745' : '#dc3545'}">
                    <i class="fas fa-toggle-${asig.estado == "Activo" ? 'on' : 'off'} mr-2"></i>
                    ${asig.estado == "Activo" ? 'Inactivar' : 'Activar'}
                </button>
                </td>
            </tr>`;
    });

    // Actualizar la tabla con los datos
    const tablaAsignaciones = document.getElementById('tabla-asignaciones');
    tablaAsignaciones.innerHTML = html;
    inicializarDataTable();
}

function limpiarTabla() {
    let tabla = $('#tablaAsignaciones').DataTable();
    if ($.fn.DataTable.isDataTable('#tablaAsignaciones')) {
        tabla.clear().destroy(); //Destruir la instancia previa
    }
}

function inicializarDataTable() {
    //Volver a inicializar después de actualizar la tabla
    $('#tablaAsignaciones').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "destroy": true,
        "language": {
            "sEmptyTable": "No hay datos disponibles en la tabla",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sLoadingRecords": "Cargando...",
            "sProcessing": "Procesando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "No se encontraron resultados",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
}

function editarAsignacion(id) {
    const modal = document.getElementById('modal');
    fetch(`/app/controller/asignacionesController.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('asignacion-id').value = data.asignacion.id;
                document.getElementById('nombre').value = data.asignacion.nombre;
                document.getElementById('cedula').value = data.asignacion.cedula;
                document.getElementById('correo').value = data.asignacion.correo;
                document.getElementById('telefono').value = data.asignacion.telefono;
                document.getElementById('estado').value = data.asignacion.estado;
                document.getElementById('submitButton').textContent = "Actualizar Asignación";
                document.getElementById('modalTitle').textContent = `Editar Asignación ID: ${data.asignacion.id}`;
                modal.classList.remove('hidden');
            } else {
                alerta("error", "Error", 'Error al obtener datos de la asignación.');
            }
        })
        .catch(error => {           
            alerta("error", "Error", 'Error al cargar los datos.');
        });
}

function toggleAsignacion(id, estado) {
    const nuevoEstado = estado === "Activo" ? 2 : 1;

    const datos = new URLSearchParams();
    datos.append('id', id);
    datos.append('estado', nuevoEstado);

    fetch('/app/controller/asignacionesController.php', {
        method: 'PUT',
        body: datos
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alerta("success", "Exito", data.message);
                cargarAsignaciones();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alerta("error", "Error", 'Error al cambiar el estado.');
        });
}

function alerta(icono, titulo, texto) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: texto,
        timer: 2000,
        showConfirmButton: false
    })
}

