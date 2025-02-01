<div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-2/3 max-w-4xl">
        <h3 class="text-2xl font-semibold mb-4" id="modalTitle">Agregar Nuevo Ticket</h3>
        <form id="addTicketForm">
            <input type="hidden" id="ticket-id" name="ticket-id">
            <!-- Contenedor Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="text" id="fecha" name="fecha" readonly class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="categoriaTicket" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select id="categoriaTicket" name="categoriaTicket" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required></select>
                </div>
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="titulo" name="titulo" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label for="usuAsignacion" class="block text-sm font-medium text-gray-700">Usuario Asignación</label>
                    <select id="usuAsignacion" name="usuAsignacion" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required></select>
                </div>
                <div>
                    <label for="prioridad" class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select id="prioridad" name="prioridad" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                        <option value="">Seleccionar Opción</option>    
                        <option value="0">Baja</option>
                        <option value="1">Medio</option>
                        <option value="2">Alto</option>
                    </select>
                </div>
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></textarea>
                </div>
                <div>
                    <label for="comentario" class="block text-sm font-medium text-gray-700">Comentarios</label>
                    <textarea id="comentario" name="comentario" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></textarea>
                </div>
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="estado" name="estado" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                        <option value="">Seleccionar Opción</option>    
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
            </div>

            <!-- Botones alineados a la derecha -->
            <div class="flex justify-end mt-4">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                <button type="button" id="closeModalButton" class="px-4 py-2 ml-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</button>
            </div>
        </form>
    </div>
</div>
