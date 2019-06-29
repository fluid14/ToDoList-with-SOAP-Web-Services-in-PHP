<?php
require_once('../lib/nusoap.php');
$wsdl = 'http://localhost/webservices/?wsdl';
$client = new nusoap_client($wsdl, 'wsdl');

$userName = $_POST["userName"];
$password = $_POST["password"];

$params = array('userName' => $userName, 'password' => $password);
$response = $client->call('userLogin', $params);

if($response == 'false'){
    echo "Hasło nieprawidłowe!";
}else{
    session_start();
    $_SESSION['token'] = $response;
    $_SESSION['userName'] = $userName;
    header('Location: ../toDoList.php');
}

?>