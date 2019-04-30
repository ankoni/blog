<?php

session_start();

include_once 'include.php';

//sort by date
if (isset($_POST['sort'])){
    $_SESSION['sort'] = $_POST['sort'];
    header("Location:index.php");
} else {
    $records = $blog->getRecords($_SESSION['sort']);
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <link rel="stylesheet" href="css/style.css">
    <script
            src="http://code.jquery.com/jquery-3.4.0.js"
            integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin="anonymous"></script>
    <script src="main.js" type="text/javascript"></script>
</head>
<body>

<div class="profile_info">
<?php
if(isset($_SESSION['user'])) { ?>
        <?php echo ' Вы зашли под: '.$_SESSION['user']; ?>
        <form action="" method="post">
            <input type="submit" name="exit_btn" id="exit_btn" value="Выйти">
        </form>
    <?php
} else { ?>
        <form action="addform.php" method="post">
            <button type="submit" name="entry" value="<?=$_SERVER['PHP_SELF']?>">Вход</button>
        </form>
<?php
}
?>
</div>

<div class="container">
<h1>BLOG</h1>
<!-- form btn - determines the sorting-->
<form action="" method="post"><?php
    if ($_SESSION['sort'] === 'true'){
        echo '<button class="btn_none" type="submit" name="sort" value="false">Сортировать(по дате) &#8593;</button>';
    } else {
        echo '<button class="btn_none" type="submit" name="sort" value="true">Сортировать(по дате) &#8595;</button>';
    }
    ?>
</form>
<!--show records-->
    <div class="main">
        <?php foreach ($blog->records as $record) { ?>
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
                    <!-- link with count of comment to this record and redirects to page with record,
                    all comment to this and add comment -->
                    <a href="record.php?recordId=<?=$record['id']?>">Комментарев: <?php echo $record['amount']; ?></a>
                </div>
            </div>
        <?php } ?>
        <!--    transition to the page with authorization and adding an entry-->
        <?php if(isset($_SESSION['user']) && $_SESSION['user'] == "user_1") { ?>
            <button class="records_add"><a href="addform.php">Добавить запись</a></button>
            <?php
        }?>
    </div>
</div>

</body>
</html>

