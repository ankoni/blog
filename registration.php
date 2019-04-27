<?php
session_start();
include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini'); //data of db

//connect to db
$blog = new WorkDB($config);

if (isset($_POST['user_name'])) {
    $blog->registration($_POST['user_name'], md5($_POST['user_password']));
    header("Location:addform.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Регистрация</title>
</head>
<body>
    <?php if(!isset($_SESSION['user'])) {
        ?>
        <div class="profile_info">
            <a href="addform.php">Назад</a><br>
            <a href="index.php">Главная</a>
        </div>
            <form action="" class="registration" method="post">
                <lable>Логин:</lable><br>
                <input type="text" name="user_name" id="user_name" placeholder="Логин" maxlength="25" required><br>
                <lable>Пароль:</lable> <br>
                <input type="password" name="user_password" id="user_password" placeholder="Пароль" maxlength="10" required><br>
                <button type="submit">Зарегистрироваться</button>
            </form>
    <?php
    } ?>
</body>
</html>
