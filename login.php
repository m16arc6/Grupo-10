<?php   
    session_start(); 
    #echo session_id();
?>
<html>
    <?php 

    $title = "Hatware | Login";   

            // onclick="window.location.href='https://w3docs.com';" JavaScript que permite la redirección entre páginas.
    ?>
    
        <?php
            if (isset($_REQUEST['login']))// si se ha pulsado el botón con el nombre login 
            {
    
                $servername = "rdbms.strato.de";
                $database = "dbs9329838";
                $username = "dbu3679519";
                $password = "cfasix2022.";
    
                $conn = mysqli_connect($servername, $username, $password, $database);
                if (!$conn) { // significa que si no se haga lo siguiente
                        die("Connexió errònea: " . mysqli_connect_error()); // "mate" la conexión
                        $_SESSION['estado'] = 0;
                }  
                

                $usu = mysqli_real_escape_string($conn, $_REQUEST['user']); # Limpiamos los datos del usuario 
                $pas = mysqli_real_escape_string($conn, $_REQUEST['pass']);

                #echo($pas);

                $sqlpas = "SELECT Pas 
                        FROM usuarios 
                        WHERE LOWER(Usu) = LOWER('$usu')"; # Query para sacar la contraseña de la base de datos

                $resp = mysqli_query($conn, $sqlpas); # Query ejecutada en la base de datos y respuesta
            
                $pash = mysqli_fetch_array($resp, MYSQLI_ASSOC); # Mostramos resultado

                $pashh = $pash['Pas'];
                
                $shapas = hash('sha512', $pas);
                #echo("\n.$shapas");
                #$pashhash = password_hash($pas, PASSWORD_BCRYPT);


                if ($pashh == $shapas) {
                        $sql = "SELECT * 
                            FROM usuarios  
                            WHERE Usu = '$usu' AND Pas = '$pashh'";
                        // echo $sql;
                        $res = mysqli_query($conn, $sql);
                        $_SESSION['estado'] = 1;
                        $_SESSION['nom'] = $_REQUEST['user'];
            
                        if ($fila = $res->fetch_assoc()){
                            echo "¡Hola! Usuario ".$_REQUEST['user'];
                            echo "<br>";
                        }
                        else {
                            echo "Usuario erroneo";
                            echo "<br>";
                            echo "<a href='login.php'>Volver</a>";
                            $_SESSION['estado'] = 0;
                   
                        } 
                }
                else {
                    echo ("Error :(");
                    $_SESSION['estado'] = 0;
                }
            }   
            else {
            ?>
            <div class="d-flex justify-content-center h-25 py-5">
                <div>
                    <form action="login.php" method="post">
                        <span class="textstyle">Usuario: </span> <input type="text" name="user" required><br>
                        <span class="textstyle">Contrasaeña: </span> <input type="password" name="pass" required><br>
                        <button type="submit" value="Login" name="login" class="btn btn-danger">Envíar</button>
                    </form>
                </div> 
            </div>
        <?php }
        mysqli_close($conn);
    ?>
</html>