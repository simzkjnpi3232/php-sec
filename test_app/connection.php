<?php
require_once('config.php');

// PDOクラスのインスタンス化
function connectPdo()
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

function createTodoData($todoText)
{
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (content) VALUES (:todoText)'; //編集
    $stmt = $dbh->prepare($sql); //追記
    $stmt->bindValue(':todoText', $todoText, PDO::PARAM_STR); //追記
    $stmt->execute(); //追記
}

function getAllRecords()
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    return $dbh->query($sql)->fetchAll();
}

// function updateTodoData($post)
// {
//     $dbh = connectPdo();
//     $sql = 'UPDATE todos SET content = "' . $post['content'] . '" WHERE id = ' . $post['id'];
//     $dbh->query($sql);
// }

function updateTodoData($post)
{
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET content = :todoText WHERE id = :id'; //編集
    $stmt = $dbh->prepare($sql); //編集
    $stmt->bindValue(':todoText', $post['content'], PDO::PARAM_STR); //編集
    $stmt->bindValue(':id', (int) $post['id'], PDO::PARAM_INT); //編集
    $stmt->execute(); //編集
}

// function getTodoTextById($id)
// {
//     $dbh = connectPdo();
//     $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id =' . $id;
//     $data = $dbh->query($sql)->fetch();
//     return $data['content'];
// }

function getTodoTextById($id)
{
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL AND id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch();
    return $data['content'];
}

// function deleteTodoData($id)
// {
//     $dbh = connectPdo();
//     $now = date('Y-m-d H:i:s');
//     $sql = 'UPDATE todos SET deleted_at = "' . $now . '" WHERE id =' . $id;
//     $dbh->query($sql);
// }

function deleteTodoData($id)
{
    $dbh = connectPdo();
    $now = date('Y-m-d H:i:s');
    $sql = "UPDATE todos SET deleted_at = '$now' WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

//追記・編集はSQLインジェクション対策