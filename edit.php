<?php
session_start();
include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini');

//connect to db
$blog = new WorkDB($config);

if(isset($_POST['title'])) {
    $blog->editRecord($_POST['title'], $_POST['description'], $_GET['recordId']);
    header("Location:index.php");
}

$record = $blog->getOneRecord($_GET['recordId']);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if(isset($_SESSION['user'])) {
    ?>
    <form method="post" action="" class="input_blog">
        <label>Название</label>
        <?php foreach ($record as $record) { ?>
            <input type="text" name="title" required value="<?=$record['title']?>" />
            <br />
            <label>Описание</label>
            <textarea name="description" required><?=$record['description']?></textarea>
        <?php
        } ?>
        <br />
        <button type="submit">Отправить</button>
    </form>
<?php
} ?>


</body>
</html>
