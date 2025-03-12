<?php
require_once dirname(__FILE__) . '/conf.php';

session_start();

function areUserAndPasswordValid($user, $password) {
    global $db;

    $stmt = $db->prepare("SELECT userId, password FROM users WHERE username = :username");
    $stmt->bindValue(':username', $user, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    if(!isset($row['password'])) return FALSE;

    if (password_verify($password, $row['password'])) {
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['username'] = $user;
        session_regenerate_id(true);
        return TRUE;
    } else {
        return FALSE;
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (areUserAndPasswordValid($_POST['username'], $_POST['password'])) {
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if session has expired (30 minutes)
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 1800)) {
    session_destroy();
    header("Location: login.php?expired=1");
    exit();
}

// Force HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['userId']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function csrf_token() {
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>

