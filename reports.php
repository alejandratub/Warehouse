<?php
		session_start();
		if(!isset($_SESSION['Name']))
				header("Location: login.php");
		require("navBar/navBar.php");
		navbar();
	require('functions/reportes.php');
		$postProducts = array(
				's' => 'listaProducto'
			 );
		$dataP =createReport($postProducts);

		$select_class = "";
		for ($i=0; $i<count($dataP); $i++)
		{
				$select_class .= "<option value=".$dataP[$i]['name'].">".$dataP[$i]['name']."</option>";
		}


 if(isset($_POST['generar']))
	{
		if (date('m-d-Y',strtotime($_POST['date1'])) > date('m-d-Y',strtotime($_POST['date2'])))
		{
			echo "<div class=\"infRojo\">Start date should be before the end date.</div>";

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
			//echo "[".json_encode($postData)."]";
		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/stylereportes.css" type="text/css" media="all" />
		<title>Reports</title>
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

	    <!--link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'-->
			<div class="container">
              <form action="reportes.php" method="post">

               <h1>Create Report</h1>
						 <!--/div-->

							 		<div class="right-block">
	               			<div><label>Start date:</label><br></div>
	                    <div><input id="date"  name="date1" placeholder="dd-mm-yyyy" required></div>
											<div><label>End date:</label><br></div>
	                    <div><input id="date" name="date2" placeholder="dd-mm-yyyy" required></div>
											<div><label>Product:</label><br></div>
	                    <div>
	                    <select name="prod">
												<option value="All">All</option>
	                    <?php echo $select_class;?>
	                    </select></div>
										</div>
</div>
										<!--div class="col-sm-12 col-mid-12 col-lg-12 "-->
                <div><button class="button hvr-ripple-in" value="generar" type="generar" name="generar">Create Report</button></div>
            </form>
        </div>
     </body>
</html>
