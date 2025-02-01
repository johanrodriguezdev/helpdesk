<?php
require __DIR__ . '/../../config/db.php';
include 'modal_categoria.php';
?>
<style>
    #modal {
        z-index: 9999;
    }
</style>

<?php include 'menu.php'; ?>

<center><h1 class="text-xl font-bold"><strong>Categorias</strong></h1></center><br>

<div class="mb-4">
    <button id="openModalButton" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
        <i class="fas fa-plus-circle mr-2"></i>Agregar Categoría
    </button>
</div>
<table class="w-full border-collapse border border-gray-300" id="tablaCategorias">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Nombre</th>
            <th class="border border-gray-300 px-4 py-2">Descripción</th>
            <th class="border border-gray-300 px-4 py-2">Estado</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-categorias">
        <!-- Las filas se llenarán dinámicamente -->
    </tbody>
</table>

<script src="/public/js/categorias.js"></script>