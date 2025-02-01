document.addEventListener('DOMContentLoaded', () => {
    cargarTickets();
});

function cargarTickets() {
    fetch("/app/controller/ticketController.php?estId=1")
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
                <td class="border border-gray-300 px-4 py-2">${(tick.tickEstado == "0") ? 'Abierto' : ((tick.tickEstado == "1") ? "Cerrado" : ((tick.tickEstado == "2") ? "Anulado" : ""))}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" 
                        onclick="mostrarDetalles('${tick.fecha}', '${tick.titulo}', '${tick.descripcion}', '${tick.comentario}', '${tick.estado}', '${tick.nomCategoria}', '${tick.cedTrabajador}', '${tick.nomTrabajador}', '${tick.prioridad}', '${tick.nomUsu}')">
                        <i class="fas fa-info-circle mr-2"></i>Detalles
                    </button>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    ${tick.tickEstado == "0" ? `
                        <button class="px-2 py-1 text-white rounded hover:bg-opacity-80 flex items-center" 
                                style="background-color:#28a745" 
                                onclick="gestionarTicket('${tick.id}', 1)">
                            <i class="fas fa-check-circle mr-2"></i> Cerrar
                        </button>
                        <button class="px-2 py-1 text-white rounded hover:bg-opacity-80 flex items-center" 
                                style="background-color:#dc3545" 
                                onclick="gestionarTicket('${tick.id}', 2)">
                            <i class="fas fa-times-circle mr-2"></i> Anular
                        </button>
                    ` : ''}
                </td>           
            </tr>`;
    });

    // Actualizar la tabla con los datos
    const tablaMisTickets = document.getElementById('tabla-misTickets');
    tablaMisTickets.innerHTML = html;
    inicializarDataTable();
}

function limpiarTabla() {
    let tabla = $('#tablaMisTickets').DataTable();
    if ($.fn.DataTable.isDataTable('#tablaMisTickets')) {
        tabla.clear().destroy(); //Destruir la instancia previa
    }
}

function inicializarDataTable() {
    //Volver a inicializar después de actualizar la tabla
    $('#tablaMisTickets').DataTable({
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

function mostrarDetalles(fecha, titulo, descripcion, comentario, estado, categoria, cedTrabajador, nomTrabajador, prioridad, nomUsu) {

    document.getElementById('detalle-fecha').textContent = fecha;
    document.getElementById('detalle-titulo').textContent = titulo;
    document.getElementById('detalle-descripcion').textContent = descripcion || "Sin descripción";
    document.getElementById('detalle-comentario').textContent = comentario || "Sin comentarios";
    document.getElementById('detalle-estado').textContent = estado;
    document.getElementById('detalle-categoria').textContent = categoria;
    document.getElementById('detalle-cedAsignado').textContent = cedTrabajador || "No asignado";
    document.getElementById('detalle-asignado').textContent = nomTrabajador || "No asignado";
    document.getElementById('detalle-usuCreacion').textContent = (nomUsu !== "" && nomUsu !== 'null') ? nomUsu : "No asignado";
    document.getElementById('detalle-prioridad').textContent = (prioridad == "0") ? 'Baja' : ((prioridad == "1") ? "Medio" : ((prioridad == "2") ? "Alto" : ""));

    document.getElementById('modalDetalles').classList.remove('hidden');
}

// Función para cerrar el modal de detalles
function cerrarModalDetalles() {
    document.getElementById('modalDetalles').classList.add('hidden');
}

function gestionarTicket(id, accion) {
    let mensaje = accion === 1 ? "¿Estás seguro de que deseas CERRAR este ticket?"
        : "¿Estás seguro de que deseas ANULAR este ticket?";
    let confirmButtonColor = accion === 1 ? "#28a745" : "#dc3545"; // Verde para cerrar, rojo para anular

    Swal.fire({
        title: "Confirmar Acción",
        text: mensaje,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: "#6c757d",
        confirmButtonText: accion === 1 ? "Sí, cerrar" : "Sí, anular",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            const datos = new URLSearchParams();
            datos.append('id', id);
            datos.append('accion', accion);

            fetch("/app/controller/ticketController.php", {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: datos
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "¡Éxito!",
                            text: "El ticket ha sido actualizado correctamente.",
                            icon: "success",
                            confirmButtonColor: "#3085d6"
                        }).then(() => location.reload()); // Recargar la página después de aceptar
                    } else {
                        Swal.fire("Error", "Hubo un problema al procesar la solicitud.", "error");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("Error", "Hubo un problema con la conexión.", "error");
                });
        }
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