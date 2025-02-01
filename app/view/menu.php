<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/public/js/usuario.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            min-width: 250px;
            background: #171717;
        }
        .topbar {
            background: #171717;
            color: white;
        }
        .card {
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
        }
        main {
            background:rgb(255, 255, 255);
        }

        #modalPerfil{
            z-index: 99;
        }

    </style>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('submenu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-200 text-gray-900">

    <!-- Top Bar -->
    <header class="topbar p-4 flex justify-between items-center shadow-md">
        <a href="dashboard.php"><h1 class="text-xl font-bold">SISTEMA DE MESA DE AYUDA HELPDESK</h1></a>
        <div>
            <button class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-500" id="openModalButtonPerfil">
                Editar Perfil
            </button>
            <button id="logoutButton" class="bg-red-600 px-4 py-2 rounded hover:bg-red-500">Cerrar Sesión</button>
        </div>
    </header>

<div id="modalPerfil" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4 text-center">Editar Perfil</h2>
        <form id="formEditarPerfil">
        <input type="hidden" id="usuario_id" name="usuario_id" value="" required>
            <div class="mb-4">
                <label class="block text-gray-700">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="w-full border border-gray-300 p-2 rounded" value="" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" class="w-full border border-gray-300 p-2 rounded" value="" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Contraseña:</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 p-2 rounded" required placeholder="Nueva contraseña">
            </div>

            <div class="flex justify-end">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar</button>
                <button type="button" id="closeModalButtonPerfil" class="px-4 py-2 ml-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</button>
            </div>
        </form>
    </div>
</div>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar text-white p-5 space-y-6 shadow-lg">
            <nav>
                <div>
                    <button onclick="toggleMenu()" class="block py-2 px-4 bg-gray-700 rounded w-full text-left hover:bg-gray-600">
                        Helpdesk
                    </button>
                    <div id="submenu" class="ml-4 mt-2 space-y-2 hidden">
                        <a href="categorias.php" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Categorías</a>
                        <a href="asignaciones.php" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Asignaciones</a>
                        <a href="tickets.php" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Crear Tickets</a>
                        <a href="misTickets.php" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Mis Tickets</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Contenedor donde se mostrará el contenido dinámico -->
        <main class="flex-1 p-6">
