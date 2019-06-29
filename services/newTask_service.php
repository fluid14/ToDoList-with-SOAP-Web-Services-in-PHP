<?php
require_once('../lib/nusoap.php');
$wsdl = 'http://localhost/webservices/?wsdl';
$client = new nusoap_client($wsdl, 'wsdl');

session_start();
$userName = $_SESSION["userName"];
$task = $_POST["task"];

$params = array('task' => $task, 'userName' => $userName);
$response = $client->call('newTask', $params);
header('Location: ../toDoList.php');
?>