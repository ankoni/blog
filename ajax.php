<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once 'include.php';

if(isset($_POST['nameComment'])) {
        $recordId = $_POST['recordId'];
        $name = $_POST['nameComment'];
        $comment = $_POST['newComment'];

        $blog->insertComment($recordId, $name, $comment);
}

if (isset($_POST['description'])) {
    try {
        //data of record
        $title = $_POST['title'];
        $description = $_POST['description'];
        $dateBlog = date('Y-m-d, H:i:s');
        $author = $_POST['author'];
        //check on exist link
        if (preg_match ("/href|url|http|www|.ru|.com|.net|.info|.org/i", $title)) {
            throw new Exception('Обнаружена ссылка');
        }
        $blog->insertRecord($title, $description, $dateBlog, $author);

        echo json_encode(['success' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }

}

if(isset($_POST['titleEdit'])) {
    try {
        $blog->editRecord($_POST['titleEdit'], $_POST['descriptionEdit'], $_POST['recordId']);

        echo json_encode(['success' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['error'=>$e->getMessage()]);
    }
}

if (isset($_POST['exit'])) {
    try {
        unset($_SESSION['user']);

        echo json_encode(['success' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['error'=>$e->getMessage()]);
    }
}