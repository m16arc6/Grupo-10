<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

?>
<html>
<head>
  <title>Subir Archivo</title>
  <style>
    .tabla {
      padding-top: 100px;
    }
    body {
      margin: 10;
    }
    .container {
      position: relative;
    }
    .user-info {
      position: absolute;
      top: 0;
      right: 0;
      margin: 10px;
      text-align: center;
    }
    .user-info img {
      height: 35px;
      width: 35px;
    }
    .botones {
	position: absolute;
	top: 10px;
	left: 10px;
	z-index: 9999;
    }
    .cerrar-sesion {
	position: absolute;
	top: 80px;
	left: 5px;
	z-index: 9999;
    }
  </style>
</head>
<body>
  <div id="botones">
	<a href="ver_comprobacion.php"><button>Registro</button></a>
	<a href="ver_archivos_srv.php"><button>Descargar</button></a>
  </div>
  <div class="container">
    <div class="user-info">
      <img src="fotos/usuario.png" alt="usuario">
      <p>Usuario</p>
      <div class="cerrar-sesion">
	<a href="logout.php"><button>Logout</button></a>
      </div>
    </div>
    <table align="center" class="tabla">
      <tr>
        <td align="center">
          <img src="fotos/foto_fichero.jpg" alt="foto fichero" height="300px" width="400px">
        </td>
      </tr>
      <tr>
        <td align="center">
          <form action="prueba2.php" method="post" enctype="multipart/form-data"> <!--se podria cifrar desde aqui-->
          <input  type="file" name="archivos[]">
          <input type="submit" value="Subir">
          </form>
        </td>
      </tr>
      <tr>
        <td align="center">
          <form action="prueba2.php" method="post" enctype="multipart/form-data" > <!--se podria cifrar desde aqui-->
          <input type="file" id="directorio" name= "archivos[]" multiple="multiple"  webkitdirectory directory multiple>
          <input type="submit" value="Subir">
          </form>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
