<?php
$servername = "localhost";
$database = "usuarios";
$username = "jairo";
$password = "1234";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connexión erronea: " . mysqli_connect_error());
}

echo "Connexión correcta<br>";

if (isset($_REQUEST['enviar'])) {
    $usu = $_REQUEST['nombre']; // Extraemos usuario
    $apell = $_REQUEST['apellido']; // Extraemos apellidos
    $pas = $_REQUEST['passwd']; //Extraemos contraseña sin encriptar
    $pash = hash('sha512', $pas); // hacemos un hash con la password con sha512

    $sql = "INSERT INTO usuarios (usuario, apellido, passwd) VALUES ('$usu', '$apell', '$pash')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<br>";
        echo "¡Alta registro correcto!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form action='registro.php' method='POST'>
            <p>
                <a href='logout.php'>Cerrar Sesión</a>
            </p>

            <h3>ALTA USUARIO:</h3>

            <p> <!-- Campo usuario -->
                <input type='text' name="nombre" placeholder='Nombre Usuario'>
            </p>
            <p> <!-- Campo apellido -->
                <input type='text' name="apellido" placeholder='Apellidos'>
            </p>
            <p> <!-- Campo contraseña -->
                <input type='password' name='passwd' placeholder='Contraseña'>
            </p>
            <p> <!-- Campo enviar -->
                <input type='submit' name='enviar' value='Enviar'>
            </p>
        </form>
    </body>
</html>
