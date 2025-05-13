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
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="preinscripciones.csv"');
    $salida = fopen('php://output', 'w');
    fputcsv($salida, array('Apellido Paterno Alumno', 'Apellido Materno Alumno', 'Nombre Alumno', 'CURP Alumno', 'Grado',
                            'Apellido Paterno Tutor', 'Apellido Materno Tutor', 'Nombre Tutor', 'CURP Tutor', 'Email Tutor', 'Teléfono Tutor'));
    while ($fila = $resultado->fetch_assoc()) {
        fputcsv($salida, $fila);
    }
    fclose($salida);
} else {
    echo "No hay datos.";
}
$conn->close();
?>
