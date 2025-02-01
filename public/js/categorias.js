document.addEventListener('DOMContentLoaded', () => {
    cargarCategorias();

    const modal = document.getElementById('modal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const addCategoryForm = document.getElementById('addCategoryForm');

    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        limpiarFormulario();
    });

    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
        limpiarFormulario();
    });

    addCategoryForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addCategoryForm);

        fetch("/app/controller/categoriasController.php", {
            method: "POST",
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    modal.classList.add('hidden');
                    alerta("success", "Exito", data.message);
                    limpiarFormulario();
                    cargarCategorias();
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
        addCategoryForm.reset();
        document.getElementById('categoria-id').value = '';
        document.getElementById('submitButton').textContent = "Guardar";
        document.getElementById('modalTitle').textContent = 'Agregar Nueva Categoria';
    }
});

function cargarCategorias() {
    fetch("/app/controller/categoriasController.php")
        .then(response => response.json())
        .then(data => {
            if (data.success && data.categorias.length > 0) {
                limpiarTabla();
                cargarTabla(data.categorias);
            } else {
                console.warn("No hay categorías disponibles.");
                cargarTabla([]);
            }
        })
        .catch(error => console.error('Error al cargar categorías:', error));
}

function cargarTabla(data) {
    let html = "";
    data.forEach(cat => {
        html += `
            <tr>
                <td class="border border-gray-300 px-4 py-2">${cat.id}</td>
                <td class="border border-gray-300 px-4 py-2">${cat.nombre}</td>
                <td class="border border-gray-300 px-4 py-2">${cat.descripcion}</td>
                <td class="border border-gray-300 px-4 py-2">${cat.estado}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="editarCategoria(${cat.id})">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </button>
                <button class="px-2 py-1 text-white rounded hover:bg-opacity-80" 
                    onclick="toggleCategoria(${cat.id}, '${cat.estado}')" style="background-color: ${cat.estado == "Inactivo" ? '#28a745' : '#dc3545'}">
                    <i class="fas fa-toggle-${cat.estado == "Activo" ? 'on' : 'off'} mr-2"></i>
                    ${cat.estado == "Activo" ? 'Inactivar' : 'Activar'}
                </button>
                </td>
            </tr>`;
    });

    // Actualizar la tabla con los datos
    const tablaCategorias = document.getElementById('tabla-categorias');
    tablaCategorias.innerHTML = html;
    inicializarDataTable();
}

function limpiarTabla() {
    let tabla = $('#tablaCategorias').DataTable();
    if ($.fn.DataTable.isDataTable('#tablaCategorias')) {
        tabla.clear().destroy(); // 💥 Destruir la instancia previa
    }
}

function inicializarDataTable() {
    // 💡 Volver a inicializar después de actualizar la tabla
    $('#tablaCategorias').DataTable({
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

function editarCategoria(id) {
    const modal = document.getElementById('modal');
    fetch(`/app/controller/categoriasController.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('categoria-id').value = data.categoria.id;
                document.getElementById('nombre').value = data.categoria.nombre;
                document.getElementById('descripcion').value = data.categoria.descripcion;
                document.getElementById('estado').value = data.categoria.estado;
                document.getElementById('submitButton').textContent = "Actualizar Categoría";
                document.getElementById('modalTitle').textContent = `Editar Categoría ID: ${data.categoria.id}`;
                modal.classList.remove('hidden');
            } else {
                alerta("error", "Error", 'Error al obtener datos de la categoría.');
            }
        })
        .catch(error => {
            alerta("error", "Error", 'Error al cargar los datos.');
        });
}

function toggleCategoria(id, estado) {
    const nuevoEstado = estado === "Activo" ? 2 : 1;

    const datos = new URLSearchParams();
    datos.append('id', id);
    datos.append('estado', nuevoEstado);

    fetch('/app/controller/categoriasController.php', {
        method: 'PUT',
        body: datos
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alerta("success", "Exito", data.message);
                cargarCategorias();
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