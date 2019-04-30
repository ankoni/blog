<?php
session_start();

include_once 'include.php';

//insert record
if (isset($_POST['description'])) {
    //data of record
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dateBlog = $_POST['date_blog'];
    $author = $_POST['author'];
    //check on exist link
    if (preg_match ("/href|url|http|www|.ru|.com|.net|.info|.org/i", $title)) {
        die('<script>alert("Ссылка");</script><a href="addform.php">Назад</a>');//not add
    }
    $blog->insertRecord($title, $description, $dateBlog, $author);
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



