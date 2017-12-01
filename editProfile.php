<?php
session_start();
if(!isset($_SESSION['Name']))
		header("Location: login.php");
		require("navBar/navBar.php");
		navbar();
		require('functions/editar.php');
		$id_cuenta=$_SESSION['id_cuenta'];

		$postPerfil = array(
			'user' => $id_cuenta,
				's' => 'getProfile'
			 );
		$data =editarperfil($postPerfil);

		$mont=$data['no_lt'];
		$costoMont=$data['energy_costs'];
		$tipo=$data['transport_type'];
		$costohora=$data['employee_cost'];
		$mant=$data['maintaince'];
		$frecMant=$data['main_freq'];

		if(isset($_POST['generar']))
			{
				if($_POST["mont"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							'no_lt' => $_POST["mont"],
							's' => 'no_lt'
						 );

						 editarperfil($postData);
				}
				if($_POST["costoMont"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							'energy_costs' => $_POST["costoMont"],
							's' => 'energy_costs'
						 );
						 editarperfil($postData);
				}
				if($_POST["tipo"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							 'transport_type' => $_POST["tipo"],
							's' => 'transport_type'
						 );
						 editarperfil($postData);
				}
				if($_POST["costohora"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							'employee_cost' => $_POST["costohora"],
							's' => 'employee_cost'
						 );
						 editarperfil($postData);
				}
				if($_POST["mant"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							'maintaince' => $_POST["mant"],
							's' => 'maintaince'
						 );
						 editarperfil($postData);
				}if($_POST["frecMant"]!=null)
				{
					$postData = array(
						'user' => $id_cuenta,
							'main_freq' => $_POST["frecMant"],
							's' => 'main_freq'
						 );
						 editarperfil($postData);
				}
					header("Location: profile.php");
		}
		if(isset($_POST['enviar']))
		{
			$imagen = $_REQUEST['imagen'];

			// Subir archivo
         $copiarArchivo = false;

      // Copiar archivo en el directorio de archivos subidos
      // Se renombra para evitar que sobreescriba un archivo existente
      // Para garantizar la unicidad del nombre se añade una marca de tiempo
         if (is_uploaded_file ($_FILES['imagen']['tmp_name']))
         {
            $nombreDirectorio = "images";
            $idUnico = time();
            $nombreArchivo = $idUnico . "-" . $_FILES['imagen']['name'];
            $copiarArchivo = true;
         }
      // No se ha introducido ningún archivo
            else if ($_FILES['imagen']['name'] == "")
            $nombreArchivo = '';
      // El archivo introducido no se ha podido subir
         else
         {
            $errores = $errores . "<LI>No se ha podido subir el archivo\n";
            $nombreArchivo = '';
         }

     // Mostrar errores encontrados
         if ($errores != "")
         {
            print ("No se ha podido realizar la inserci&oacute;n debido a los siguientes errores:");
            print ("<UL>");
            print ($errores );
            print ("</UL>");
            print ("[ <A HREF='javascript:history.back()'>Volver</A> ]");
            exit();
         }

     // Mover archivo de imagen a su ubicación definitiva
         if ($copiarArchivo)
            move_uploaded_file ($_FILES['imagen']['tmp_name'],
            $nombreDirectorio . $nombreArchivo);

			print ("<A TARGET='_blank' HREF='" . $nombreDirectorio . $nombreArchivo . "'>" . $nombreArchivo . "</A>");
			print ("<IMG SRC=\"$nombreDirectorio$nombreArchivo\">");
		}


			echo
			'<div class ="container">
			<form action="editProfile.php" method="post">
			<br><br>
			 <h1>Edit Profile</h1><br><br>

			 <div class="col-md-4 center-block">
			 <div><label>Number of transport elements:</label><br></div>
				 <div><input id="mont"  placeholder="'.$mont.'"name="mont"></div>
				 <div><br><label>Energy cost of transport:</label><br></div>
				 <div><input id="costoMont" placeholder="'.$costoMont.'" name="costoMont"></div>
			 <div>
				 <div><br><label>Type of transport:</label><br></div>
			 <select placeholder="'.$tipo.'" name="tipo" >
				 <option></<option value="">'.$tipo.'</option>
			 <option value="electrico">Electric</option>
			 <option value="disel">Disel</option>
			 <option value="gas">Gas</option>
			 </select></div>

			</div>
			 <div class="col-md-4 center-block">
			 <h2></h2>
			 <div><label>Maintainance cost: </label><br></div>
			 <div><input id="mant"  placeholder="'.$mant.'" name="mant"></div>
			 <div><br><label>Maintainance frecuency: </label><br></div>
			 <div><input id="frecMant"  placeholder="'.$frecMant.'" name="frecMant"></div>

			</div>
			 <div class="col-md-4 center-block">

					<div><br><label>Transport Operator hourly salary:</label><br></div>
					<div><input id="costohora" placeholder="'.$costohora.'" name="costohora" ></div>

				</div>


					<div><button  class="btn-default" value="generar" type="submit" name="generar">Edit Profile</button></div>
					<div>
			        <INPUT TYPE="FILE" SIZE="44" NAME="imagen"></TD></TR>
							<INPUT TYPE="SUBMIT" NAME="enviar" VALUE="Subir mapa">
							</div>


		</form>
		</div>
			';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleEditProfile.css" type="text/css" media="all" />
		<!--link rel="stylesheet" href="css/style.css" type="text/css" media="all" /-->
		<title>Edit Profile</title>
		<link rel="shortcut icon" type="image/png" href="images/w.png"/>
		<!-- custom-theme -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Deft Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
		<script type="application/x-javascript">
			addEventListener("load", function () {
				setTimeout(hideURLbar, 0);
			}, false);

			function hideURLbar() {
				window.scrollTo(0, 1);
			}
		</script>
		<!-- //custom-theme -->
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
		<!-- Owl-carousel-CSS -->
		<link href="css/owl.carousel.css" rel="stylesheet">
		<link rel="stylesheet" href="css/team.css" type="text/css" media="all" />
		<link href="css/styleT.css" rel="stylesheet" type="text/css" media="all" />
		<!-- font-awesome-icons -->
		<link href="css/font-awesome.css" rel="stylesheet">
		<!-- //font-awesome-icons -->
		<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
		    rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
 	</head>
    <body>
    <div>

		</div>
 </body>
</html>
