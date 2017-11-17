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
            require('functions/editar.php');
            navbar();
            
            $postData = array(
            's' => 'previousSolutionsInfo'
            );
            
            //Combo box de las ultimas soluciones//
            $data = editarperfil($postData);
            $comboSolutions = "";
            
            //Get the solution id for the default option//
            $defaultOption = true;
            
            foreach($data as $row)
            {
                if($defaultOption)
                {
                    $defaultSolutionID = $row['id'];
                    $defaultOption = false;
                }
                $solution_id = $row['id'];
                $text = $row['wh_name'] . " - "  . $row['created_at'];
                
                
                //Si se mando un solution_id en la funcion actualizar() se selecciona en el combobox
                if($_POST['solutionValue']==$solution_id)
                    $comboInst .=" <option value='".$solution_id."' selected=\"selected\">".$solution_id."</option>";
                
                //else
                $comboSolutions .=" <option value='".$solution_id."'>".$text."</option>";
            }
            
            //Verifica si se recibio informacion a partir de seleccion de solucion del combobox//
            if(isset($_POST['solutionValue']))
            {
                $infoData = array(
                's' => 'solutionInfo',
                'solution_id' => $_POST['solutionValue']
                );
            }
            
            //Si no se escogio alguna solucion por default se muestra la informacion de la última//
            else
            {
                $infoData = array(
                's' => 'solutionInfo',
                'solution_id' => $defaultSolutionID
                );
            }
            
            $infoSolucion = editarperfil($infoData);
            foreach($infoSolucion as $row)
            {
                $u_name = $row['u_name'];
                $wh_name = $row['wh_name'];
                $since = $row['since'];
                $until = $row['until'];
                $time_reduction = $row['time_reduction'];
                $distance_reduction = $row['distance_reduction'];
                $created_at = $row['created_at'];
            }
        ?>
            <br><br> <h1>Previous Solutions</h1>
        <?php
            echo "<label>Warehouse optimized: $wh_name </label><br>";
            echo "<label>Solution created at: $created_at </label><br>";
            echo "<label>Solution created by: $u_name </label><br>";
            echo "<label>Start capture date: $since </label><br>";
            echo "<label>End capture date: $until  </label><br>";
            echo "<label>Time optimization: $time_reduction </label/><br>";
            echo "<label>Distance optimization: $distance_reduction </label><br>";
         ?>

           <!--form action=" visualizarweb/html/warehouse.html" method="post"-->
        <form id= "sol_form" method="post">
            <!--div class="right-block"-->
            <!--Get the dates where the solutions have been generated-->
            <div><label>Select the previous solution you would like to see:</label><br><br></div>
                    <select id = "solution_id" name="solution_id" onchange="actualizar()"><?php echo $comboSolutions;?></select>
                    </select></div>
            <!--/div-->
            <div><button class="btn-default" onclick="submitForm('arrangeInstructions.php')" value=" Instrucciones" type="seleccionar" name="instrucciones" >Instructions</button></div>
            <div><button class="btn-default" onclick="submitForm('initialState.php')" value=" Estado Inicial" type="seleccionar" name="inicial" >Initial Warehouse State</button></div>
            <div><button class="btn-default" onclick="submitForm('finalState.php')" value=" Estado Final" type="seleccionar" name="seleccionar" >Final Warehouse State</button></div>
        </form>
        
</body>

<script>
  function actualizar()
  {
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute("action", "previousSolutions.php");
      
      var solutionSelected = document.getElementById("solution_id").value;
      var solutionValue = document.createElement("input");
      solutionValue.setAttribute("type", "hidden");
      solutionValue.setAttribute("name", "solutionValue");
      solutionValue.setAttribute("value", solutionSelected);
      form.appendChild(solutionValue);
      
      document.body.appendChild(form);
      form.submit();
  }
</script>


<script>
  function submitForm(action) 
  {
    var form = document.getElementById('sol_form');
    form.setAttribute("method", "post");
    form.action = action;
    
    var solutionSelected = document.getElementById("solution_id").value;
    var solutionValue = document.createElement("input");
    solutionValue.setAttribute("type", "hidden");
    solutionValue.setAttribute("name", "solutionValue");
    solutionValue.setAttribute("value", solutionSelected);
    form.appendChild(solutionValue);
    
    document.body.appendChild(form);
    form.submit();
  }
</script>


</html>
