<!DOCTYPE html>
<html>
<head>
	<title>Previous Solutions</title>
	<meta charset ="UTF-8">
		<link rel="stylesheet" href="css/stylePasadas.css" type="text/css" media="all" />
		        <link rel="stylesheet" href="css/instructionTable.css" type="text/css" media="all" />
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
            require('functions/editar.php');
            navbar();
            
            ?><br><br>
            <br><br> <h1>Arrangement Instructions</h1><?php
            
            //Get rearrangement instructions with this solution ID//
            $postData = array(
                's' => 'viewInstructions',
                'solution_id' => $_POST['solution_id']
            );
            
            
            //Combo box for previous solutions//
            $data = editarperfil($postData);

            //Table for showing solution steps//
            echo "<br><div> <table align='center'>
            <tr>
            <th>Step</th>
            <th>Ean</th>
            <th>Name</th>
            <th>Initial Section</th>
            <th>Final Section</th>
            <th>Completed</th>
            </tr>";
            
            foreach ($data as $row)
		    {
                $completed = $row['completed'];
                echo "<tr>";
                echo "<td>" . $row['step'] . "</td>";
                echo "<td>" . $row['ean'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['initial_section'] . "</td>";
                echo "<td>" . $row['final_section'] . "</td>";
                echo "<td><input type=\"checkbox\" value = $completed name=$step ></div></td>";
            }
            echo "</table> </div>";
         ?>

</body>
</html>
