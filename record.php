<?php

session_start();

include_once 'include.php';

$page = "record.php?recordId=".$_GET['recordId']; //direct to return

//get record and comments
try {
    $record = $blog->getOneRecord($_GET['recordId']);
    $comments = $blog->getComments($_GET['recordId']);
} catch (PDOException $e) {
    echo $e->getMessage();
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Пост</title>
    <link rel="stylesheet" href="css/style.css">
    <script
            src="http://code.jquery.com/jquery-3.4.0.js"
            integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin="anonymous"></script>
    <script src="main.js" type="text/javascript"></script>
</head>
<body>

<div class="profile_info">
<?php if(isset($_SESSION['user'])) { ?>
    <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
    <br><a href="index.php">Главная</a>
    <form action="" method="post">
        <input type="submit" name="exit_btn" id="exit_btn" value="Выйти">
    </form>
<?php
} else { ?>
        <a href="index.php">Главная</a><br>
        <form action="addform.php" method="post">
            <button type="submit" name="entry" value="<?=$page?>">Вход</button>
        </form>
<?php
}
?>
</div>

<div class="container">
    <div class="records">
        <div class="blog_title">
            <?php echo $record['title']; ?>
        </div>
        <span class="blog_date">
            <?php
            $date = date_create($record['date']);
            echo date_format($date, 'd/m/y H:i'); ?>
        </span>
        <div class="blog_text"><?php echo $record['description']; ?></div>
        <div class="author"><?php echo $record['author']; ?></div>
        <?php if ($_SESSION['user'] == $record['author']) {
            ?>
            <a href="edit.php?recordId=<?=$_GET['recordId']?>">Редактировать</a>
        <?php } ?>
    </div>
    <label for="commentRecord">Комментарии (<?php echo $record['amount']; ?>):</label>
    <div class="block_comment">
            <?php
            if ($record['amount'] == 0) {
                echo "<center>Пока никто не оставил комментария.</center>";
            }
        foreach ($comments as $row) {?>
            <div class="commentRecord">
                <div class="nameComment"><?php echo $row['name'];?></div>
                <span class="comment_date"><?php
                    $date=date_create($row['dateComment']);
                    echo date_format($date, 'd/m/y H:i');?></span>
                <div class="textComment"><?php echo $row['comment'];?></div>
            </div>
            <?php
        }
        ?>
    </div>

    <form action="" method="post" class="add_comment" name="add_comments">
        <label for="add_comments">Добавить комментарий:</label>
        <input type="text" name="nameComment" id="nameComment" placeholder="Имя"><br>
        <textarea name="newComment" id="newComment" placeholder="Комментарий"></textarea>
        <input type="hidden" name="recordId" id="recordId" value="<?=$_GET['recordId']?>">
        <button type="submit" id="post_comment">Отправить</button>
    </form>
</div>


</body>
</html>
