document.addEventListener('DOMContentLoaded', () => {
    cargarTickets();
    cargarFechaActual();
    cargarCombos('/app/controller/categoriasController.php', 'categoriaTicket', 'categorias');
    cargarCombos('/app/controller/asignacionesController.php', 'usuAsignacion', 'asignaciones');

    const modal = document.getElementById('modal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const addTicketForm = document.getElementById('addTicketForm');

    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        limpiarFormulario();
    });

    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
        limpiarFormulario();
    });

    addTicketForm.addEventListener('submit', (e) => {
        e.preventDefault();       
        const formData = new FormData(addTicketForm);

        fetch("/app/controller/ticketController.php", {
            method: "POST",
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    modal.classList.add('hidden');
                    alerta("success", "Exito", data.message);
                    limpiarFormulario();
                    cargarTickets();
                } else {
                    modal.classList.add('hidden');
                    alerta("error", "Error", data.message);
                }
            })
            .catch(error => {
                alerta("error", "Error", 'Error al procesar la solicitud.');
            });
    });

    function cargarCombos(url, combo, nombre) {
        $.ajax({
            url: url + "?combo=1",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let select = $("#" + combo);
                select.empty();
                select.append('<option value="">Seleccionar Opción</option>');
                data[nombre].forEach(function (item) {
                    select.append(`<option value="${item.id}">${item.name}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar el combo:", combo, " --- ", error);
            }
        });
    }

    function limpiarFormulario() {
        addTicketForm.reset();
        cargarFechaActual();
        document.getElementById('ticket-id').value = '';
        document.getElementById('submitButton').textContent = "Guardar";
        document.getElementById('modalTitle').textContent = 'Agregar Nuevo Ticket';
    }

});

function cargarTickets() {
    fetch("/app/controller/ticketController.php")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.tickets.length > 0) {
                limpiarTabla();
                cargarTabla(data.tickets);
            } else {
                console.warn("No hay tickets disponibles.");
                cargarTabla([]);
            }
        })
        .catch(error => console.error('Error al cargar tickets:', error));
}

function cargarTabla(data) {
    let html = "";
    data.forEach(tick => {
        html += `
            <tr>
                <td class="border border-gray-300 px-4 py-2">${tick.id}</td>
                <td class="border border-gray-300 px-4 py-2">${tick.fecha}</td>
                <td class="border border-gray-300 px-4 py-2">${tick.titulo}</td>
                <td class="border border-gray-300 px-4 py-2">${tick.nomCategoria}</td>
                <td class="border border-gray-300 px-4 py-2">${tick.estado}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" 
                        onclick="mostrarDetalles('${tick.fecha}', '${tick.titulo}', '${tick.descripcion}', '${tick.comentario}', '${tick.estado}', '${tick.nomCategoria}', '${tick.cedTrabajador}', '${tick.nomTrabajador}', '${tick.prioridad}', '${tick.nomUsu}')">
                        <i class="fas fa-info-circle mr-2"></i>Detalles
                    </button>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="editarTicket(${tick.id})">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </button>
                    <button class="px-2 py-1 text-white rounded hover:bg-opacity-80" 
                        onclick="toggleTicket(${tick.id}, '${tick.estado}')" 
                        style="background-color: ${tick.estado == "Inactivo" ? '#28a745' : '#dc3545'}">
                        <i class="fas fa-toggle-${tick.estado == "Activo" ? 'on' : 'off'} mr-2"></i>
                        ${tick.estado == "Activo" ? 'Inactivar' : 'Activar'}
                    </button>
                </td>
            </tr>`;
    });

    // Actualizar la tabla con los datos
    const tablaTickets = document.getElementById('tabla-tickets');
    tablaTickets.innerHTML = html;
    inicializarDataTable();
}

function limpiarTabla() {
    let tabla = $('#tablaTickets').DataTable();
    if ($.fn.DataTable.isDataTable('#tablaTickets')) {
        tabla.clear().destroy(); //Destruir la instancia previa
    }
}

function inicializarDataTable() {
    //Volver a inicializar después de actualizar la tabla
    $('#tablaTickets').DataTable({
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

function editarTicket(id) {
    const modal = document.getElementById('modal');
    fetch(`/app/controller/ticketController.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('ticket-id').value = data.ticket.id;
                document.getElementById('fecha').value = data.ticket.fecha;
                document.getElementById('titulo').value = data.ticket.titulo;
                document.getElementById('descripcion').value = data.ticket.descripcion;
                document.getElementById('comentario').value = data.ticket.comentario;
                document.getElementById('estado').value = data.ticket.idestado;
                document.getElementById('categoriaTicket').value = data.ticket.idCategoria;
                document.getElementById('usuAsignacion').value = data.ticket.idTrabajador;
                document.getElementById('prioridad').value = data.ticket.prioridad;
                document.getElementById('submitButton').textContent = "Actualizar Ticket";
                document.getElementById('modalTitle').textContent = `Editar Ticket ID: ${data.ticket.id}`;
                modal.classList.remove('hidden');
            } else {
                alerta("error", "Error", 'Error al obtener datos de la ticket.');
            }
        })
        .catch(error => {           
            alerta("error", "Error", 'Error al cargar los datos.');
        });
}

function toggleTicket(id, estado) {
    const nuevoEstado = estado === "Activo" ? 2 : 1;

    const datos = new URLSearchParams();
    datos.append('id', id);
    datos.append('estado', nuevoEstado);

    fetch('/app/controller/ticketController.php', {
        method: 'PUT',
        body: datos
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alerta("success", "Exito", data.message);
                cargarTickets();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alerta("error", "Error", 'Error al cambiar el estado.');
        });
}

function mostrarDetalles(fecha,titulo,descripcion,comentario,estado,categoria,cedTrabajador,nomTrabajador,prioridad,nomUsu) {

    document.getElementById('detalle-fecha').textContent = fecha;
    document.getElementById('detalle-titulo').textContent = titulo;
    document.getElementById('detalle-descripcion').textContent = descripcion || "Sin descripción";
    document.getElementById('detalle-comentario').textContent = comentario || "Sin comentarios";
    document.getElementById('detalle-estado').textContent = estado;
    document.getElementById('detalle-categoria').textContent = categoria;
    document.getElementById('detalle-cedAsignado').textContent = cedTrabajador || "No asignado";
    document.getElementById('detalle-asignado').textContent = nomTrabajador || "No asignado";
    document.getElementById('detalle-usuCreacion').textContent = (nomUsu !=="" && nomUsu !=='null') ? nomUsu : "No asignado";
    document.getElementById('detalle-prioridad').textContent = (prioridad == "0") ? 'Baja' : ((prioridad == "1") ? "Medio" :((prioridad=="2") ? "Alto": ""));

    document.getElementById('modalDetalles').classList.remove('hidden');
}

// Función para cerrar el modal de detalles
function cerrarModalDetalles() {
    document.getElementById('modalDetalles').classList.add('hidden');
}

function cargarFechaActual() {
    let fechaInput = document.getElementById("fecha");
    let fecha = new Date();
    let year = fecha.getFullYear();
    let month = String(fecha.getMonth() + 1).padStart(2, '0');
    let day = String(fecha.getDate()).padStart(2, '0');

    let fechaActual = `${day}-${month}-${year}`;
    fechaInput.value = fechaActual;
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