<div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h3 class="text-2xl font-semibold mb-4" id="modalTitle">Agregar Nueva Asignación</h3>
        <form id="addAssignmentForm">
            <input type="hidden" id="asignacion-id" name="asignacion-id">
            <div class="mb-4">
                <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                <input type="int" id="cedula" name="cedula" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input type="email" id="correo" name="correo" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono</label>
                <input type="text" id="telefono" name="telefono" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mb-4">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="estado" name="estado" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                    <option value="">Seleccionar Opción</option>    
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                <button type="button" id="closeModalButton" class="px-4 py-2 ml-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</button>
            </div>
        </form>
    </div>
</div>
