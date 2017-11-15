<!DOCTYPE html>
<html>
<head>
	<title>Generar Solución</title>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/styleNew.css" type="text/css" media="all" />

		<link rel="shortcut icon" type="image/png" href="images/w.png"/><!-- custom-theme -->
		<!--link rel="shortcut icon" type="image/png" href="images/w.png"/-->
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
		<link href="css/styleT.css" rel="stylesheet" type="text/css" media="all" />
		<!-- font-awesome-icons -->
		<link href="css/font-awesome.css" rel="stylesheet">
		<!-- //font-awesome-icons -->
		<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
		    rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
 	</head>
<body>
<?php
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
            require("navBar/navBar.php");
						require("functions/algorithm.php");
            navbar();
						$id_cuenta=$_SESSION['id_cuenta'];
						$emails = array(
							'1' => $id_cuenta
						);
						json_encode($emails);

				if(isset($_POST['generar']))
				{

					 if (date('d-m-Y',strtotime($_POST['date1'])) > date('d-m-Y',strtotime($_POST['date2'])))
					 {
						 echo "<div class=\"infRojo\">Start date should be before the end date.</div>";

					 }
					 else
					 {
						 $data = array(
						 'hours' => $_POST['hours'],
						 'minutes' => $_POST['minutes'],
						 'seconds' => $_POST['seconds'],
						 'date1' => $_POST['date1'],
						 'date2' => $_POST['date2'],
						 
						 'emails' => $emails

						 );
						 $dataAnalytic = json_encode($data);
						//echo "<div class=\"infVerde\">Your request has been made.</div>";
							//echo "[".$dataAnalytic."]";
					//	set_time_limit(0);
						runAlgorithm($dataAnalytic);

				}

		//	header("Location: solutions.php");
				}


         ?>
				 <div class="container">
           <form action="createSolution.php" method="post">
              <br><br>
							<div class="col-sm-12 col-mid-12 col-lg-12 ">
								<br><br> <h1>Create Solution</h1>
								</div>
 							<div class="col-sm-8  col-md-7 col-lg-5 left-block">
								<div><label>Data recovery:</label><br></div>
							<div><label>Start Date:</label><br></div>
		         	<div><input id="date"  name="date1" placeholder="dd-mm-yyyy" required></div>
							<div><label>End date:</label><br></div>
		          <div><input id="date" name="date2" placeholder="dd-mm-yyyy" required></div>
						</div>
						<div class="col-sm-8 col-md-7 col-lg-5 left-block">
						<div><label>Execution time:</label><br></div>
							<div><label>Hours:</label><br></div>
							<div><input id="time" type="int" name="hours" placeholder="hours"required></div>
							<div><label>Minutes:</label><br></div>
							<div><input id="time" type="int" name="minutes" placeholder="minutes"required></div>
							<div><label>Seconds:</label><br></div>
							<div><input id="time" type="int" name="seconds" placeholder="seconds"required></div>
		      </div>
							<div class="col-sm-12 col-mid-8 col-lg-8 ">
								<div><button class=" button hvr-ripple-in" value=" generar" type="generar" name="generar">Create Solution</button></div>
							</div>
             </form>
					 </div>
</body>
</html>
