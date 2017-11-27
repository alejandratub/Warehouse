<?php
				session_start();
				if(!isset($_SESSION['Name']))
						header("Location: login.php");
				require("navBar/navBar.php");
				navbar();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleSoluciones.css" type="text/css" media="all" />

		<title>Solutions</title>
		<link rel="shortcut icon" type="image/png" href="images/w.png"/><!-- custom-theme -->
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
        <!--link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'-->
        <br><br> <h1>Solutions</h1>

        <div class="center-button">
					<br><br>
         <div><a class="btn-default hvr-ripple-in"  value="pasadas" name="pasadas" href ="previousSolutions.php">Previous Solutions</a></div>
         <br><br><br>
        <div><a class="btn-default hvr-ripple-in" value="nueva" name="nueva" href="createSolution.php">Create New Solution</a> </div>

        </div>
</body>
</html>
