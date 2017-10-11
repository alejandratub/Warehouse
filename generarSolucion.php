<!DOCTYPE html>
<html>
<head>
	<title>Generar Solución</title>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleNueva.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link rel="shortcut icon" type="image/png" href="images/w.png"/>

</head>
<body>
<?php
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
            require("navBar/navBar.php");
            navbar();
              if(isset($_POST['generar']))
          {
            $postData = array(
            'date1' => $_POST['date1'],
            'date2' => $_POST['date2'],
            's' => 'gs'
            );
            echo "[".json_encode($postData)."]";
          }
         ?>

           <form action="generarSolucion.php" method="post">
              <br><br>
		<br><br> <h1>Gnererar Solucion</h1>
 	<div class="right-block">
         <div><input id="date" type="date" name="date1"></div>
          <div><input id="date" type="date" name="date2"></div>
          </div>
           <div class="left-block">
            <div><label>Fecha de inicio:</label><br></div>
            <div><label>Fecha final:</label><br></div>
            </div>
             <div><button class="btn-default" value=" generar" type="generar" name="generar">Generar Solución</button></div>
             </form>
</body>
</html>
