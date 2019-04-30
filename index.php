<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
session_start();

include ('WorkDB.php');
use task\WorkDB;

$config = parse_ini_file('config/config.ini'); //data of db

//connect to db
$blog = new WorkDB($config);

//sort by date
if (isset($_POST['sort'])){
    $_SESSION['sort'] = $_POST['sort'];
    header("Location:index.php");
} else {
    $records = $blog->getRecords($_SESSION['sort']); //sort from later to early (standart)
}

if(isset($_SESSION['user'])) { ?>
    <div class="profile_info">
        <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
        <form action="post.php" method="post">
            <input type="hidden" name="exit" value="<?=$_SERVER[REQUEST_URI]?>">
            <input type="submit" value="Выйти">
        </form>
    </div>
    <?php
} else { ?>
    <div class="profile_info">
        <form action="addform.php" method="post">
            <input type="text" name="entry" value="<?=$_SERVER[REQUEST_URI]?>" hidden>
            <input type="submit" value="Вход">
        </form>
    </div>
<?php
}
?>
<div class="container">
<h1>BLOG</h1>
<!-- form btn - determines the sorting-->
<form action="" method="post">
    <?php
    if ($_SESSION['sort'] === 'true'){
        echo '<button class="btn_none" type="submit" name="sort" value="false">Сортировать(по дате) &#8593;</button>';
    } else {
        echo '<button class="btn_none" type="submit" name="sort" value="true">Сортировать(по дате) &#8595;</button>';
    } //make with ajax
    ?>
</form>
<!--show records-->
<?php foreach ($records as $record) { ?>
<div class="records">
    <div class="blog_title">
        <?php echo $record['title']; ?>
    </div>
    <span class="blog_date">
            <?php
            $date = date_create($record['date']);
            echo date_format($date, 'd/m/y H:i'); ?>
        </span>
    <div class="blog_text">
        <?php echo $record['description']; ?>
    </div>
    <div class="author">By: <?php echo $record['author']; ?></div>
    <div class="comment">
        <!-- form with count of comment to this record and redirects to page with record,
        all comment to this and add comment -->
        <a href="record.php?recordId=<?=$record['id']?>">Комментарев: <?php echo $blog->countComments($record['id']); ?></a>
    </div>
</div>
<?php } ?>
<!--    transition to the page with authorization and adding an entry-->
    <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "user_1") { ?>
        <button class="records_add"><a href="addform.php">Добавить запись</a></button>
    <?php
    }?>
</div>
</body>
</html>

