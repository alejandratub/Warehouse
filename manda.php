<?php
// Your ID and token
$username = $_POST['username'];
$password = $_POST['password'];

// The data to send to the API
$postData = array(
    'user' => "$username",
    'pwd' => "$password",
    's' => 'a'
   );

// Create the context for the request
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
           'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
));

// Send the request
$response = file_get_contents('http://ubiquitous.csf.itesm.mx/~Warehouse/auten.php', FALSE, $context);

echo $response;

// Check for errors
if($response === FALSE){
    die('Error');
}
?>
