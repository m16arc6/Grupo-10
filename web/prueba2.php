<?php
// Comprobar si se han subido archivos
if (!empty($_FILES['archivos']['name'][0])) {
    // Crear el directorio de destino si no existe
    $uploadDir = 'subidas/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
 
    // Contar la cantidad de archivos subidos
    $contar = count($_FILES['archivos']['name']);
    echo "Número de archivos subidos: " . $contar . "<br>";
 
    for ($i = 0; $i < $contar; $i++) {
        // Verificar si hubo un error en la subida del archivo
        if ($_FILES['archivos']['error'][$i] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['archivos']['name'][$i];
            echo "Archivo: " . $nombreArchivo . "<br>";
            // Ruta de destino
            $rutaDestino = $uploadDir . basename($nombreArchivo);
            // Mover el archivo subido a la ruta de destino
            if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $rutaDestino)) {
                echo "El archivo $nombreArchivo se ha subido correctamente.<br>";
            } else {
                echo "Error al mover el archivo $nombreArchivo.<br>";
            }
        } else {
            echo "Error al subir el archivo: " . $_FILES['archivos']['name'][$i] . "<br>";
        }
    }
    $usu = $_SESSION['username'];
	// Especificar el nombre del archivo y el contenido a escribir
	$nombreArchivo = "usuario.txt";
	$nombreArchivo_d = "departamento.txt";
	$contenido = $_SESSION['username'];
	$departamento = $_SESSION['departamento'];

	// Abrir el archivo en modo de escritura, 'w' crea el archivo si no existe
	$archivo_d = fopen($nombreArchivo_d, 'w');

	// Escribir el contenido en el archivo
	fwrite($archivo_d, $departamento);

	// Cerrar el archivo
	fclose($archivo_d);

	// Abrir el archivo en modo de escritura, 'w' crea el archivo si no existe  
	$archivo = fopen($nombreArchivo, 'w');

	// Escribir el contenido en el archivo
	fwrite($archivo, $contenido);

	// Cerrar el archivo
	fclose($archivo);
    // Ejecutar el script de Python
    exec('python3 prueba2.py');
} else {
    echo "No se han subido archivos.";
}
?>
