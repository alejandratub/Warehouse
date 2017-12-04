
<?php
// User session management
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
//navbar load
            require("navBar/navBar.php");
            navbar();
?>
<!DOCTYPE html>
<html>
<head>
  <!--Loads CSS styles, logo and window name -->
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleEditar.css" type="text/css" media="all" />
		<title>Inicio</title>
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
          <!-- Warehouse Logo-->
          <div class='centrar'>
          <img src="images/w.png" alt="logo" width=200px height=200px text-align=center>
          <!-- Brief description of all sections inside the webapp-->
          <div class = "row">
            <div class ="col">
            <h3>Reports</h3><br>
            <p>In the report section, you will find the most moved and the most time consuming products inside the warehouse, <br>
              as well as the times spent and movements of the Lift Trucks based on the selected dates.</p>
            </div>
            <div class = "col">
              <h3>Solutions</h3><br>
              <p>In the solution sectrion, you will find two modules, in the first one, you will be able to visualize solutions created in the past, <br>
              and in the second one you will be able to select the dates based on which the solution will be created.</p>
            </div>
            <div class = "col">
              <h3>Profile</h3><br>
              <p>In the profile section, you will find all the information, based on which the KPI's will be calculated.</p>
            </div>
          </div>
          <div class="row">
            <h3></h3>
          </div>
              </div>
</body>
</html>
