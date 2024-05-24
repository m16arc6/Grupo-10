<?php
session_start();
 
if (!isset($_SESSION['usuario_id']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['departamento'] !== "Admin") {
    header('Location: subir_archivo.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Panel Administrador</title>
<style>
      html,  body {
            margin: 0;
            background: linear-gradient(to right, #B1B1B1, #B1B1B1);
        }
        .container {
            position: relative;
        }
        .botones-izquierda {
            position: absolute;
            top: 0;
            left: 0;
            margin: 10px;
        }
        .botones-izquierda button {
            margin-right: 10px;
        }
        .sidebar {
        position: fixed;
        right: 0;
        bottom: 0;
        top: 0;
        width: 200px;
        background-color: #F0F0F0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            padding-top: 160%;
            height: 100%;
            position: relative;
            z-index: 9999;
        }
        .sidebar ul li {
            padding: 10px;
            text-align: center;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333; /* Color de los enlaces */
            display: block;
        }
        .sidebar ul li a:hover {
            text-decoration: none;
            color: #666; /* Cambio de color al pasar el mouse */
            display: block;
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
        .user-info {
            position: absolute;
            top: 10;
            right: 50px;
            margin: 10px;
            text-align: center;
        }
        .user-info img {
            height: 35px;
            width: 35px;
            border-radius: 50%;
        }
        .form-container {
            position: relative;
            text-align: center;
            margin-top: 20px; /* Ajusta según sea necesario */
        }
        .img-archivo {
            max-width: 100%;
            height: auto;
            align-items: center;
            padding-top: 10%;
            text-align: center;
        }
</style>
</head>
<body>
    <div class="container">
    <div class="sidebar">
        <ul class="sidebar-items">
        <li><a href="admin_panel.php">Inicio</a></li>
        <li><a href="ver_archivos_srv_admin.php">Descargar</a></li>
        <li><a href="ver-comprobacion_admin.php">Registros</a></li>
        <li><a href="anadir.php">Departamentos</a></li>
        </ul>
    </div>
    <div class="user-info">
        <img src="fotos/usuario.png" alt="Administrador">
        <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <a href="logout.php"><button>Logout</button></a>
    </div>
    <div class="img-archivo">
        <img src="fotos/foto_fichero.png" alt="foto fichero" height="300px" width="400px">
    </div>
    <div class="form-container">
    <form action="prueba2.php" method="post">
        <label for="archivo">Seleccionar archivo:</label>
        <input type="file" name="archivo" id="archivo">
        <input type="submit" value="Subir">
    </form>
    </div>
    <div class="form-container">
    <form action="bajar.php" method="post">
        <label for="directorio">Seleccionar directorio:</label>
        <input type="file" id="directorio" webkitdirectory directory multiple>
        <input type="submit" value="Subir">
    </form>
    </div>
    </div>
</body>
</html>