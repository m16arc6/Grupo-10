<?php
session_start();

$title = "Login";
$mensaje_error = "";

if (isset($_REQUEST['login'])) {
    $host = 'localhost';
    $dbname = 'usuarios';
    $username = 'jairo';
    $password = '1234';

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Conexión errónea: " . mysqli_connect_error());
    }

    $usu = mysqli_real_escape_string($conn, $_REQUEST['login']);
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
            $_SESSION['username'] = $usu; // Establecer el nombre de usuario en la sesión

            if ($_SESSION['departamento'] == 'Admin') {
                header('Location: admin_panel.php');
                exit;
            } else {
                header('Location: subir_archivo.php');
                exit;
            }
        } else {
            $mensaje_error = "Usuario/Contraseña incorrecta";
        }
    } else {
        $mensaje_error = "Usuario/Contraseña incorrecta";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #BCBCBC, #BCBCBC);
        }

        .login-form {
            background: white;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .input-group {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #0084ff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #0084ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Mi Cuenta</h2>
            <?php if (!empty($mensaje_error)) : ?>
                <p class="error-message"><?php echo $mensaje_error; ?></p>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="input-group">
                    <label for="login">Login</label>
                    <input type="text" id="login" name="login">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="pass" name="pass">
                </div>
                <div class="input-group">
                    <button type="submit">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
