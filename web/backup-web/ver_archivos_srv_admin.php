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
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de Archivos</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }
    .container {
        text-align: center;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .file-list {
        list-style: none;
        padding: 0;
    }
    .file-list li {
        margin-bottom: 8px;
    }
    .user-info {
      position: absolute;
      top: 10px;
      right: 50px;
      margin: 10px;
      text-align: center;
    }
    .user-info img {
      height: 35px;
      width: 35px;
      border-radius: 50%;
    }
    .botones {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 9999;
      color: #0084ff
    }
    .botones a {
      margin-right: 10px;
      color: #0084ff
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
</style>
</head>
<body>
<div class="botones">
<a href="ver_comprobacion.php"><button>Registro</button></a>
<a href="ver_archivos_srv.php"><button>Descargar</button></a>
</div>
<div class="sidebar">
<ul class="sidebar-items">
<li><a href="admin_panel.php">Inicio</a></li>
<li><a href="ver_archivos_srv_admin.php">Descargar</a></li>
<li><a href="ver_comprobacion_admin.php">Registros</a></li>
</ul>
</div>
<div class="user-info">
<img src="fotos/usuario.png" alt="usuario">
<p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
<div class="cerrar-sesion">
<a href="logout.php"><button>Logout</button></a>
</div>
</div>
<div class="container">
<h1>Registro Archivos</h1>
<ul class="file-list">
<?php
            $directorio = 'subidas/cuarentena'; // Cambia esto por la ruta real del directorio en tu servidor.
            $archivos = scandir($directorio);
 
            foreach ($archivos as $archivo) {
                // Omitir directorios '.' y '..'
                if ($archivo === '.' || $archivo === '..') {
                    continue;
                }
 
                // Crear un enlace que apunte al script de descarga con el nombre del archivo como parámetro
                echo '<a href="descarga.php?archivo=' . urlencode($archivo) . '">' . $archivo . '</a><br>';
            }
        ?>
</ul>