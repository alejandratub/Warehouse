<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleCuenta.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<title>Reportes</title>
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
				<div class="first-block">
					<div><h1>Cuenta</h1></div>
				</div>
				<div class="left-block">
			 	 <div><label>Correo electrónico:</label><br></div>
			 	<div><label>Número de elementos de transporte:</label><br></div>
			 	<div><br><label>Costos energéticos del uso del transporte:</label><br></div>
			 	<div><br><br><br><label>Tipo de transporte:</label><br></div>
			 	<div><br><label>Costo de operador de transporte por hora:</label><br><br><br></div>
			 	<div><br><label>Costo de mantenimiento por unidad de transporte: </label><br></div>
			 	<div><br><label>Frecuencia con la que se realiza el mantenimiento: </label><br></div>
			 	</div>

					<div class="center-button">
         <div><a class ="btn-default"  value="editar" name="editar " href ="editarPerfil.php">Editar Perfil</a></div>
       </div>
     </body>
</html>
