<!DOCTYPE html>
<html>
<head>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleSoluciones.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<title>Soluciones</title>
		<link rel="shortcut icon" type="image/png" href="images/w.png"/>
</head>
<body>
		<?php
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
            require("navBar/navBar.php");
            navbar();
         ?>

        <!--link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'-->
        <br><br> <h1>Soluciones</h1>

        <div class="center-button">
         <div><a class ="btn-default"  value="pasadas" name="pasadas" href ="solucionesPasadas.php">Ver Soluciones Pasadas</a></div>
         <br><br><br>
        <div><a class = "btn-default" value="nueva" name="nueva" href="generarSolucion.php">Generar Nueva Solución</a> </div>

        </div>
</body>
</html>
