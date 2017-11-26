<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="css/team.css" type="text/css" media="all" />
    <link href="css/styleT.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
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
        
        
        //SECTIONS DRAW//
        $data = array('s' => 'sectionsDraw');
        $json = json_encode($data);
        // Create the context for the request
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => "[".$json."]"
            )
        ));

        //PRODUCTS PER SECTION//
        $data2 = array('s' => 'prodXsection');
        $json2 = json_encode($data2);
        // Create the context for the request
        $context2 = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => "[".$json2."]"
            )
        ));

        // Send the request
        $response = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context);
        $response2 = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context2);

            
        $solution_id = $_POST['solution_id'];
        //REARRANGEMENT INSTRUCTIONS//
        $instructionsRequest = array(
            's' => 'viewInstructions',
            'solution_id' => $solution_id
        );
        
        $instructionsJson = json_encode($instructionsRequest);
        $instructionContext = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => "[".$instructionsJson."]"
            )
        ));
        $instructionsInfo = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $instructionContext);
        
        // Check for errors
        if($response === FALSE)
        {
            die('Error');
        }
        if($response2 === FALSE)
        {
            die('Error');
        }

        // para imprimir el json de la página.


        $responseData = json_decode($response, TRUE);
        $responseData2 = json_decode($response2, TRUE);
        $instructionsData = json_decode($instructionsInfo, TRUE);
        
        $rows=array();
        $floor = 0;
        $name = 0;

        $storageZoneCounter = 0;
        $instCounter = 0;
        for($e=0;$e<count($responseData2);$e++)
        {
            $beacon = $responseData2[$e]['beacon_id'];          //Zona de beacon actual//
            $piso = $responseData2[$e]['floor'];                //Piso actual//
            $nombre = $responseData2[$e]['name'];                //Producto actual//
            $section_id = $responseData2[$e]['id'];              //Zona actual (separadas por piso)//
            
            //Verifica si ya se agrego el piso para esta zona//
            if(!isset($pisoAgregado[$beacon][$piso]))
            {
                //Termina la tabla de la ultima zona de beacons//
                $infoZonas[$prevBeacon] = $infoZonas[$prevBeacon] . "</table>";
                
                $pisoAgregado[$beacon][$piso]=1;
                $infoZonas[$beacon]= $infoZonas[$beacon] . "<br><h3>" .  "Floor " . $piso . "</h3><br><br>";
                
                //Crea Tabla y headings para elementos de este piso//
                $infoZonas[$beacon]= $infoZonas[$beacon] .  "<table class=\"table-condensed\">
                                                            <tr>
                                                            <th>Product</th>
                                                            <th>Move To</th>
                                                            <th>Done</th>
                                                            </tr>";
            }

            //Mapeo de zonas de beacons con indices//
            if(!isset($beaconsAgregados[$beacon]))
            {
                $beaconsAgregados[$beacon] = 1;
                $mapeoBeacons[$storageZoneCounter] = $beacon;
                $storageZoneCounter++;
            }
            
            //Verifica si el producto agregado debe moverse a otra zona//
            $seccionInicialInst = $instructionsData[$instCounter]['initial_section'];
            if($seccionInicialInst==$section_id)
            {
                $infoZonas[$beacon] = $infoZonas[$beacon] . "<tr><td>" . $nombre . "</td>";
                $infoZonas[$beacon] = $infoZonas[$beacon] . "<td>" . $instructionsData[$instCounter]['final_section'] . "</td>";
                
                $completed = $instructionsData[$instCounter]['completed'];
                $step = $instructionsData[$instCounter]['step'];
                
                if($completed=='t')
                {
                    $infoZonas[$beacon] = $infoZonas[$beacon] . "<td><input type=\"checkbox\" onclick=\"toggleStep($step , $solution_id)\" value = $completed checked 
                    name=$step></td></tr>";
                }
                else
                {
                    $infoZonas[$beacon] = $infoZonas[$beacon] . "<td><input type=\"checkbox\" onclick=\"toggleStep($step , $solution_id)\" value = $completed
                    name=$step></td></tr>";
                }

                $instCounter++;
            }
            else
            {
                $infoZonas[$beacon] = $infoZonas[$beacon] . "<tr><td>" . $nombre . "</td>";
                $infoZonas[$beacon] = $infoZonas[$beacon] . "<td>" . "-" . "</td>";
                $infoZonas[$beacon] = $infoZonas[$beacon] . "<td>" . "-" . "</td></tr>";
            }
            
            //Obtiene el id del beacon anterior//
            $prevBeacon = $beacon;
        }


        $xMax = 0;
        $yMax = 0;
        $xMin = $responseData[0]['initial_x'];
        $yMin = $responseData[0]['initial_y'];

                for($i=0;$i<count($responseData);$i++)
                {
                $xi = $responseData[$i]['initial_x'];
                $yi = $responseData[$i]['initial_y'];
                $xf = $responseData[$i]['final_x'];
                $yf = $responseData[$i]['final_y'];


                // comparación para obtener initial_x e initial_y

                if($xi>$xMax)
                    $xMax = $xi;

                if($yi>$yMax)
                    $yMax = $yi;

                if($xi<$xMin)
                    $xMin = $xi;

                if($yi<$yMin)
                    $yMin = $yi;

                // comparación para obtener final_x y final_y
                if($xf<$xMin)
                    $xMin = $xf;

                if($yf<$yMin)
                    $yMin = $yf;

                if($xf>$xMax)
                    $xMax = $xf;

                if($yf>$yMax)
                    $yMin = $yf;

                }

            $width = 500;
            $height = 400;
            $leftMargin = 100;
            $upMargin = 100;
            $scalePercent = .9;

            ?>

            <div class='container'>
                <div class='row'>
                    <div class='col-md-12 col-sm-12'>
                        <h1 class='text-center'>Map Instructions</h1><br><br>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6 col-sm-6'>
                        <picture>
                        <?php
                        
                        echo "<img src=\"images/warehousemap.png\" id=\"image\" width=$width height=$height >";
                        echo "<svg height='$height' width='$width' id='graph' style= \"position:absolute; top:0; left:0\">";
                        
                        
                        $storageZoneCounter = 0;        //Zonas de almacenamiento tienen indices positivos
                        
                        //Zona actualmente seleccionada//
                        //Por default se selecciona la primera//
                        if(is_numeric($_POST['zonaSeleccionada']))
                            $zonaSeleccionada = $_POST['zonaSeleccionada'];
                        else
                            $zonaSeleccionada = $mapeoBeacons[0];
                        
                        for ($j=0;$j<count($responseData);$j++)
                        {
                            $x1 = $responseData[$j]['initial_x'];
                            $y1 = $responseData[$j]['initial_y'];
                            $x2 = $responseData[$j]['final_x'];
                            $y2 = $responseData[$j]['final_y'];
                            $type = $responseData[$j]['type'];
                            $beacon_id = $responseData[$j]['id'];

                            //escalamiento
                            $_x1 = (($x1-$xMin)*($scalePercent*$width))/($xMax-$xMin)+((1-$scalePercent)/2)*$width;
                            $_y1 = (($yMax-$y1)*($scalePercent*$height))/($yMax-$yMin)+((1-$scalePercent)/2)*$height;

                            $_x2 = (($x2-$xMin)*($scalePercent*$width))/($xMax-$xMin)+((1-$scalePercent)/2)*$width;
                            $_y2 = (($yMax-$y2)*($scalePercent*$height))/($yMax-$yMin)+((1-$scalePercent)/2)*$height;

                            //Zonas de almacenamiento (Rojas) con producto//
                            if($type >= 2)
                            {
                                //Con producto//
                                if($beacon_id == $mapeoBeacons[$storageZoneCounter])
                                {
                                    if($beacon_id != $zonaSeleccionada)
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(255,0,0);stroke-width:5\" onclick=\"seleccionarLinea($beacon_id, $solution_id)\"/>";
                                    }
                                    
                                    else
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(0,255,0);stroke-width:5\" onclick=\"seleccionarLinea($beacon_id)\"/>";
                                    }
                                    $storageZoneCounter++;

                                }

                                //Sin producto//
                                else
                                {
                                    echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"orange\" />
                                <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"orange\" />
                                <line x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(255,165,0);stroke-width:4\" />";
                                }

                            }

                            //Pasillos (Grises)//
                            else if($type == 0)
                            {
                                echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"gray\" />
                                <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"gray\" />
                                <line x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(100,100,100);stroke-width:4\" />";
                            }

                            //Zonas frecuentadas (Azules)//
                            else
                            {
                                echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"blue\" />
                                <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"blue\" />
                                <line x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(0,0,255);stroke-width:4\" />";
                            }
                        }

                    ?>  
                            </svg>
                        </picture>
                    </div>
                    <div class='col-md-6 col-sm-6'>
                        <div class='panel panel-primary'>
                            <?php 
                                 //Nombre de la zona seleccionada//
                                  echo "<h2 class='text-center'>Zone $zonaSeleccionada</h2>"; 
                                  echo "<div class=\"panel-body\">$infoZonas[$zonaSeleccionada]</div>"; 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    
        <script>
            function seleccionarLinea(zonaSeleccionada, solution_id)
            {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "editmap.php");
                
                var zona = document.createElement('input');
                zona.setAttribute("type", 'hidden');
                zona.setAttribute("name", 'zonaSeleccionada');
                zona.setAttribute("value", zonaSeleccionada);
                
                var solution = document.createElement('input');
                solution.setAttribute("type", 'hidden');
                solution.setAttribute("name", 'solution_id');
                solution.setAttribute("value", solution_id);
                
                form.appendChild(zona);
                form.appendChild(solution);
                document.body.appendChild(form);
                form.submit();
            }
        </script>
        <script>

            function toggleStep(step, solution_id)
            {
                var json = "[{\"s\":\"updateChecklist\", \"step\":" + step + ", \"solution_id\":" +solution_id +" }]";
                
                $.ajax({
                type: "POST",
                beforeSend: function(request) {
                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    request.setRequestHeader("Accept-Language", "en-US,en;q=0.5");
                },
                url: "https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io/index.php",
                data: json,
                processData: false,
                success: function(msg) {
                    console.log(msg);
                }
                });
            }
        </script>
    </body>
</html>
