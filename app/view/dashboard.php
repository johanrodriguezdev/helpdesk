<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: #1d1c1c;
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
        <h1 class="text-xl font-bold">SISTEMA DE MESA DE AYUDA HELPDESK MODULO</h1>
        <div>
            <button class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-500">Editar Perfil</button>
            <button class="bg-red-600 px-4 py-2 rounded hover:bg-red-500">Cerrar Sesión</button>
        </div>
    </header>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar text-white p-5 space-y-6 shadow-lg">
            <nav>
                <div>
                    <button onclick="toggleMenu()" class="block py-2 px-4 bg-gray-700 rounded w-full text-left hover:bg-gray-600">Helpdesk</button>
                    <div id="submenu" class="ml-4 mt-2 space-y-2 hidden">
                        <a href="#" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Categorías</a>
                        <a href="#" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Asignaciones</a>
                        <a href="#" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Crear Tickets</a>
                        <a href="#" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Mis Tickets</a>
                        <a href="#" class="block py-1 px-4 bg-gray-800 hover:bg-gray-700 rounded">Soporte</a>
                    </div>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
       <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold mb-6"></h2>
            <div class="black black-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 
                <div class="card p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold">Tickets Abiertos</h3>
                    <p class="text-3xl font-bold text-blue-700">34</p>
                </div>-->
                <!-- Card 2 
                <div class="card p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold">Tickets Cerrados</h3>
                    <p class="text-3xl font-bold text-green-700">120</p>
                </div>-->
                <!-- Card 3 
                <div class="card p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold">Usuarios Activos</h3>
                    <p class="text-3xl font-bold text-purple-700">15</p>
                </div>-->
            </div>
        </main> 
    </div>
</body>
</html>