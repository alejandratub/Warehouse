<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/stylereportes.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<title>Reportes</title>
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
						//Recibir lista de productos
					/*	$postData = array(
								's' => 'prod'
							 );

						// Create the context for the request
						$context = stream_context_create(array(
								'http' => array(
										'method' => 'POST',
											 'header' => "Content-Type: application/json\r\n",
										'content' => "[".json_encode($postData)."]"
								)
						));

						// Send the request
						$response = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context);
					//	echo $response;
						// Check for errors
						if($response === FALSE){
								die('Error');
						}
						//recibir lista de montacargas
						$postData = array(
						    's' => 'mont'
						   );

						// Create the context for the request
						$context = stream_context_create(array(
						    'http' => array(
						        'method' => 'POST',
						           'header' => "Content-Type: application/json\r\n",
						        'content' => "[".json_encode($postData)."]"
						    )
						));

						// Send the request
						$response = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context);
						//echo $response;
						// Check for errors
						if($response === FALSE){
						    die('Error');
						}
*/

         if(isset($_POST['generar']))
          {
						if (date('m-d-Y',strtotime($_POST['date1'])) > date('m-d-Y',strtotime($_POST['date2'])))
						{
							echo "<div class=\"infRojo\">La fecha de fin no debe ser menor a la fecha de inicio</div>";

						}
						else
						{
							$postData = array(
							'date1' => $_POST['date1'],
							'date2' => $_POST['date2'],
							'prod' => $_POST['prod'],
							'dist' => $_POST['dist'],
							'mont' => $_POST['mont'],
							's' => 'g'
							);
							echo "[".json_encode($postData)."]";
						}


          }

        ?>
	    <!--link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'-->
              <form action="reportes.php" method="post">
              <br><br>
               <h1>Generar Reporte</h1>

               <div class="right-block">
                    <div><input id="date" type="date" name="date1" required></div>
                    <div><input id="date" type="date" name="date2" required></div>
                    <div>
                    <select name="prod">
                    <option value="tuercas">Tuercas</option>
                    <option value="tornillos">Tornillos</option>
                    </select></div>
                    <div><input  class="radio" type="radio"  value="distancia" name="dist"></div>
                    <div> <select name="mont">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    </select></div>

                </div>
               <div class="left-block">
                <div><label>Fecha de inicio:</label><br></div>
                <div><label>Fecha final:</label><br></div>
                <div><label>Producto:</label><br></div>
                <div><label>Distancia:</label><br><br><br></div>
                <div><label>Montacargas: </label><br></div>
                </div>


                <div><button value="generar" type="generar" name="generar">Generar Reporte</button></div>

            </form>
        </div>
     </body>
</html>
