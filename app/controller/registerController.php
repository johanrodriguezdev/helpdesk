<?php
require __DIR__ . '/../../config/db.php';
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $response["message"] = "Todos los campos son obligatorios.";
    } else {
        try {
            $pdo = conectarDB();
            $sql = "SELECT COUNT(*) FROM sys_usuarios WHERE username = :username OR email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $username, ':email' => $email]);
            $existe = $stmt->fetchColumn();

            if ($existe > 0) {
                $response["message"] = "El usuario o correo ya están registrados.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO sys_usuarios (username, email, password, fechaCreate, estId) VALUES (:username, :email, :password, NOW(), 1)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashed_password
                ]);

                $response["success"] = true;
                $response["message"] = "Registro exitoso. Redirigiendo...";
            }
        } catch (PDOException $e) {
            $response["message"] = "Error en el registro: " . $e->getMessage();
        }
    }
}

echo json_encode($response);
exit;
