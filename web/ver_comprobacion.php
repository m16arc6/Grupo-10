<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}
// Conexión a la base de datos
$conexion = new mysqli("localhost", "jairo", "1234", "virustotal");

// Comprueba si la conexión fue exitosa
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
$usu = $_SESSION['username'];
echo $usu;

// Consulta SQL para obtener todos los datos de la tabla comprobacionn
$sql = "SELECT * from comprobacionn WHERE nombre_usu='$usu'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Imprime los datos de cada fila
    while($fila = $resultado->fetch_assoc()) {
        echo " - Nombre: " . $fila["nombre"]. " - Resultado: " . $fila["resultado"]. "<br>";
    }
} else {
    echo "0 resultados";
}

// Cierra la conexión
$conexion->close();
?>
