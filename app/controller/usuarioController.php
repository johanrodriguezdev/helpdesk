<?php
require __DIR__ . '/../../config/db.php';
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['usuario_id'])) {
        $response = [
            "success" => true,
            "usuario_id" => $_SESSION['usuario_id'],
            "usuario_nombre" => $_SESSION['usuario_nombre'],
            "usuario_email" => $_SESSION['usuario_email']
        ];
    } else {
        $response["message"] = "No hay sesión activa.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '1';
    $id = $_POST['usuario_id'] ?? null;

    if (empty($nombre) || empty($correo) || empty($password)) {
        $response["message"] = "Todos los campos son obligatorios.";
    } else {
        try {
            $pdo = conectarDB();
            if ($id) {
                $actualizado = actualizarUsuario($nombre, $correo, $password, $id, $pdo);
                if ($actualizado) {
                    $_SESSION['usuario_nombre'] = $nombre;
                    $_SESSION['usuario_email'] = $correo;
                    $response["success"] = true;
                    $response["message"] = "Usuario actualizado correctamente.";
                } else {
                    $response["message"] = "No se pudo actualizar el usuario.";
                }
            } else {
                $response["message"] = "Error en la operación: No se encontró el usuario en la BD.";
            }
        } catch (PDOException $e) {
            $response["message"] = "Error en la operación: " . $e->getMessage();
        }
    }
}

function actualizarUsuario($username, $email, $password, $id, $pdo) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE sys_usuarios SET username = :username, email = :email, password=:password, fechaUpdate=NOW() WHERE usuId= :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashed_password,
        ':id' => $id
    ]);

    return $stmt->rowCount() > 0;
}

echo json_encode($response);
?>