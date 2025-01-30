<?php
require_once dirname(__FILE__) . '/private/conf.php';

if (isset($_POST['body']) && isset($_GET['id'])) {
    $body = SQLite3::escapeString($_POST['body']);
    $playerId = SQLite3::escapeString($_GET['id']);
    $userId = SQLite3::escapeString($_COOKIE['userId']);

    $query = "INSERT INTO comments (playerId, userId, body) VALUES ('$playerId', '$userId', '$body')";
    $db->exec($query);

    header("Location: list_players.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Add Comment</h1>
    </header>
    <main class="player">
        <form action="#" method="post">
            <h3>Write your comment</h3>
            <textarea name="body"></textarea>
            <input type="submit" value="Send">
        </form>
        <form action="#" method="post" class="menu-form">
            <a href="list_players.php">Back to list</a>
            <input type="submit" name="Logout" value="Logout" class="logout">
        </form>
    </main>
    <footer class="listado">
        <img src="images/logo-iesra-cadiz-color-blanco.png" alt="Logo">
        <h4>Puesta en producción segura</h4>
        <p>Please <a href="http://www.donate.co">donate</a></p>
    </footer>
</body>
</html>

