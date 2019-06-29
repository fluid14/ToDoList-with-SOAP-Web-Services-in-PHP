<?php
    session_start();
    if(isset($_SESSION['token'])){
        header('Location: ./toDoList.php');
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDoList - rejestracja</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <form data-toggle="validator" role="form" action="./services/login_service.php" method="post" class="login col-sm-4">
        <div class="form-group">
            <label class="control-label" for="userName">Nazwa uzytkownika</label>
            <input class="form-control" id="userName" name="userName" type="text" required>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="password">Hasło</label>
            <input class="form-control" id="password" data-error="Hasło musi mieć przynajmniej 5 znaków" data-minlength="5" type="password" name="password" required>
            <div class="help-block with-errors"></div>
        </div>
        <button type="submit" class="btn btn-primary pull-right">Zaloguj</button>
        <p class="exsist">Nie masz konta? <a href="register.php">Zarejestruj się!</a></p>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
</html>