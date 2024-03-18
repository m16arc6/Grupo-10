<?php
//$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
$contar = count($_FILES["archivos"]);
for ($i = 0; $i < $contar; $i++){
	echo $_FILES["archivos"]["name"][$i] . "<br>";
	$ruta_destino = 'subidas/' . $_FILES['archivos']['name'][$i];
   	move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $ruta_destino);
}
echo "hola";
exec('python3 prueba2.py');
?>

