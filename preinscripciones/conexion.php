<?php
$host = "mysql.webcindario.com";     // O el que Mi@rroba te haya dado
$usuario = "13septiembre";  // Usuario de tu base de datos
$contrasena = "Pa101327";  // Contraseña
$bd = "13septiembre";

$conn = new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>