<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
} 
$directorio = 'subidas/cuarentena'; // Cambia esto por la ruta real del directorio en tu servidor.
$archivos = scandir($directorio);

foreach ($archivos as $archivo) {
    // Omitir directorios '.' y '..'
    if ($archivo === '.' || $archivo === '..') {
        continue;
    }

    // Crear un enlace que apunte al script de descarga con el nombre del archivo como parámetro
    echo '<a href="descarga.php?archivo=' . urlencode($archivo) . '">' . $archivo . '</a><br>';
}
?>
