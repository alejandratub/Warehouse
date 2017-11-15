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
		<link href="css/font-awesome.css" rel="stylesheet"/>
		<!-- //font-awesome-icons -->
		<link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
				rel="stylesheet"/>
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet"/>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

	</head>
    <body>
    <div>
        <?php
            session_start();
            if(!isset($_SESSION['Name']))
                header("Location: login.php");
            require("navBar/navBar.php");
            navbar();
						 require('functions/reportes.php');

        ?>

			<div class="container">
              <form action="reportes.php" method="post">

               <h1>Reports</h1>

                <!--body data-spy="scroll" data-target=".navbar" data-offset="50"-->

                <!-- The navbar - The <a> elements are used to jump to a section in the scrollable area -->
                <nav class="navbar navbar-default">
                    <div class="navbar-header navbar-left">
          					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          						<span class="sr-only">Toggle navigation</span>
          						<span class="icon-bar"></span>
          						<span class="icon-bar"></span>
          						<span class="icon-bar"></span>
          					</button>

               <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
          					<nav class="menu-hover-effect menu-hover-effect-4">
          						<ul class="nav navbar-nav">

                     <li><a href="#section1" class="hvr-ripple-in" styl="center-block">Product's time</a></li>
										 <li><a href="#section2" class="hvr-ripple-in" styl="center-block">Product's movements</a></li>
										 <li><a href="#section3" class="hvr-ripple-in" styl="center-block">Lift-truck's time</a></li>
										 <li><a href="#section4" class="hvr-ripple-in" styl="center-block">Lift-truck's movements</a></li>


                    </ul>
                  </nav>
              </div>
							</div>
            </nav>
            <div class="clearfix"> </div>





         <?php
				 //get 20 products based on time

				 $postProducts = array(

						 's' => 'times'
						);
				 $dataP =createReport($postProducts);

				 $Ptimes= json_encode($dataP);

				 //get 20 most moved products
				 $postProducts = array(

				 	 's' => 'movements'
				 	);
				 $dataP =createReport($postProducts);

				 $Pmovements= json_encode($dataP);
				 //get lift-truck's times
				 $postProducts = array(

						 's' => 'lt_times'
						);
				 $dataP =createReport($postProducts);

				 $lt_times= json_encode($dataP);

				 	//get lift-truck's movements

				 $postProducts = array(

						 's' => 'lt_movements'
						);
				 $dataP =createReport($postProducts);

				 $lt_movements= json_encode($dataP);


			 // var_dump($Pmovements);
				//var_dump($Ptimes);

				//product's time chart
			echo '
				<script>



function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != "unction") {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}
addLoadEvent(func1);
addLoadEvent(func2);
addLoadEvent(func3);
addLoadEvent(function() {
    document.body.style.backgroundColor = "#EFDF95";
})

				/*window.onload = start();
				function start () {
					function 1();
					function 2();
					function 3();
				};*/
				function func1(){
					var chart1 = new CanvasJS.Chart("Ptime", {
						animationEnabled: true,
						exportEnabled: true,
						theme: "light1", // "light1", "light2", "dark1", "dark2"
						title:{
							text: "Top 20 products based on time"
						},
						data: [{
							type: "bar", //change type to bar, line, area, pie, etc
							indexLabelFontColor: "#ffffff",
							indexLabelPlacement: "outside",
							dataPoints: '.$Pmovements.'
						}]
					});
					chart.render();
				}


				fuction func2(){
					var chart2 = new CanvasJS.Chart("Pmovement", {
						animationEnabled: true,
						exportEnabled: true,
						theme: "light1", // "light1", "light2", "dark1", "dark2"
						title:{
							text: "Top 20 moved products"
						},
						data: [{
							type: "bar", //change type to bar, line, area, pie, etc
							indexLabelFontColor: "#ffffff",
							indexLabelPlacement: "outside",
							dataPoints: '.$Pmovements.'
						}]
					});
					chart.render();
				}


				function func3(){
					var chart3 = new CanvasJS.Chart("lt_time", {
						animationEnabled: true,
						exportEnabled: true,
						theme: "light1", // "light1", "light2", "dark1", "dark2"
						title:{
							text: "Top 20 products based on time"
						},
						data: [{
							type: "bar", //change type to bar, line, area, pie, etc
							indexLabelFontColor: "#ffffff",
							indexLabelPlacement: "outside",
							dataPoints: '.$lt_times.'
						}]
					});
					chart.render();
				}

								</script>';


		?>

		<!-- Section 1 -->
		<div id="section1">
		<div class="center-block">
				<h1>Product's time</h1>
				<div id="Ptime" style="height: 500px; width: 100%;"></div><br><br><br><br>
		 </div>
	 </div>


		<!-- Section 2 -->
		<div id="section2">
		<div class="center-block">
						<h1>Product's movements</h1>
					<div id="Pmovement" style="height: 500px; width: 100%;"></div>
		</div>
	</div>

	<!-- Section 3 -->
	<div id="section3">
	<div class="center-block">
			<h1>Lift-truck's time</h1>
			<div id="lt_time" style="height: 500px; width: 100%;"></div><br><br><br><br>
	 </div>
 </div>

     </form>



					</div>
				</div>
     </body>
</html>
