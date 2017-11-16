<!DOCTYPE html>
<html lang="es-MX">

<head>

   <!--link rel="stylesheet" href="warehouse.css" type="text/css" /-->
   <link rel="stylesheet" href="/css/warehouse.css">
   <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
   <title>Mapa WH GE</title>

</head>


<?php
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

//$responseData[$i]['id'];

//echo count($responseData);

//echo count($responseData2);

//echo $response;

//echo $responseData;

//echo $response2;

//echo $responseData2;
//ujgfhj
//var_dump($responseData2);
$rows=array();
$floor = 0;
$name = 0;

$storageZoneCounter = 0;

for($e=0;$e<count($responseData2);$e++)
{
    $beacon = $responseData2[$e]['beacon_id'];          //Zona de beacon actual//
    $piso = $responseData2[$e]['floor'];                //Piso actual//
    $nombre = $responseData2[$e]['name'];                //Producto actual//

    //Verifica si ya se agrego el piso para esta zona//
    if(!isset($pisoAgregado[$beacon][$piso]))
    {
        $pisoAgregado[$beacon][$piso]=1;
        $infoZonas[$beacon]= $infoZonas[$beacon] . "<br>" .  "Floor " . $piso . ":<br><br>";
    }

    //Mapeo de zonas de beacons con indices//
    if(!isset($beaconsAgregados[$beacon]))
    {
        $beaconsAgregados[$beacon] = 1;
        $mapeoBeacons[$storageZoneCounter] = $beacon;
        $storageZoneCounter++;
    }
    $infoZonas[$beacon] = $infoZonas[$beacon] . $nombre . "<br>";
}

//for para imprimir el mapeo de beacons
/*for($e=0;$e<count($mapeoBeacons);$e++)
{
    echo $mapeoBeacons[$e];
    echo "<br>";
}*/

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
		   {
		      $xMax = $xi;
		   }

		   if($yi>$yMax)
		   {
		      $yMax = $yi;
		   }

		   if($xi<$xMin)
		   {

		      $xMin = $xi;
		   }
		   if($yi<$yMin)
		   {
		      $yMin = $yi;
		   }

		   // comparación para obtener final_x y final_y

		   if($xf<$xMin)
		   {
		      $xMin = $xf;
		   }

		   if($yf<$yMin)
		   {
		      $yMin = $yf;
		   }

		   if($xf>$xMax)
		   {
		      $xMax = $xf;
		   }

		   if($yf>$yMax)
		   {
		      $yMin = $yf;
		   }

		}

		//echo $xMin;
		//echo $xMax;
		//echo $yMin;
		//echo $yMax;
		//echo "<label>$xMin</label>";

	// proceso de escalamiento
    //$algo = ((3-$xMin)*1000)/($xMax-$xMin);
    //$vamos = ((3-$yMin)*1000)/($yMax-$yMin);
    //Prueba para ver si imprime:
    //echo $algo;
    //echo $vamos;

    //$width = 580;
    //$height = 580;
    $scalePercent = .9;

    ?>

    <body>

    <p id="text1"></p>
    <!--p id="text2"></p-->

<form method="post">
    <input type="hidden" id="posX" name="positionX" value="posX">
    <input type="hidden" id="posY" name="positionY" value="posY">
    <input type="submit">
</form>
    <?php
      //echo "estos son los datos" . $_REQUEST['positionX'];
      //echo "estos son los datos" . $_REQUEST['positionY'];
     ?>

     <?php
      $width = $_REQUEST['positionX'];
      $height = $_REQUEST['positionY'];
      ?>

<input type='file' id='getval' name="background-image"/><br/><br/>
<div class="coords">

    <?php

    echo "<svg height='$height' width='$width' id='graph' >";

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

		echo $x1 . "\n";
		echo $y1 . "\n";

		echo $x2 . "\n";
		echo $y2 . "\n";

		//echo $beacon_id . " OTRO: " . $mapeoBeacons[$storageZoneCounter];

        //Zonas de almacenamiento (Rojas) con producto//
		if($type >= 2)
		{
            //Con producto//
            if($beacon_id == $mapeoBeacons[$storageZoneCounter])
            {
                echo " <circle cx=\"" . $_x1 . "\" cy=\"" . $_y1 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                <circle cx=\"" . $_x2 . "\" cy=\"" . $_y2 . "\" r=\"6\" stroke=\"none\" stroke-width=\"none\" fill=\"red\" />
                <line id=\"linea".$mapeoBeacons[$storageZoneCounter]."\" x1=\"" . $_x1 . "\" y1=\"" . $_y1 . "\" x2=\"" . $_x2 . "\" y2=\"" . $_y2 . "\" style=\"stroke:rgb(255,0,0);stroke-width:5\" />";
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
</div>




  <script>
    document.getElementById('getval').addEventListener('change', readURL, true);
    function readURL(){
    var file = document.getElementById("getval").files[0];
    var reader = new FileReader();
    reader.onloadend = function(){
    document.getElementById('graph').style.backgroundImage = "url(" + reader.result + ")";
    }
      if(file){
      reader.readAsDataURL(file);
      }else{
      }
}
  </script>

	</body>



	<script
  		   src="https://code.jquery.com/jquery-3.2.1.min.js"
    	   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  		   crossorigin="anonymous">
  </script>

  <script>
      $('#graph').click((event) => {
        var cX = event.clientX;
        var cY = event.clientY;
        $('#text1').text("client - X: " + cX + ", Y coords: " + cY);
        $('#posX').val(cX);
        $('#posY').val(cY);



      });
  </script>

   		<script>

   	 $(document).ready(function(){
   			 	//for($i=0;$i<$j;$i++)
          <?php
   			 	for($i=0;$i<$storageZoneCounter;$i++)
   			 	{
                    $beacon_id = $mapeoBeacons[$i];
    				echo "  $('#linea".$beacon_id."').click(function(){
    							alert(\"Zone: ".$beacon_id. $infoZonas[$beacon_id] ."\");
    						});";
    			 }
           ?>
         });

    // impresion para la cantidad de zona de alamacenamiento
    //echo $storageZoneCounter;

   		</script>