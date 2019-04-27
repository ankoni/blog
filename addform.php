<?php
session_start();

include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini'); //data of db

$user = $_POST['user_name'];
$password = $_POST['user_password'];

if(isset($_POST['entry'])) {
    $_SESSION['lastPage'] = $_POST['entry'];
}

//check authorization
if (isset($user)) {
    //connect
    $blogAdd = new WorkDB($config);
    $blogAdd->checkAuthorization($user, md5($password));
    if($blogAdd->authorization) {
        $_SESSION['user'] = $user;
        header("Location:".$_SESSION['lastPage']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление записи</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
if(isset($_SESSION['user'])) {?>
    <div class="profile_info">
        <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
        <br>
        <a href="index.php">Главная</a>
        <form action="post.php" method="post">
            <input type="text" name="exit" value="<?=$_SERVER[REQUEST_URI]?>" hidden>
            <input type="submit" value="Выйти">
        </form>
    </div>
<div class="container">
<!--    check try of authorization-->
    <form method="post" action="post.php" class="input_blog">
        <label>Название</label>
        <input type="text" name="title" required />
        <br />
        <label>Описание</label>
        <textarea name="description" required></textarea>
        <input type="hidden" name="date_blog" value="<?=date('Y-m-d, H:i:s'); ?>">
        <input type="hidden" name="author" value="<?=$_SESSION['user']; ?>">
        <br />
        <button type="submit">Отправить</button>
    </form>
        <?php
        } else { ?>
            <div class="profile_info">
                <a href="index.php">Главная</a>
            </div>
            <form action="" class="authorization" method="post">
                <lable>Логин:</lable><br>
                <input type="text" name="user_name" id="user_name" placeholder="Логин" required><br>
                <lable>Пароль:</lable> <br>
                <input type="password" name="user_password" id="user_password" placeholder="Пароль" required><br>
                <button type="submit">Войти</button>
                <a href="registration.php">Зарегистрироваться</a>
            </form>
            <?php
        }
        ?>
</div>
</body>
</html>

<!--валидация данных-->