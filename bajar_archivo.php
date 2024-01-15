<?php
    $ruta_destino = '/home/jairo/comprobacion/' . $_FILES['archivo']['name'];
    move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_destino);
?>