<?php

    session_start();
    if(!isset($_SESSION['token'])){
        header('Location: ./login.php');
    }

    require_once('./lib/nusoap.php');
    $wsdl = 'http://localhost/webservices/?wsdl';
    $client = new nusoap_client($wsdl, 'wsdl');

    $userName = $_SESSION["userName"];

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

        $conn = OpenCon();
        $query = "SELECT id FROM users WHERE userName = '$userName'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        $query = "SELECT * FROM toDoList WHERE userId = '$userId'";
        $result = $conn->query($query);   
        
        
        if(isset($_GET['id'])){
            $taskId = $_GET['id'];
            $conn = OpenCon();
            $query = "DELETE FROM toDoList WHERE id = '$taskId'";
            $result = $conn->query($query);
            header('Location: toDoList.php');
        }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDoList</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <h2 class="logo">ToDoList</h2>
        <div class="user">
            <p><?php echo $userName ?></p>
            <a class="btn btn-primary" href="./logout.php">Wyloguj</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <form class="new_do col-sm-4" action="./services/newTask_service.php" method="post">
                <div class="form-group ">
                    <label for="task">Nowe zadanie</label>
                    <input class="form-control" id="task" type="text" name="task">
                </div>
                <div class="clearfix"></div>
                <button class="btn btn-primary pull-right">Dodaj</button>
            </form>
            <div class="clearfix"></div>
            <ul class="list-group col-sm-3">
                <?php
                while($row = $result->fetch_array()){
                echo '<li class="task-item list-group-item" id="'.$row['id'].'">'.$row['task'].'<a href="toDoList.php?id='.$row['id'].'"><div class="glyphicon glyphicon-remove-circle"></div></a></li>';
                }
                CloseCon($conn);
                ?>
                
            </ul>
        </div>
    </div>

</body>
</html>