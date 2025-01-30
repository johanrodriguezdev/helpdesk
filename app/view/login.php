<?php
session_start();
require 'config/db.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['login']) || empty(trim($_POST['login']))) {
        die("Error: El campo 'login' está vacío.");
    }
    if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
        die("Error: El campo 'password' está vacío.");
    }

    $login = trim($_POST['login']);
    $password = $_POST['password'];

    try {
        $pdo = conectarDB();

        // Depuración: Mostrar el valor de login recibido
        echo "Valor de login recibido: " . htmlspecialchars($login) . "<br>";

        // Consulta preparada con marcador de posición
        $sql = "SELECT usuId, username, email, password FROM sys_usuarios WHERE email = :login OR username = :login";
        $stmt = $pdo->prepare($sql);

        // Depuración: Verificar si se preparó correctamente
        if (!$stmt) {
            die("Error: Fallo al preparar la consulta SQL.");
        }

        // **IMPORTANTE: Asegurarse de que la clave coincida EXACTAMENTE**
        $stmt->execute([':login' => $login]);

        // Obtener el resultado
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Depuración: Verificar si se encontró un usuario
        if (!$usuario) {
            die("Error: No se encontró un usuario con ese email o nombre de usuario.");
        }

        // Verificar si la contraseña es correcta
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['usuId'];
            $_SESSION['usuario_nombre'] = $usuario['username'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header("Location: view/dashboard.php");
            exit;
        } else {
            die("Error: Usuario o contraseña incorrectos.");
        }

    } catch (PDOException $e) {
        die("Error en la consulta SQL: " . $e->getMessage());
    }
}
?>
