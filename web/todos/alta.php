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
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            .signin-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: linear-gradient(to right, #BCBCBC, #BCBCBC);
            }
            .form-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            form {
                background: white;
                padding: 20px;
                width: 300px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                text-align: center;
            }
            .signin {

            }
            h3 {
                color: #333;
            }
            input[type='text'], input[type='password'] {
                width: 90%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            input[type='submit'] {
                background-color: #0084ff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            input[type='submit']:hover {
                background-color: #0056b3;
            }
            a {
                color: #0084ff;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
    </style>
    </head>
    <body>
    <div class="signin-container">
        <form action='alta.php' method='POST' class="Signin">
            <h3>Registrate</h3>

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
            <p>
                <a href='login.php'>Login</a>
            </p>
        </form>
    </div>
    </body>
</html>
