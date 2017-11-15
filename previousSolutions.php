<!DOCTYPE html>
<html>
<head>
	<title>Previous Solutions</title>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/stylePasadas.css" type="text/css" media="all" />
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
        		//echo "[".json_encode($postData)."]";
							//header("Location: visualizarweb/html/warehouse.html")
          }


         ?>

           <form action=" visualizarweb/html/warehouse.html" method="post">
            <br><br>
		<br><br> <h1>Prevous Solutions</h1>
 		<!--div class="right-block"-->
 		<div><label>Select the previous solution you would like to see:</label><br><br></div>
         <select name="sol">
                    <option value="enero" >January</option>
                    <option value="marzo">March</option>
                    </select></div>
          <!--/div-->
             <div><button class="btn-default" value=" seleccionar" type="seleccionar" name="seleccionar" >Select</button></div>
             </form>
</body>
</html>
