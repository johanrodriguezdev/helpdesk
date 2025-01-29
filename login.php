<?php
session_start();

// Simulación de credenciales (reemplázalas con una base de datos en producción)
$users = [
    'admin' => 'password123',
    'user' => '1234'
];

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['user'] = $username;
        header('Location: dashboard.php'); // Redirige a un dashboard
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Iniciar sesión</h2>
        <?php if ($error): ?>
            <p class="text-red-500 text-sm text-center mt-2"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST" class="mt-4">
            <div>
                <label class="block text-sm">Usuario</label>
                <input type="text" name="username" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div class="mt-4">
                <label class="block text-sm">Contraseña</label>
                <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <button type="submit" class="w-full px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-600">Entrar</button>
        </form>
        <p class="text-sm text-center mt-4">¿Aun no tienes cuenta? <a href="registro.php" class="text-blue-500 hover:underline">Registrate aquí</a></p>
    </div>
</body>
</html>
