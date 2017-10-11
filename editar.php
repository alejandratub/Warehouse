<?php
function editarperfil($mont,$costoMont,$tipo,$costohora,$mant,$costoMont,$frecMant)
{
$postData = array(
    'mail' => "$mail",
    'no_lt' => "$mont",
    'energy_costs' => "$costoMont",
    'transport_type' => "$tipo",
    'employee_cost' => "$costohora",
    'maintaince' => "$mant",
    'main_freq' => "$frecMant",
    's' => 'ep'
   );

// Create the context for the request
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
           'header' => "Content-Type: application/json\r\n",
        'content' => "[".json_encode($postData)."]"
    )
));

// Send the request
$response = file_get_contents('https://webservice-warehouse.run.aws-usw02-pr.ice.predix.io', FALSE, $context);
// Check for errors
if($response === FALSE)
{
    die('Error');
}
$responseData = json_decode($response, TRUE);
header("Location: cuenta.php");
/*if($responseData['status']== '001')
{
  $_SESSION['Name']=$responseData['name'];
  header("Location: cuenta.php");

}
else
{
echo "<div class=infRojo><label>Usuario o contraseña incorrectos</label></div>";
}*/
}
?>
