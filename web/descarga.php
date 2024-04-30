<?php
// Asegúrate de que el script solo permite descargar archivos del directorio de documentos
$directorio = '/var/www/html/subidas/cuarentena';
$archivo = $directorio . '/' . basename($_GET['archivo']); // Usa 'basename' para proteger contra ataques de traversal de directorio.

// Aquí iría el código para iniciar la descarga, similar al ejemplo de la respuesta anterior.
if (file_exists($archivo)) {
    // Establece las cabeceras adecuadas
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream'); // Cambia el tipo MIME si conoces el tipo específico del archivo.
    header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));

    // Limpia el sistema de salida del buffer y deshabilita el límite de tiempo de ejecución
    ob_clean();
    flush();
    set_time_limit(0);

    // Lee el archivo y envía el contenido al navegador
    readfile($archivo);
    exit;
} else {
    // Mensaje para informar al usuario que el archivo no existe
    echo "Lo siento, el archivo no existe.";
}
?>
