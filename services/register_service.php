<?php
require_once('../lib/nusoap.php');
$wsdl = 'http://localhost/webservices/?wsdl';
$client = new nusoap_client($wsdl, 'wsdl');

$userName = $_POST["userName"];
$password = $_POST["password"];

$params = array('userName' => $userName, 'password' => $password);
$response = $client->call('userRegister', $params);
header('Location: ../login.php');
?>