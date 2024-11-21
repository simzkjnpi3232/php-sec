<?php
require_once('connection.php');
session_start(); // 追記

function getTodoList()
{
    return getAllRecords();
}

//更新処理
function getSelectedTodo($id)
{
    return getTodoTextById($id);
}

function savePostedData($post)
{
    checkToken($post['token']); // 追記
    validate($post); // 追記
    $path = getRefererPath();
    switch ($path) {
        case '/new.php':
            createTodoData($post['content']);
            break;
        case '/edit.php':
            updateTodoData($post);
            break;
        case '/index.php': // 追記
            deleteTodoData($post['id']); // 追記
            break; // 追記
        default:
            break;
    }
}

// 追記
function validate($post)
{
    if (isset($post['content']) && $post['content'] === '') {
        $_SESSION['err'] = '入力がありません';
        redirectToPostedPage();
    }
}

function getRefererPath()
{
    $urlArray = parse_url($_SERVER['HTTP_REFERER']);
    return $urlArray['path'];
}

function e($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// SESSIONにtokenを格納する
function setToken()
{
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
}
//openssl_random_pseudo_bytes(16)で、ランダムな 16 文字のバイト文字列を生成
//上記で生成した文字列を bin2hex で 16 進数に変換
//生成された値を $_SESSION['token'] に格納

// SESSIONに格納されたtokenのチェックを行い、SESSIONにエラー文を格納する
function checkToken($token)
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] !== $token)) {
        $_SESSION['err'] = '不正な操作です';
        redirectToPostedPage();
    }
}
//サーバ側とクライアント側の token の整合性を確認
// 新規作成と更新でデータが送信された時に呼び出して確認

function unsetError()
{
    $_SESSION['err'] = '';
}
//SESSION のキーであるerrに格納したエラーメッセージを空文字にして
//ブラウザ上にエラーメッセージを表示させないようにするために定義

function redirectToPostedPage()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}