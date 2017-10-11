<!DOCTYPE html>
<html>
<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleEditar.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<title>Inicio</title>
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
          <div class='centrar'>
          <img src="images/current-logo-3.png" alt="logo" width=300px height=150px text-align=center>
          </div>
</body>
</html>
