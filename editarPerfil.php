<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleEditar.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<title>Editar Perfil</title>
		<link rel="shortcut icon" type="image/png" href="images/w.png"/>
 	</head>
    <body>
    <div>
        <?php
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
            require("navBar/navBar.php");
            navbar();

						if(isset($_POST['generar']))
							{
								require('editar.php');
								$mail=$_POST["mail"];
								$mont=$_POST["mont"];
								$costoMont=$_POST["costoMont"];
								$tipo=$_POST["tipo"];
								$costohora=$_POST["costohora"];
								$mant=$_POST["mant"];
								$costoMont=$_POST["costoMont"];
								$frecMant=$_POST["frecMant"];
								$existe = editarperfil($mail,$mont,$costoMont,$tipo,$costohora,$mant,$costoMont,$frecMant);

							}

				?>

				<form action="cuenta.php" method="post">
				<br><br>
				 <h1>Editar Perfil</h1>

				 <div class="right-block">
					 	<div><input id="mail"  type="email" name="mail"></div>
							<div><input id="mont"  name="mont"></div>
							<div><input id="costoMont" name="costoMont"></div>
							<div>
							<select name="tipo" >
								<option></<option value="">-------------------</option>
							<option value="electrico">Montacargas Electrico</option>
							<option value="disel">Montacargas con Disel</option>
							<option value="gas">Montacargas con Gas</option>
							</select></div>
							<div><input id="costohora"  name="costohora" ></div>
							<div><input id="mant" type="number" name="mant"></div>
							<div><input id="frecMant"  name="frecMant"></div>

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

						 <div><a class="btn-default" value=" generar" type="generar" name="generar">Editar Perfil</a></div>

			</form>
		</div>
 </body>
</html>
