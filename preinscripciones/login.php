<?php
session_start();

// Datos de conexión a tu servidor Mi@rroba
$host = "mysql.webcindario.com";
$usuarioBD = "13septiembre";
$contrasenaBD = "Pa101327";
$nombreBD = "13septiembre";

// Conectar a la base de datos
$conn = new mysqli($host, $usuarioBD, $contrasenaBD, $nombreBD);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['palabra_secreta'] ?? '';

// Buscar al usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Validar usuario y contraseña
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($clave, $row['password'])) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = $usuario;
        header("Location: pagina_inicio.php");
        exit();
    } else {
        // Contraseña incorrecta
        header("Location: login_error.html");
        exit();
    }
} else {
    // Usuario no encontrado
    header("Location: login_error.html");
    exit();
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>

