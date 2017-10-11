<!DOCTYPE html>
<html>
    <head>
        <meta charset ="UTF-8">
        <link rel="stylesheet" href="css/stylelogin.css" type="text/css" media="all" />
        <link rel="shortcut icon" type="image/png" href="images/w.png"/>

    </head>
    <body>
        <div class='centrar'>
            <div>
                <?php
            //require("navBar/navBarLogin.php");
              //      navbar();
                    session_start();
                    if(isset($_SESSION['Name']))
                        header("Location: inicio.php");


                    if (isset($_POST['submit']))
                    {
                        require('sesion.php');
                        $usuario=$_POST["usuario"];
                        $contrasena=$_POST["contrasena"];
                        $existe=iniciarSesion($usuario,$contrasena);

                      }
                ?>
                <!--link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'-->
                <form action="" method="post" >
                    <div class='centrar'>
                    <div class="login-block">
                    <img src="images/current-logo-3.png" alt="logo" width=300px height=150px text-align=center>
                         <br><br>
                        <div><input id ="usuario" name="usuario" type="text" placeholder="Usuario"></div>
                        <br>
                        <div><input id ="contrasena" name="contrasena" type="password" placeholder="Contraseña"></div>
                        <br><br>
                         <button value="Ingresar" type="submit" name="submit">Ingresar</button>
                         </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
