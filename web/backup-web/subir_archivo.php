<?php
session_start();
 
if (!isset($_SESSION['usuario_id']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="UTF-8">
  <title>Subir Archivo</title>
  <style>
      .tabla {
        padding-top: 100px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: linear-gradient(to right, #B1B1B1, #B1B1B1);
        font-family: Arial, sans-serif;
      }
      .container {
        position: relative;
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
      .cerrar-sesion {
        margin-top: 10px;
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
        <li><a href="subir_archivo.php">Inicio</a></li>
        <li><a href="ver_archivos_srv.php">Descargar</a></li>
        <li><a href="ver_comprobacion.php">Registros</a></li>
        </ul>
      </div>
      <div class="user-info">
        <img src="fotos/usuario.png" alt="usuario">
        <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <div class="cerrar-sesion">
        <a href="logout.php"><button>Logout</button></a>
      </div>
      </div>
      <table align="center" class="tabla">
        <tr>
          <td align="center">
          <img src="fotos/foto_fichero.png" alt="foto fichero" height="300px" width="400px">
          </td>
          </tr>
        <tr>
          <td align="center">
            <form action="prueba2.php" method="post" enctype="multipart/form-data">
            <input type="file" name="archivos[]" id="archivos" multiple>
            <input type="submit" value="Subir Archivos">
            </form>
          </td>
        </tr>
        <tr>
        <td align="center">
        <form action="prueba2.php" method="post" enctype="multipart/form-data">
        <input type="file" id="directorio" name="archivos[]" multiple webkitdirectory directory>
        <input type="submit" value="Subir Directorio">
        </form>
        </td>
        </tr>
    </table>
  </body>
</html>