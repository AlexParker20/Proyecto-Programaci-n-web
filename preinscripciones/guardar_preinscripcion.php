<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $apellidoPaternoAlumno = $_POST["apellido-paterno-alumno"] ?? "";
    $apellidoMaternoAlumno = $_POST["apellido-materno-alumno"] ?? "";
    $nombreAlumno = $_POST["nombre-alumno"] ?? "";
    $curpAlumno = $_POST["curp-alumno"] ?? "";
    $apellidoPaternoTutor = $_POST["apellido-paterno-tutor"] ?? "";
    $apellidoMaternoTutor = $_POST["apellido-materno-tutor"] ?? "";
    $nombreTutor = $_POST["nombre-tutor"] ?? "";
    $curpTutor = $_POST["curp-tutor"] ?? "";
    $emailTutor = $_POST["email-tutor"] ?? "";
    $telefonoTutor = $_POST["telefono-tutor"] ?? "";
    $grado = $_POST["grado"] ?? "";

   

    // 2. GUARDAR EN BASE DE DATOS
    $servername = "mysql.webcindario.com";
    $username = "13septiembre";
    $password = "Pa101327";
    $database = "13septiembre";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "INSERT INTO preinscripciones (
        apellido_paterno_alumno, apellido_materno_alumno, nombre_alumno, curp_alumno, grado,
        apellido_paterno_tutor, apellido_materno_tutor, nombre_tutor, curp_tutor, email_tutor, telefono_tutor
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss",
        $apellidoPaternoAlumno, $apellidoMaternoAlumno, $nombreAlumno, $curpAlumno, $grado,
        $apellidoPaternoTutor, $apellidoMaternoTutor, $nombreTutor, $curpTutor, $emailTutor, $telefonoTutor
    );

    if ($stmt->execute()) {
        echo "Preinscripción guardada exitosamente en archivo y base de datos.";
    } else {
        echo "Error al guardar en la base de datos: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
