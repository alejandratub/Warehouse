<!DOCTYPE html>
<html>
<head>
	<title>Soluciones Pasadas</title>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/stylePasadas.css" type="text/css" media="all" />
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
             if(isset($_POST['seleccionar']))
          {
            $postData = array(
            'date1' => $_POST['sol'],
            's' => 'sp'
            );
            echo "[".json_encode($postData)."]";
          }

         ?>

           <form action="solucionesPasadas.php" method="post">
            <br><br>
		<br><br> <h1>Soluciones Pasadas</h1>
 		<div class="right-block">
 		<div><label>Seleccione la solución deseada:</label><br><br></div>
         <select name="sol">
                    <option value="enero">Enero</option>
                    <option value="marzo">Marzo</option>
                    </select></div>
          </div>
             <div><button class="btn-default" value=" seleccionar" type="seleccionar" name="seleccionar">Seleccionar</button></div>
             </form>
</body>
</html>
