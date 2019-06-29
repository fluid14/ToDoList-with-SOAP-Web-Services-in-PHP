<?php 

// Create new SOAP Web Service
require_once("lib/nusoap.php");
$server = new soap_server();
$namespace = '127.0.0.1'; 
$server->configureWSDL('mySOAP', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;


// Create MySql new connection
function OpenCon(){
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "qwerty";
  $db = "toDoList";
  $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
  return $conn;
  }
  
 function CloseCon($conn){
  $conn -> close();
  }


// SOAP Functions


// Get server time function
$server->register("getTime",array('time_format'=>'xsd:string'),array('return'=>'xsd:string'),$namespace,false,'rpc','encoded','Return time');   
function getTime($time_format){
  $result = date($time_format);
  return new soapval('return', 'xsd:string', $result);
}

// Add new user
$server->register("userRegister",array('userName'=>'xsd:string', 'password'=>'xsd:string'),array('return'=>'xsd:string'),$namespace,false,'rpc','encoded','test'); 

function userRegister($userName, $password){
  $token = md5(uniqid($userName, true));
  $conn = OpenCon();
  $query = "INSERT INTO users VALUES (NULL, '$userName', '$password', '$token')";
  if ($conn->query($query) === TRUE) {
    $result = "true";
  } else {
    $result = "Error: " . $query . "<br>" . $conn->error;
  }
  CloseCon($conn);
  return new soapval('return', 'xsd:string', $result);
}

// Login user
$server->register("userLogin",array('userName'=>'xsd:string', 'password'=>'xsd:string'),array('return'=>'xsd:string'),$namespace,false,'rpc','encoded','test'); 

function userLogin($userName, $password){
  $conn = OpenCon();
  $query = "SELECT userName, pass, token FROM users WHERE userName = '$userName'";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  if($row["pass"] == $password){
    $resToken = $row["token"];
  }else{
    $resToken = 'false';
  }
  CloseCon($conn);
  return new soapval('return', 'xsd:string', $resToken);
}

// New task
$server->register("newTask",array('task'=>'xsd:string', 'userName'=>'xsd:string'),array('return'=>'xsd:boolean'),$namespace,false,'rpc','encoded','test');

function newTask($task, $userName){
  $conn = OpenCon();
  $query = "SELECT id FROM users WHERE userName = '$userName'";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $userId = $row['id'];
  $date = date("j.m.Y  G:i:s"); 
  $query = "INSERT INTO toDoList VALUES (NULL, '$userId', '$task', '$date')";
  if ($conn->query($query) === TRUE) {
    $result = "true";
  } else {
    $result = "Error: " . $query . "<br>" . $conn->error;
  }
  CloseCon($conn);
  return new soapval('return', 'xsd:string', $result);
}

// Get Tasks
$server->register("getTask",array('userName'=>'xsd:string'),array('return'=>'xsd:string'),$namespace,false,'rpc','encoded','test');
function getTask($userName){
  $conn = OpenCon();
  $query = "SELECT id FROM users WHERE userName = '$userName'";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $userId = $row['id'];

  $query = "SELECT * FROM toDoList WHERE userId = '$userId'";
  $result = $conn->query($query);
  $row = $result->fetch_assoc();
  $result = $row['task'];
  CloseCon($conn);
  return new soapval('return', 'xsd:string', $result);
}
 
// Serve SOAP Web Service
$postdata = file_get_contents("php://input");
$postdata = isset($postdata) ? $postdata : '';

$server->service($postdata);
 
?>
 