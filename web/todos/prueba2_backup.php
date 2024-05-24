<?php
//$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
$contar = count($_FILES);
for ($i = 0; $i < $contar; $i++){
	echo $_FILES["archivos"]["name"][$i] . "<br>";
	$ruta_destino = 'subidas/' . $_FILES['archivos']['name'][$i];
   	move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $ruta_destino);
}
$nombreArchivo = "usuario.txt";
$contenido = $_SESSION['username'];
$nombreArchivo_d = "departamento.txt";
$departamento = $_SESSION['departamento'];
echo $contenido;
echo $departamento;
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

exec("python3 prueba2.py");
?>
