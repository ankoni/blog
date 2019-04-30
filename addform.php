<?php
session_start();

$user = $_POST['user_name'];
$password = $_POST['user_password'];

if(isset($_POST['entry'])) {
    $_SESSION['lastPage'] = $_POST['entry'];
}

//check authorization
if (isset($user)) {
    //connect
    include_once 'include.php';
    $blog->checkAuthorization($user, md5($password));
    if($blog->authorization) {
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
    <script
            src="http://code.jquery.com/jquery-3.4.0.js"
            integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin="anonymous"></script>
    <script src="main.js" type="text/javascript"></script>
</head>
<body>

<?php
if(isset($_SESSION['user'])) {?>
    <div class="profile_info">
        <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
        <br>
        <a href="index.php">Главная</a>
        <form action="" method="post">
            <input type="submit" name="exit_btn" id="exit_btn" value="Выйти">
        </form>
    </div>

<div class="container">
<!--    check try of authorization-->
    <form method="post" action="" class="input_blog">
        <label>Название</label>
        <input type="text" name="title" id="title" required />
        <br />
        <label>Описание</label>
        <textarea name="description" id="description" required></textarea>
        <input type="hidden" name="author" id="author" value="<?=$_SESSION['user']; ?>">
        <br />
        <button type="submit" id="input_blog">Отправить</button>
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