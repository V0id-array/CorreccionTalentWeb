<?php
require_once dirname(__FILE__) . '/private/conf.php';
require_once dirname(__FILE__) . '/private/auth.php';

// Verificar que el usuario ha iniciado sesión
requireLogin();

if (isset($_POST['body']) && isset($_GET['id'])) {
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');
    $playerId = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    
    // Usar la sesión en lugar de cookies para el ID de usuario
    if (!isset($_SESSION['userId'])) {
        header("Location: login.php");
        exit();
    }
    $userId = $_SESSION['userId'];


    if (!is_numeric($userId)) {
        header("Location: list_players.php?error=invalid_user");
        exit();
    }

    $stmt = $db->prepare("INSERT INTO comments (playerId, userId, body) VALUES (:playerId, :userId, :body)");
    $stmt->bindValue(':playerId', $playerId, SQLITE3_TEXT);
    $stmt->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $stmt->bindValue(':body', $body, SQLITE3_TEXT);
    $stmt->execute();

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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . htmlspecialchars($_GET['id']); ?>" method="post">
            <h3>Write your comment</h3>
            <textarea name="body"></textarea>
            <input type="submit" value="Send">
        </form>
        <form action="logout.php" method="post" class="menu-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
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

