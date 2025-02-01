<?php
require __DIR__ . '/../../config/db.php';
include 'modal_asignaciones.php';
?>
<style>
    #modal {
        z-index: 9999;
    }
</style>

<?php include 'menu.php'; ?>

<center><h1 class="text-xl font-bold"><strong>Asignaciones</strong></h1></center><br>

<div class="mb-4">
    <button id="openModalButton" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
        <i class="fas fa-plus-circle mr-2"></i>Agregar Asignación
    </button>
</div>
<table class="w-full border-collapse border border-gray-300" id="tablaAsignaciones">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Cédula</th>
            <th class="border border-gray-300 px-4 py-2">Nombre</th>
            <th class="border border-gray-300 px-4 py-2">Correo</th>
            <th class="border border-gray-300 px-4 py-2">Telefono</th>
            <th class="border border-gray-300 px-4 py-2">Estado</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-asignaciones"></tbody>
</table>

<script src="/public/js/asignaciones.js"></script>