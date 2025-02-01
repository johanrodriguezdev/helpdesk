<?php
require __DIR__ . '/../../config/db.php';
include 'modal_detalle_ticket.php';
?>
<style>
    #modalDetalles {
        z-index: 9999;
    }
</style>

<?php include 'menu.php'; ?>

<center><h1 class="text-xl font-bold"><strong>Mis Tickets</strong></h1></center><br>

<table class="w-full border-collapse border border-gray-300" id="tablaMisTickets">
    <thead>
        <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Fecha</th>
            <th class="border border-gray-300 px-4 py-2">Titulo</th>
            <th class="border border-gray-300 px-4 py-2">Categoria</th>
            <th class="border border-gray-300 px-4 py-2">Estado</th>
            <th class="border border-gray-300 px-4 py-2">Detalles</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody id="tabla-misTickets"></tbody>
</table>

<script src="/public/js/misTickets.js"></script>