<?php
require __DIR__ . '/../../config/db.php';
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        consultarAsignacionPorId($id);
    }else{
        $combo = (isset($_GET['combo'])) ? 1 : 0 ;
        consultarAsignaciones($combo);
    }
}

function consultarAsignaciones($combo){
    try {
        $pdo = conectarDB();
        $sql = "SELECT t.id,t.nombre,t.cedula,t.correo,t.telefono,es.nombre as estado, t.nombre as name FROM tm_trabajadores as t LEFT JOIN sys_estado as es ON t.estId=es.id";
        ($combo === 1) && $sql .= " WHERE es.id=1 ";
        $stmt = $pdo->query($sql);
        $asignaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "asignaciones" => $asignaciones]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error al obtener asignacións: " . $e->getMessage()]);
        exit;
    }
}

function consultarAsignacionPorId($id){
    $pdo = conectarDB();
    $sql = "SELECT id,cedula,nombre,correo,telefono,estId AS estado FROM tm_trabajadores WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $asignacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($asignacion) {
        $response["success"] = true;
        $response["asignacion"] = $asignacion;
    } else {
        $response["message"] = "Asignación no encontrada.";
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $cedula = trim($_POST['cedula'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $estado = $_POST['estado'] ?? '1';
    $id = $_POST['asignacion-id'] ?? null;

    if (empty($nombre) || empty($cedula) || empty($correo) || empty($telefono) || empty($estado)) {
        $response["message"] = "Todos los campos son obligatorios.";
    } else {
        try {
            $pdo = conectarDB();
            if ($id) {
                actualizarAsignacion($nombre,$cedula,$correo,$telefono,$estado,$id,$pdo);
            } else {
                agregarAsignacion($nombre,$cedula,$correo,$telefono,$estado,$pdo);
            }
        } catch (PDOException $e) {
            $response["message"] = "Error en la operación: " . $e->getMessage();
        }
    }
}

function actualizarAsignacion($nombre,$cedula,$correo,$telefono,$estado,$id,$pdo){
    $sql = "UPDATE tm_trabajadores SET nombre = :nombre, cedula = :cedula, correo = :correo, telefono = :telefono, estId =:estado, fechaUpdate=NOW() WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cedula' => $cedula,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':estado' => $estado,
        ':id' => $id
    ]);
    $response["success"] = true;
    $response["message"] = "Asignación actualizada correctamente.";
    echo json_encode($response);
    exit;
}

function agregarAsignacion($nombre,$cedula,$correo,$telefono,$estado,$pdo){
    $sql = "INSERT INTO tm_trabajadores (nombre, cedula,correo,telefono, estId,fechaCreate) VALUES (:nombre, :cedula, :correo, :telefono,:estado,NOW() )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cedula' => $cedula,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':estado' => $estado
    ]);

    $response["success"] = true;
    $response["message"] = "Asignación agregada correctamente.";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_PUT['id'] ?? null;
    $estado = $_PUT['estado'] ?? null;

    if ($id && $estado !== null) {
        cambiarEstadoAsignacion($id, $estado);
    } else {
        $response["message"] = "Faltan parámetros necesarios.";
    }
}

function cambiarEstadoAsignacion($id, $estado) {
    global $response;
    try {
        $pdo = conectarDB();
        $sql = "UPDATE tm_trabajadores SET estId = :estado, fechaUpdate = NOW() WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => (int)$estado,
            ':id' => $id
        ]);
        $response["success"] = true;
        $response["message"] = "Estado de la asignación actualizado correctamente.";
    } catch (PDOException $e) {
        $response["message"] = "Error al actualizar el estado: " . $e->getMessage();
    }
    echo json_encode($response);
    exit;
}
