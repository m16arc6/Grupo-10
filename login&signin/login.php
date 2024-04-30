<?php
session_start();
?>

<?php

$title="Login";

if (isset($_REQUEST['login'])) {
    $host = 'localhost';
    $dbname = 'usuarios';
    $username = 'jairo';
    $password = '1234';

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Conexión errónea: " . mysqli_connect_error());
    }

    $usu = mysqli_real_escape_string($conn, $_REQUEST['user']);
    $pas = mysqli_real_escape_string($conn, $_REQUEST['pass']);

    $sql = "SELECT * FROM usuarios.usuarios WHERE LOWER(nombre) = LOWER('$usu')";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $storedHash = $row['passwd'];
        $inputHash = hash('sha512', $pas);

        // Verificar contraseña utilizando password_verify
        if ($inputHash === $storedHash) {
            // Si las credenciales son correctas, establecer variables de sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['autenticado'] = true;
	    $_SESSION['departamento'] = $row['departamento_empresa'];

            if ($_SESSION['departamento'] == 'Admin') {
		header('Location: admin_panel.html');
		exit;
	    } else {
		header('Location: subir_archivo.php');
		exit;
	    }
        } else {
            echo "Contraseña incorrecta";
            echo "<br>";
            echo "Input Hash: " . $inputHash . "<br>";
            echo "Hashed Password from Input: " . $inputHash . "<br>";
            echo "Stored Hash: " . $storedHash . "<br>";
            echo "<a href='login.php'>Volver</a>";
        }
    } else {
        echo "Usuario no encontrado";
        echo "<br>";
        echo "<a href='login.php'>Volver</a>";
    }

    mysqli_close($conn);
} else {
?>
<html>
<head>
<title><?php echo $title; ?></title>
</head>
    <div class="d-flex justify-content-center h-25 py-5">
        <div>
            <form action="login.php" method="post">
                <span class="textstyle">Usuario: </span> <input type="text" name="user" required><br>
                <span class="textstyle">Contraseña: </span> <input type="password" name="pass" required><br>
                <button type="submit" value="Login" name="login" class="btn btn-danger">Enviar</button>
            </form>
        </div>
    </div>
</html>
<?php
}
?>

