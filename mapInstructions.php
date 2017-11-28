<?php
session_start();
if(!isset($_SESSION['Name']))
    header("Location: login.php");
require("navBar/navBar.php");
require('functions/editar.php');
navbar();
?>
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

        // Send the request
        $response = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context);

        $solution_id = $_POST['solution_id'];
                
        //Zona actualmente seleccionada//
        //Por default se selecciona la primera//
        if(is_numeric($_POST['zonaSeleccionada']))
            $zonaSeleccionada = $_POST['zonaSeleccionada'];

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
        
        $responseData = json_decode($response, TRUE);
        $instructionsData = json_decode($instructionsInfo, TRUE);

        
        
        $rows=array();
        $floor = 0;
        $name = 0;

        $storageZoneCounter = 0;
        $defaultDestinationSelected = 0;        //Variable to determine if the default destination has been selected//
        
        for($e=0;$e<count($instructionsData);$e++)
        {
            $initialZ = $instructionsData[$e]['initial_zone'];          //Zona inicial//
            $initialF = $instructionsData[$e]['initial_floor'];         //Piso inicial//         
            $finalZ = $instructionsData[$e]['final_zone'];              //Zona final//
            $finalF = $instructionsData[$e]['final_floor'];             //Piso final//   
            $nombre = $instructionsData[$e]['name'];                       //Producto actual//
            $completed = $instructionsData[$e]['completed'];            //Completez del paso actual
            $step = $instructionsData[$e]['step'];                      //Numero de paso
            
            
            //Verifica si ya se agrego el piso para esta zona//
            if(!isset($pisoAgregado[$initialZ][$initialF]))
            {
                //Termina la tabla de la ultima zona de beacons//
                $infoZonas[$prevZone] = $infoZonas[$prevZone] . "</table>";

                $pisoAgregado[$initialZ][$initialF]=1;
                $infoZonas[$initialZ]= $infoZonas[$initialZ] . "<br><h3>" .  "Floor " . $initialF . "</h3><br><br>";

                //Crea Tabla y headings para elementos de este piso//
                $infoZonas[$initialZ]= $infoZonas[$initialZ] .  "<table class=\"table-condensed\">
                                                                <tr>
                                                                <th>Product</th>
                                                                <th>Move To</th>
                                                                <th>Done</th>
                                                                <th>View</th>
                                                                </tr>";
            }

            //Mapeo de zonas de beacons con indices//
            if(!isset($beaconsAgregados[$initialZ]))
            {
                $beaconsAgregados[$initialZ] = 1;
                $mapeoBeacons[$storageZoneCounter] = $initialZ;

                //Selecciona la primera zona disponible por default si no se ha seleccionado todavia//
                if(!isset($zonaSeleccionada) && $storageZoneCounter==0)
                    $zonaSeleccionada=$initialZ;

                $storageZoneCounter++;
            }

            
            //Agrega información del producto, zona y piso de destino//

            $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<tr><td>" . $nombre . "</td>";
            $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<td>Z" . $finalZ ." - F" . $finalF . "</td>";

            if($completed=='t')
            {
                $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<td><input type=\"checkbox\" onclick=\"toggleStep($step , $solution_id)\" value = $completed checked
                name=$step></td>";
            }
            else
            {
                $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<td><input type=\"checkbox\" onclick=\"toggleStep($step , $solution_id)\" value = $completed
                name=$step></td>";
            }

            //Establece una zona de destino por default//
            if(isset($_POST['destination']))
                $viewedDestination= $_POST['destination'];
            else if($defaultDestinationSelected==0)
            {
                $defaultDestinationSelected=1;
                $viewedDestination = $finalZ;
            }

            //Check the box corresponding to the destination zone currently viewed//
            if($viewedDestination==$finalZ)
            {
                $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<td><input type=\"checkbox\" onclick=\"seleccionarLinea($zonaSeleccionada,$solution_id,$finalZ)\" checked></td>";
            }
            else
            {
                $infoZonas[$initialZ] = $infoZonas[$initialZ] . "<td><input type=\"checkbox\" onclick=\"seleccionarLinea($zonaSeleccionada,$solution_id,$finalZ)\" ></td>";
            }
            $prevZone = $initialZ;
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
                        <div class='panel panel-info'>
                            <div class='panel-body'>
                                Click on a red zone to see the products it contains, then click on a view checkbox on the table
                                to the right to view the destination zone that corresponds to this instruction.
                                <br>
                                After completing an arrangement check the box in the Done column that corresponds to the row of that instruction.
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6 col-sm-6'>
                        <picture>
                        <?php

                        echo "<img src=\"images/warehousemap.png\" id=\"image\" width=$width height=$height >";
                        echo "<svg height='$height' width='$width' id='graph' style= \"position:absolute; top:0; left:0\">";


                        $storageZoneCounter = 0;        //Zonas de almacenamiento tienen indices positivos



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
                                    //Zona inicial (Verde)
                                    if($beacon_id == $zonaSeleccionada)
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(0,255,0);stroke-width:4\"/>";
                                    }

                                    //Zona final (Morado)
                                    else if($beacon_id==$viewedDestination)
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(192,0,192);stroke-width:4\" onclick=\"seleccionarLinea($beacon_id, $solution_id, $viewedDestination)\"/>";
                                    }


                                    //Otras (Rojo)
                                    else
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(255,0,0);stroke-width:4\" onclick=\"seleccionarLinea($beacon_id, $solution_id, $viewedDestination)\"/>";
                                    }
                                    $storageZoneCounter++;

                                }

                                //Sin producto//
                                else
                                {
                                    //Zona final (Morado)
                                    if($beacon_id==$viewedDestination)
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                                        <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(192,0,192);stroke-width:4\"/>";
                                    }

                                    //Otras (Naranja)
                                    else
                                    {
                                        echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"orange\" />
                                        <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"orange\" />
                                        <line x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(255,165,0);stroke-width:4\" />";
                                    }
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
                            <div class='panel panel-primary text-center'>
                                <div class='row'>
                                    <div class = 'col-md-12 col-sm-12'>
                                        <h2>Legend</h2>
                                    </div>
                                </div>
                                <div class='row panel-body'>
                                    <div class = 'col-md-2 col-sm-2'>
                                        <svg height='230'>
                                            <line x1="0" y1 ="10" x2 ="70" y2="10" style="stroke:rgb(0,255,0);stroke-width:4"/>
                                            <line x1="0" y1 ="49" x2 ="70" y2="49" style="stroke:rgb(192,0,192);stroke-width:4"/>
                                            <line x1="0" y1 ="88" x2 ="70" y2="88" style="stroke:rgb(255,0,0);stroke-width:4"/>
                                            <line x1="0" y1 ="127" x2 ="70" y2="127" style="stroke:rgb(255,165,0);stroke-width:4"/>
                                            <line x1="0" y1 ="183" x2 ="70" y2="183" style="stroke:rgb(0,0,255);stroke-width:4"/>
                                            <line x1="0" y1 ="222" x2 ="70" y2="222" style="stroke:rgb(100,100,100);stroke-width:4"/>
                                        </svg>
                                    </div>
                                    <div class = 'col-md-10 col-sm-10 text-left'>
                                        <h4>Selected Initial Zone</h4>
                                        <br>
                                        <h4>Selected Final Zone</h4>
                                        <br>
                                        <h4>Storage zone with pending rearrangements</h4>
                                        <br>
                                        <h4>Storage zone without pending rearrangements</h4>
                                        <br>
                                        <h4>Highly frequented zone</h4>
                                        <br>
                                        <h4>Corridor</h4>
                                    </div>
                                </div>
                            </div>
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
            function seleccionarLinea(zonaSeleccionada, solution_id, dest_id)
            {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "mapInstructions.php");

                var zona = document.createElement('input');
                zona.setAttribute("type", 'hidden');
                zona.setAttribute("name", 'zonaSeleccionada');
                zona.setAttribute("value", zonaSeleccionada);

                var solution = document.createElement('input');
                solution.setAttribute("type", 'hidden');
                solution.setAttribute("name", 'solution_id');
                solution.setAttribute("value", solution_id);

                var destination = document.createElement('input');
                destination.setAttribute("type", 'hidden');
                destination.setAttribute("name", 'destination');
                destination.setAttribute("value", dest_id);

                form.appendChild(destination)
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
