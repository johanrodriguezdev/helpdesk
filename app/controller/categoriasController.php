<?php
require __DIR__ . '/../../config/db.php';
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        consultarCategoriaPorId($id);
    }else{
        $combo = (isset($_GET['combo'])) ? 1 : 0 ;
        consultarCategorias($combo);
    }
}

function consultarCategorias($combo){
    try {
        $pdo = conectarDB();
        $sql = "SELECT c.id,c.nombre,c.descripcion,es.nombre as estado, c.nombre as name FROM tm_categorias as c LEFT JOIN sys_estado as es ON c.estId=es.id";
        ($combo === 1) && $sql .= " WHERE es.id=1 ";
        $stmt = $pdo->query($sql);
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "categorias" => $categorias]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error al obtener categorías: " . $e->getMessage()]);
        exit;
    }
}

function consultarCategoriaPorId($id){
    $pdo = conectarDB();
    $sql = "SELECT id, nombre, descripcion, estId AS estado FROM tm_categorias WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($categoria) {
        $response["success"] = true;
        $response["categoria"] = $categoria;
    } else {
        $response["message"] = "Categoría no encontrada.";
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $estado = $_POST['estado'] ?? '1';
    $id = $_POST['categoria-id'] ?? null;

    if (empty($nombre) || empty($estado)) {
        $response["message"] = "Todos los campos son obligatorios.";
    } else {
        try {
            $pdo = conectarDB();
            if ($id) {
                actualizarCategoria($nombre,$descripcion,$estado,$id,$pdo);
            } else {
                agregarCategoria($nombre,$descripcion,$estado,$pdo);
            }
        } catch (PDOException $e) {
            $response["message"] = "Error en la operación: " . $e->getMessage();
        }
    }
}

function actualizarCategoria($nombre,$descripcion,$estado,$id,$pdo){
    $sql = "UPDATE tm_categorias SET nombre = :nombre, descripcion = :descripcion, estId =:estado, fechaUpdate=NOW() WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':estado' => $estado,
        ':id' => $id
    ]);
    $response["success"] = true;
    $response["message"] = "Categoría actualizada correctamente.";
    echo json_encode($response);
    exit;
}

function agregarCategoria($nombre,$descripcion,$estado,$pdo){
    $sql = "INSERT INTO tm_categorias (nombre, descripcion, estId,fechaCreate) VALUES (:nombre, :descripcion,:estado,NOW() )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':estado' => $estado
    ]);

    $response["success"] = true;
    $response["message"] = "Categoría agregada correctamente.";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_PUT['id'] ?? null;
    $estado = $_PUT['estado'] ?? null;

    if ($id && $estado !== null) {
        cambiarEstadoCategoria($id, $estado);
    } else {
        $response["message"] = "Faltan parámetros necesarios.";
    }
}

function cambiarEstadoCategoria($id, $estado) {
    global $response;
    try {
        $pdo = conectarDB();
        $sql = "UPDATE tm_categorias SET estId = :estado, fechaUpdate = NOW() WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => (int)$estado,
            ':id' => $id
        ]);
        $response["success"] = true;
        $response["message"] = "Estado de la categoría actualizado correctamente.";
    } catch (PDOException $e) {
        $response["message"] = "Error al actualizar el estado: " . $e->getMessage();
    }
    echo json_encode($response);
    exit;
}
