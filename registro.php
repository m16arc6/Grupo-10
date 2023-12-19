<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
<?php
if ((isset($_SESSION['estado'])) || ($_SESSION['estado'] == 1)) {
    $servername = "localhost"; // añado el nombre del servidor 
    $database = "usuarios";
    $username = "jairo";
    $password = "1234";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) { //sirve para avisar si hay error
        die("Connexión erronea: " . mysqli_connect_error()); // con el die se cerraría la conexión
        $_SESSION['estado'] = 0;
    }

    echo "Connexión correcta ".$_SESSION['nom']."<br>"; // si funciona imprimirá lo que diga el echo

    if(isset($_REQUEST['enviar']))
        {
            $usu = $_REQUEST['nombre']; // Extraemos usuario
            $apell = $_REQUEST['apellido']; // Extraemos apellidos
            $mail = $_REQUEST['correo']; //Extraemos correo
            $pas = $_REQUEST['passwd']; //Extraemos contraseña sin encriptar
            $pash = hash('sha512', $pas); // hacemos un hash con la password con sha512
            #$pash = password_hash($pas, PASSWORD_BCRYPT); //Añadimos el hash para hashear el input del usuario usando el algoritmo CRYPT_BLOWFISH para que encripte la contraseña
            var_dump($pash);

            $sql = "INSERT INTO usuarios (usuario, apellido, correo, passwd) VALUES ('$usu', '$apell, '$mail', '$pash')"; // guardamos el hash dentro de la base de datos
            
            if (mysqli_query($conn, $sql)){
                echo "<br>";
                echo "¡Alta registro correcto!";
            }
            else
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    else
        //echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    // $sql = "INSERT INTO usuarios (Id, Usu, Pas) VALUES (2, 'martin', '54321')"; // se prepara una QUERY. Genero una variable string donde se guarda como hacer la inserción en mysql.
    // si el campo fuera id se quitan las comillas, si no (varchar) se ponen las comillas simples // aquí se prepara una string / variable de lo que quiero hacer.
    // if (mysqli_query($conn, $sql)) // ejecuto la query
        //echo "Alta registro"; // da verdadero
    // else
        //echo "Error: " . $sql . "<br>" . mysqli_error($conn); // da falso (error) // el mysqli_error($conn) me mostraría el nombre del error separado por el br de antes

    mysqli_close($conn); // se cierra la conexión
?>
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
            <p> <!-- Campo correo -->
                <input type='mail' name="correo" placeholder='Correo'>
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