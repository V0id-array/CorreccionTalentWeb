<?php
require_once dirname(__FILE__) . '/private/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf_token($_POST['csrf_token'])) {
    session_destroy();
}

header("Location: login.php");
exit();
?>

