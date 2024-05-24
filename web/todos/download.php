<?php
// Asumiendo que los archivos se almacenan en un directorio llamado 'uploads'
$directorioDeArchivos = 'uploads/';

// Obtén el nombre del archivo desde la URL usando $_GET
if (isset($_GET['archivo'])) {
    $nombreDeArchivo = $_GET['archivo'];

    // Asegúrate de que el nombre de archivo no contenga rutas relativas que puedan apuntar a directorios superiores
    $nombreDeArchivo = basename($nombreDeArchivo);

    // Construye la ruta completa del archivo
    $rutaDelArchivo = $directorioDeArchivos . $nombreDeArchivo;

    // Verifica que el archivo exista
    if (file_exists($rutaDelArchivo)) {
        // Define los encabezados para indicar al navegador cómo manejar el archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($rutaDelArchivo) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaDelArchivo));
        
        // Limpia el sistema de búferes de salida
        ob_clean();
        flush();
        
        // Lee el archivo y envíalo al navegador
        readfile($rutaDelArchivo);
        
        // Termina la ejecución del script
        exit;
    } else {
        echo "Error: El archivo no existe.";
    }
} else {
    echo "Error: Nombre de archivo no especificado.";
}
?>