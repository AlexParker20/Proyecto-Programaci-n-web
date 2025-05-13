<?php
// Datos de conexión (ajusta con los de tu servidor Mi@rroba)
$host = "mysql.webcindario.com";     // O el que Mi@rroba te haya dado
$usuario = "13septiembre";  // Usuario de tu base de datos
$contrasena = "Pa101327";  // Contraseña
$bd = "13septiembre";

// 1. Conectar sin seleccionar base de datos (para crearla)
$conn = new mysqli($host, $usuario, $contrasena,$bd);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Crear base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $bd";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos creada o ya existe.<br>";
} else {
    die("Error al crear base de datos: " . $conn->error);
}

$conn->select_db($bd); // Usar base de datos

// 3. Crear tabla usuarios
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada o ya existe.<br>";
} else {
    die("Error al crear la tabla: " . $conn->error);
}

// 4. Insertar usuario de ejemplo (admin / 123456)
$username = 'admin';
$password = password_hash('123456', PASSWORD_DEFAULT);
$username = 'vianey';
$password = password_hash('123456', PASSWORD_DEFAULT);

// Verificar si ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // Insertar usuario si no existe
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        echo "Usuario 'admin' creado con éxito.<br>";
    } else {
        echo "Error al insertar usuario: " . $stmt->error;
    }
} else {
    echo "El usuario 'admin' ya existe.<br>";
}

$conn->close();
?>
