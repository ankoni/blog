<?php
session_start();

include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini');

// connecting to database
$insertBlog = new WorkDB($config);

//insert record
if (isset($_POST['description'])) {
    //data of record
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dateBlog = $_POST['date_blog'];
    $author = $_POST['author'];
    $insertBlog->insertRecord($title, $description, $dateBlog, $author);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление записи</title>
</head>
<body>
<?php
//exit from user
if(isset($_POST['exit'])) {
    unset($_SESSION['user']);
    header("Location:".$_POST['exit']);
}
?>
Запись добавлена - вернитесь на <a href="index.php">главную</a>
</body>
</html>



