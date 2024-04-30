<?php
if (isset($_REQUEST['enviar'])) {
    $servername = "localhost";
    $database = "usuarios";
    $username = "jairo";
    $password = "1234";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Conexión errónea: " . mysqli_connect_error());
    }

    echo "Conexión correcta<br>";

    $usu = $_POST['nombre']; // Extraemos usuario
    $apell = $_POST['apellido']; // Extraemos apellidos
    $pas = $_POST['passwd']; // Extraemos contraseña sin encriptar
    $pash = hash('sha512', $pas); // Hacemos un hash con la contraseña con sha512

    $sql = "INSERT INTO usuarios (nombre, apellido, passwd) VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $usu, $apell, $pash);
        if (mysqli_stmt_execute($stmt)) {
            echo "<br>";
            echo "¡Alta registro correcto!";
	    header('Location: index.html');
        } else {
            echo "Error en la ejecución de la consulta: " . mysqli_stmt_error($stmt);
            // Si estás utilizando este script solo para depuración, puedes mostrar más detalles:
            echo "Error de la consulta: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form action='signin.php' method='POST'>
            <p>
                <a href='logout.php'>Cerrar Sesión</a>
            </p>

            <h3>ALTA USUARIO:</h3>

            <p> <!-- Campo usuario -->
                <input type='text' name="nombre" placeholder='Nombre Usuario'>
            </p>
            <p> <!-- Campo apellido -->
                <input type='text' name="apellido" placeholder='Apellido'>
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
