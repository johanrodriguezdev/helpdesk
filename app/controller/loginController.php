<?php
require __DIR__ . '/../../config/db.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    try {
        $pdo = conectarDB();
        $sql = "SELECT usuId, username, email, password FROM sys_usuarios WHERE email = :login OR username = :login2";
        $stmt = $pdo->prepare($sql);
        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "Error en el servidor"]);
        }

        // **IMPORTANTE: Asegurarse de que la clave coincida EXACTAMENTE**
        $stmt->execute([':login' => $login, ':login2' => $login]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos."]);
            exit;
        }

        $_SESSION['usuario_id'] = $usuario['usuId'];
        $_SESSION['usuario_nombre'] = $usuario['username'];
        $_SESSION['usuario_email'] = $usuario['email'];

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error en el servidor"]);
    }
}
?>