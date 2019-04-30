<?php
session_start();

include_once 'include.php';

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
    <script
            src="http://code.jquery.com/jquery-3.4.0.js"
            integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin="anonymous"></script>
    <script src="main.js" type="text/javascript"></script>
</head>
<body>
<?php if(isset($_SESSION['user'])) {
    ?>
    <form method="post" action="" class="input_blog">
        <label>Название</label>
        <input type="text" name="titleEdit" id="titleEdit" required value="<?=$record['title']?>" />
        <br />
        <label>Описание</label>
        <textarea name="descriptionEdit" id="descriptionEdit" required><?=$record['description']?></textarea>
        <br />
        <button type="submit" id="edit_btn" value="<?=$_GET['recordId']?>">Отправить</button>
    </form>
<?php
} ?>


</body>
</html>
