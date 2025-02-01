<!-- Modal de Detalles -->
<div id="modalDetalles" class="fixed inset-0 bg-gray-800 bg-opacity-60 flex justify-center items-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-4/5 max-w-5xl transform transition-all duration-300 scale-95 hover:scale-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Detalles del Ticket</h2>
            <button onclick="cerrarModalDetalles()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>
        
        <div class="grid grid-cols-2 gap-6 text-gray-700">
                <p><strong>Fecha:</strong> <span id="detalle-fecha" class="text-gray-800"></span></p>
                <p><strong>Título:</strong> <span id="detalle-titulo" class="text-gray-800 font-medium"></span></p>
                <p><strong>Descripción:</strong> <span id="detalle-descripcion" class="text-gray-800"></span></p>
                <p><strong>Comentario:</strong> <span id="detalle-comentario" class="text-gray-800"></span></p>
                <p><strong>Categoría:</strong> <span id="detalle-categoria" class="text-gray-800"></span></p>
                <p><strong>Prioridad:</strong> <span id="detalle-prioridad" class="text-gray-800"></span></p>
                <p><strong>Asignado a:</strong> <span id="detalle-asignado" class="text-gray-800"></span></p>
                <p><strong>Cédula Asignado a:</strong> <span id="detalle-cedAsignado" class="text-gray-800"></span></p>
                <p><strong>Usuario Creación:</strong> <span id="detalle-usuCreacion" class="text-gray-800"></span></p>
                <p><strong>Estado:</strong> <span id="detalle-estado" class="text-gray-800"></span></p>
        </div>
        
        <div class="mt-6 text-right">
            <button class="px-6 py-2 bg-red-600 text-white rounded-full shadow-lg hover:bg-red-700 transition-colors"
                    onclick="cerrarModalDetalles()">Cerrar</button>
        </div>
    </div>
</div>
