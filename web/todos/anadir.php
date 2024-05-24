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
    <title>Subir Archivo</title>
    <style>
        .tabla {
            padding-top: 100px;
        }
        body {
            margin: 10;
            background-color: #B1B1B1;
        }
        .container {
            position: center;
        }
	.departamentos {
            padding-left: 700px;
            padding-top: 100px;
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

        .user-info {
            position: absolute;
            top: 10px;
            right: 55px;
            margin: 10px;
            text-align: center;
        }
        .user-info img {
            height: 35px;
            width: 35px;
        }
        .botones {
            position: absolute;
            top: 10px; /* Posiciona en el centro vertical */
            left: 10px; /* Posiciona en el centro horizontal */
            z-index: 9999;
        }
        .cerrar-sesion {
            position: absolute;
            top: 80px;
            left: 0px;
            z-index: 9999;
        }
        .sidebar {
            position: fixed;
            right: 0;
            bottom: 0;
            top: 0;
            width: 200px;
            background-color: #f0f0f0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            padding-top: 160%;
            height: 100%;
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
            color: #666; /* Cambio de color al pasar el mouse */
        }
        
    </style>
</head>
<body>
<div class="departamentos">
    <div class="sidebar">
    <ul class="sidebar-items">
      <li><a href="admin_panel.php">Inicio</a></li>
      <li><a href="ver_archivos_srv_admin.php">Descargar</a></li>
      <li><a href="ver_comprobacion_admin.php">Registros</a></li>
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
    <h2>Modificar Departamento</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="nuevo_departamento">Nuevo Departamento:</label>
        <select id="nuevo_departamento" name="nuevo_departamento" required>
		<option value="jefe">Jefe</option>
		<option value="trabajador">Trabajador</option>
		<option value="usuario">Usuario</option>
	    </select><br><br>

        <input type="submit" value="Actualizar Departamento">
    </form>
</div>
</body>
</html>
