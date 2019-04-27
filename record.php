<?php
session_start();
include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini');

//connect to db
$blog = new WorkDB($config);

//set recordId on reboot after commencement
if (isset($_GET['recordId'])) {
    $_SESSION['last_recordId'] = $_GET['recordId']; //memory id
} else {
    $_GET['recordId'] = $_SESSION['last_recordId']; //set last id
}

//get record
$record = $blog->getOneRecord($_GET['recordId']);

if (isset($_POST['nameComment'])) {
        //data of comment
        $recordId = $_POST['recordId'];
        $nameComment = $_POST['nameComment'];
        $comment = $_POST['newComment'];
        $dateComment = $_POST['dateComment'];
        $blog->insertComment($recordId, $nameComment, $comment, $dateComment);
        header("Location:record.php?recordId=".$_GET['recordId']);
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
</head>
<body>

<?php if(isset($_SESSION['user'])) { ?>
<div class="profile_info">
    <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
    <br><a href="index.php">Главная</a>
    <form action="post.php" method="post">
        <input type="text" name="exit" value="<?=$_SERVER[REQUEST_URI]?>" hidden>
        <input type="submit" value="Выйти">
    </form>
</div>
<?php
} else { ?>
    <div class="profile_info">
        <a href="index.php">Главная</a><br>
        <form action="addform.php" method="post">
            <input type="text" name="entry" value="<?=$_SERVER[REQUEST_URI]?>" hidden>
            <input type="submit" value="Вход">
        </form>
    </div>
<?php
}
?>
<div class="container">
<?php
    //get record
    foreach ($record as $record) { ?>
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
            <?php if($_SESSION['user'] == $record['author']) {
                ?>
                <form action="edit.php" method="get">
                    <input type="hidden" name="recordId" value="<?=$_GET['recordId'];?>">
                    <button class="btn_none" type="submit">Редактировать</button>
                </form>
                <?php
            }
            ?>
        </div>
<?php
    }
    //get comments
    $comment = $blog->getComments($_GET['recordId']);?>
    <label for="commentRecord">Комментарии:</label>
    <?php foreach ($comment as $row) {?>
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
    <form action="" method="post" class="add_comment" name="add_comments">
        <label for="add_comments">Добавить комментарий:</label>
        <?php if(isset($_SESSION['user'])) {
            ?>
            <input type="hidden" name="nameComment" placeholder="Имя" value="<?=$_SESSION['user']?>">
        <?php
        } else { ?>
        <input type="text" name="nameComment" placeholder="Имя" required><br>
        <?php } ?>
        <textarea name="newComment" placeholder="Комментарий" required></textarea>
        <input type="hidden" name="dateComment" value="<?=date('Y-m-d, H:i:s'); ?>">
        <input type="hidden" name="recordId" value="<?=$_GET['recordId']?>">
        <button type="submit">Отправить</button>
    </form>
</div>


</body>
</html>
