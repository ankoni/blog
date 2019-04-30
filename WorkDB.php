<?php

namespace task;

use Exception;
use PDO;
use PDOException;

//class for blog db
class WorkDB
{
    public $config;
    public $host;
    public $dbName;
    public $user;
    public $password;
    public $connection;
    public $dbTableName = "Records";
    public $records;
    public $blogPost;
    public $authorization = false;

    //db connect
    public function __construct($config) {
        $this->host = $config['host'];
        $this->dbName = $config['dbName'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' .
                $this->dbName, $this->user, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //request get records descending
    public function getRecords($bool) {

        $command = sprintf("SELECT *, (SELECT count(comments.recordId) FROM comments WHERE recordId=Records.id) AS amount  FROM %s ORDER BY date", $this->dbTableName);
        // Get all records
        if ($bool == 'true') {
            $sth = $this->connection->prepare($command);
        } else {
            $command.= ' DESC';
            $sth = $this->connection->prepare($command);
        }
        $sth->execute();

        return $this->records = $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneRecord($id) {
        $command = 'SELECT *,  (SELECT count(comments.recordId) FROM comments WHERE recordId=Records.id) AS amount FROM '. $this->dbTableName. ' WHERE id = '. $id;
        $sth = $this->connection->prepare($command);
        $sth->execute();
        return $this->blogPost = $sth->fetch();
    }

    public function getComments($id) {
        $com = $this->connection->prepare('SELECT * FROM comments WHERE recordId = '. $id
                                                                    . ' ORDER BY dateComment DESC');
        $com->execute();
        return $com->fetchAll(PDO::FETCH_ASSOC);
    }

    //request insert record
    public function insertRecord($title, $description, $dateBlog, $author) {
        try {
            $stmt = $this->connection->prepare('INSERT INTO ' .$this->dbTableName
               . ' (title, description, `date`, author) VALUES (:title, :description, :dateBlog, :author)');
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':dateBlog', $dateBlog);
            $stmt->bindParam(':author', $author);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //add comment
    public function insertComment($recordId, $name, $comment) {
        try {
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

            $dateComment = date('Y-m-d H:i:s');
            $com = $this->connection->prepare('INSERT INTO comments (recordId, `name`, comment, dateComment) 
                                                        VALUES (:recordId, :name, :comment, :dateComment)');
            $com->bindParam(':recordId', $recordId);
            $com->bindParam(':name', $name);
            $com->bindParam(':comment', $comment);
            $com->bindParam(':dateComment', $dateComment);
            $com->execute();

            if ('00000' != $com->errorCode()) {
                throw new Exception('Ошибка SQL');
            }

            echo json_encode(['success' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

    //authorization check
    public function checkAuthorization($login, $password) {
        try {
            $logining = $this->connection->prepare('SELECT password FROM users WHERE login = "'
                                                                                        . $login . '"');
            $logining->execute();
            $logining = $logining->fetchColumn();
            if ($logining == $password) {
                $this->authorization = true;
            } else {
                echo "Неправильный логин или пароль";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function editRecord($title, $description, $id) {
        try {
            $description.='<div class="edit_time">Отредактировано: '. date("d/m/y H:i") . '</div>';
            $edit = $this->connection->prepare('UPDATE Records SET title = :title, description = 
                                                                            :description WHERE id = '.$id);
            $edit->bindParam(':title', $title);
            $edit->bindParam(':description', $description);
            $edit->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function registration($login, $password) {
        try {
            $reg = $this->connection->prepare('INSERT INTO users (login, password)
                                                                VALUES (:login, :password)');
            $reg->bindParam(':login', $login);
            $reg->bindParam(':password', $password);
            $reg->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}