<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once 'include.php';
try {
    $dateBlog = date('Y/m/d H:i:s');

    if(isset($_POST['nameComment'])) {
        $recordId = $_POST['recordId'];
        $name = $_POST['nameComment'];
        $comment = $_POST['newComment'];

        if(empty($name) || empty($comment)) {
            throw new Exception('Пустые поля');
        }

        $nameRegexp = '/^[А-Я]{1}[а-яё]{1,23}|\s+$/su';
        $commentRegexp = '/(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        if(!preg_match($nameRegexp, $name)) {
            throw new Exception('Неправильное имя');
        }

        if(preg_match($commentRegexp, $comment)) {
            throw new Exception('Обнаружена ссылка');
        }

        $blog->insertComment($recordId, $name, $comment, $dateBlog);

       /* if ('00000' != $blog->insertComment->errorCode()) {
            throw new Exception('Ошибка SQL');
        }*/

    }

    if (isset($_POST['description'])) {

            //data of record
            $title = $_POST['title'];
            $description = $_POST['description'];
            $author = $_POST['author'];

            //check on exist link
            if (preg_match ("/href|url|http|www|.ru|.com|.net|.info|.org/i", $title)) {
                throw new Exception('Обнаружена ссылка');
            }

            $blog->insertRecord($title, $description, $dateBlog, $author);
    }

    if(isset($_POST['titleEdit'])) {
            $blog->editRecord($_POST['titleEdit'], $_POST['descriptionEdit'], $_POST['recordId']);
    }

    if (isset($_POST['exit'])) {
            unset($_SESSION['user']);
    }

    echo json_encode(['success' => 'success', 'dateBlog' => $dateBlog]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}