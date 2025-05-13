<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: formsesion.html");
    exit();
}

// Conexión a la base de datos
$host = "mysql.webcindario.com";
$usuario = "13septiembre";
$contrasena = "Pa101327";
$base_datos = "13septiembre";
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Buscar alumno si se ingresó búsqueda
$busqueda = $_GET['buscar'] ?? '';
$sql = "SELECT * FROM preinscripciones WHERE 
    CONCAT(nombre_alumno, ' ', apellido_paterno_alumno, ' ', apellido_materno_alumno, ' ', curp_alumno) LIKE ?";
$param = "%" . $busqueda . "%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Preinscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 6px;
        }
        button, .descargar {
            padding: 8px 12px;
            margin: 5px;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>

    <form method="get">
        <input type="text" name="buscar" placeholder="Buscar por nombre o CURP" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
        <a class="descargar" href="descargar_csv.php" target="_blank">Descargar CSV</a>
        <a class="descargar" href="descargar_txt.php" target="_blank">Descargar TXT</a>
        <a class="descargar" href="logout.php">Cerrar sesión</a>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Nombre del Alumno</th>
                <th>CURP</th>
                <th>Grado</th>
                <th>Nombre del Tutor</th>
                <th>CURP Tutor</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo "{$row['apellido_paterno_alumno']} {$row['apellido_materno_alumno']} {$row['nombre_alumno']}"; ?></td>
                    <td><?php echo $row['curp_alumno']; ?></td>
                    <td><?php echo $row['grado']; ?></td>
                    <td><?php echo "{$row['apellido_paterno_tutor']} {$row['apellido_materno_tutor']} {$row['nombre_tutor']}"; ?></td>
                    <td><?php echo $row['curp_tutor']; ?></td>
                    <td><?php echo $row['email_tutor']; ?></td>
                    <td><?php echo $row['telefono_tutor']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>

<?php $conn->close(); ?>
</body>
</html>
