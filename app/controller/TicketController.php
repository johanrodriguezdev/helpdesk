<?php
require __DIR__ . '/../../config/db.php';
session_start();
header('Content-Type: application/json');

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        consultarTicketPorId($id);
    }else{
        $estado = isset($_GET['estId']) ? 1 : 0;
        consultarTickets($estado);
    }
}

function consultarTickets($estado){
    try {
        $pdo = conectarDB();
        $sql = "SELECT t.idTick as id,t.tickTitulo as titulo,t.tickComentario as comentario,DATE_FORMAT(t.fechaCreacion,'%d-%m-%Y') as fecha,t.tickDescripcion as descripcion,
        es.nombre as estado, es.id as idestado, c.nombre as nomCategoria, c.id as idCategoria,
        tr.nombre as nomTrabajador, tr.cedula as cedTrabajador , tr.id as idTrabajador,t.tickPrioridad as prioridad,
        t.tickEstado,us.username as nomUsu, us.usuId as idUsu
        FROM tickets as t 
        LEFT JOIN tm_categorias as c ON t.categoriaId=c.id
        LEFT JOIN tm_trabajadores as tr ON t.usuAsignadoId=tr.id
        LEFT JOIN sys_usuarios as us ON us.usuId=t.usuId
        LEFT JOIN sys_estado as es ON t.estId=es.id";
        ($estado === 1) ? $sql.=" WHERE es.id = 1" : '';
        $stmt = $pdo->query($sql);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "tickets" => $tickets]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error al obtener tickets: " . $e->getMessage()]);
        exit;
    }
}

function consultarTicketPorId($id){
    $pdo = conectarDB();
    $sql = "SELECT t.idTick as id,t.tickTitulo as titulo,t.tickComentario as comentario,DATE_FORMAT(t.fechaCreacion,'%d-%m-%Y') as fecha,t.tickDescripcion as descripcion,
        es.nombre as estado, es.id as idestado, c.nombre as nomCategoria, c.id as idCategoria,us.username as nomUsu, us.usuId as idUsu,
        tr.nombre as nomTrabajador, tr.cedula as cedTrabajador , tr.id as idTrabajador,t.tickPrioridad as prioridad 
        FROM tickets as t 
        LEFT JOIN tm_categorias as c ON t.categoriaId=c.id
        LEFT JOIN tm_trabajadores as tr ON t.usuAsignadoId=tr.id
        LEFT JOIN sys_usuarios as us ON us.usuId=t.usuId
        LEFT JOIN sys_estado as es ON c.estId=es.id
        WHERE idTick = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ticket) {
        $response["success"] = true;
        $response["ticket"] = $ticket;
    } else {
        $response["message"] = "Ticket no encontrada.";
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = trim($_POST['fecha'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $comentario = trim($_POST['comentario'] ?? '');
    $categoriaTicket = trim($_POST['categoriaTicket'] ?? '');
    $usuAsignacion = trim($_POST['usuAsignacion'] ?? '');
    $prioridad = trim($_POST['prioridad'] ?? '');
    $estado = $_POST['estado'] ?? '1';
    $id = $_POST['ticket-id'] ?? null;
    
    if (empty($fecha) || empty($titulo) || empty($categoriaTicket) || empty($usuAsignacion) || $prioridad =="") {
        $response["message"] = "Todos los campos son obligatorios.";
    } else {
        try {
            $pdo = conectarDB();
            if ($id) {
                actualizarTicket($titulo,$descripcion,$comentario,$categoriaTicket,$usuAsignacion,$prioridad,$estado,$id,$pdo);
            } else {
                agregarTicket($titulo,$descripcion,$comentario,$categoriaTicket,$usuAsignacion,$prioridad,$estado,$pdo);
            }
        } catch (PDOException $e) {
            $response["message"] = "Error en la operación: " . $e->getMessage();
        }
    }
    echo json_encode($response);
    exit;
}

function actualizarTicket($titulo,$descripcion,$comentario,$categoriaTicket,$usuAsignacion,$prioridad,$estado,$id,$pdo){
    $sql = "UPDATE tickets SET tickTitulo = :titulo, tickDescripcion = :descripcion,tickComentario = :comentario, 
    usuAsignadoId = :usuAsignacion,tickPrioridad = :prioridad, categoriaId=:categoriaTicket, estId =:estado, fechaUpdate=NOW() WHERE idTick = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':descripcion' => $descripcion,
        ':titulo' => $titulo,
        ':comentario' => $comentario,
        ':categoriaTicket' => $categoriaTicket,
        ':usuAsignacion' => $usuAsignacion,
        ':prioridad' => $prioridad,
        ':estado' => $estado,
        ':id' => $id
    ]);
    $response["success"] = true;
    $response["message"] = "Ticket actualizada correctamente.";
    echo json_encode($response);
    exit;
}

function agregarTicket($titulo,$descripcion,$comentario,$categoriaTicket,$usuAsignacion,$prioridad,$estado,$pdo){
    $sql = "INSERT INTO tickets (categoriaId,tickTitulo,tickDescripcion,tickEstado,usuAsignadoId,tickPrioridad,tickComentario,usuId,estId,fechaCreacion) 
    VALUES (:categoriaTicket,:titulo,:descripcion,0,:usuAsignacion,:prioridad,:comentario,:usuId,:estado,NOW() )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':descripcion' => $descripcion,
        ':titulo' => $titulo,
        ':comentario' => $comentario,
        ':categoriaTicket' => $categoriaTicket,
        ':usuAsignacion' => $usuAsignacion,
        ':prioridad' => $prioridad,
        ':estado' => $estado,
        ':usuId'=> $_SESSION['usuario_id']
    ]);

    $response["success"] = true;
    $response["message"] = "Ticket agregado correctamente.";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_PUT['id'] ?? null;
    $estado = $_PUT['estado'] ?? null;
    $accion = $_PUT['accion'] ?? null;

    if ($id && $estado !== null) {
        cambiarEstadoTicket($id, $estado);
    }else if ($id && $accion !== null) {
        gestionarTicket($id,$accion);
    } else {
        $response["message"] = "Faltan parámetros necesarios.";
        $response["id"] = $id;
        $response["estado"] = $estado;
        $response["accion"] = $accion;
        echo json_encode($response);
        exit;
    }
}

function cambiarEstadoTicket($id, $estado) {
    global $response;
    try {
        $pdo = conectarDB();
        $sql = "UPDATE tickets SET estId = :estado, fechaUpdate = NOW() WHERE idTick = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => (int)$estado,
            ':id' => $id
        ]);
        $response["success"] = true;
        $response["message"] = "Estado del ticket actualizado correctamente.";
    } catch (PDOException $e) {
        $response["message"] = "Error al actualizar el estado: " . $e->getMessage();
    }
    echo json_encode($response);
    exit;
}

function gestionarTicket($id, $estado) {
    global $response;
    try {
        $pdo = conectarDB();
        $sql = "UPDATE tickets SET tickEstado = :estado, fechaUpdate = NOW() WHERE idTick = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => (int)$estado,
            ':id' => $id
        ]);
        $response["success"] = true;
        $response["message"] = "Estado del ticket actualizado correctamente.";
    } catch (PDOException $e) {
        $response["message"] = "Error al actualizar el estado: " . $e->getMessage();
    }
    echo json_encode($response);
    exit;
}
