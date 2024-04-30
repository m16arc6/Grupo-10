<?php

// Datos de conexión a la base de datos
$hostname = "localhost";
$database = "usuarios";
$username = "jairo";
$password = "1234";

// Conexión a la base de datos
$conexion = new mysqli($hostname, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $nuevo_departamento = $_POST["nuevo_departamento"];

    // Consulta para actualizar el departamento para el usuario especificado
    $sql = "UPDATE usuarios SET departamento_empresa = '$nuevo_departamento' WHERE nombre = '$nombre'";

    if ($conexion->query($sql) === TRUE) {
        echo "Departamento actualizado exitosamente.";
	header('Location: admin_panel.html');
    } else {
        echo "Error al actualizar el departamento: " . $conexion->error;
    }
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Departamento</title>
</head>
<body>
    <h2>Modificar Departamento</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="nuevo_departamento">Nuevo Departamento:</label>
        <select id="nuevo_departamento" name="nuevo_departamento" required>
		<option value="jefe">Jefe</option>
		<option value="trabajador">Trabajador</option>
		<option value="usuario">Usuario</option>
	</select><br><br>

        <input type="submit" value="Actualizar Departamento">
    </form>
</body>
</html>
