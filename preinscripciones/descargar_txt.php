<?php
$host = "mysql.webcindario.com";
$user = "13septiembre";
$pass = "Pa101327";
$db = "13septiembre";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$sql = "SELECT * FROM preinscripciones";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="preinscripciones.txt"');

    while ($fila = $resultado->fetch_assoc()) {
        echo "Alumno: " . $fila["apellido_paterno_alumno"] . " " . $fila["apellido_materno_alumno"] . " " . $fila["nombre_alumno"] . "\n";
        echo "CURP Alumno: " . $fila["curp_alumno"] . "\n";
        echo "Grado: " . $fila["grado"] . "\n";
        echo "Tutor: " . $fila["apellido_paterno_tutor"] . " " . $fila["apellido_materno_tutor"] . " " . $fila["nombre_tutor"] . "\n";
        echo "CURP Tutor: " . $fila["curp_tutor"] . "\n";
        echo "Email Tutor: " . $fila["email_tutor"] . "\n";
        echo "Teléfono Tutor: " . $fila["telefono_tutor"] . "\n";
        echo "-------------------------\n";
    }
} else {
    echo "No hay datos.";
}
$conn->close();
?>
