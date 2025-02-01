<?php
function conectarDB() {
    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'helpdesk';
    $username = 'root';
    $password = 'admin';
    $charset = 'utf8mb4';

    // Configurar opciones de PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo de errores con excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Obtener resultados como array asociativo
        PDO::ATTR_EMULATE_PREPARES   => false, // Desactivar emulación de consultas preparadas
    ];

    try {
        // Crear y retornar la conexión con PDO
        return new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password, $options);
    } catch (PDOException $e) {
        // Manejo de errores (puedes personalizar este mensaje)
        die("Error en la conexión a la base de datos: " . $e->getMessage());
    }
}
