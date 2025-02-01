<?php
require __DIR__ . '/../../config/db.php';
include 'modal_tickets.php';
include 'modal_detalle_ticket.php';
?>
<style>
    #modal {
        z-index: 9999;
    }

    #modalDetalles {
        z-index: 9999;
    }
</style>

<?php include 'menu.php'; ?>

<center><h1 class="text-xl font-bold"><strong>Tickets</strong></h1></center><br>

<div class="mb-4">
    <button id="openModalButton" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
        <i class="fas fa-plus-circle mr-2"></i>Agregar Ticket
    </button>
</div>
<table class="w-full border-collapse border border-gray-300" id="tablaTickets">
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
    <tbody id="tabla-tickets"></tbody>
</table>

<script src="/public/js/tickets.js"></script>