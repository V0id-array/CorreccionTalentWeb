<?php
require_once dirname(__FILE__) . '/private/conf.php';
require_once dirname(__FILE__) . '/private/auth.php';

// Verificar que el usuario ha iniciado sesión
requireLogin();

if (isset($_POST['name']) && isset($_POST['team'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $team = htmlspecialchars($_POST['team'], ENT_QUOTES, 'UTF-8');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $db->prepare("INSERT OR REPLACE INTO players (playerid, name, team) VALUES (:id, :name, :team)");
        $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    } else {
        $stmt = $db->prepare("INSERT INTO players (name, team) VALUES (:name, :team)");
    }
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':team', $team, SQLITE3_TEXT);
    $stmt->execute();
    header("Location: list_players.php");
    exit();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT name, team FROM players WHERE playerid = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $name = $row['name'];
    $team = $row['team'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Player</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Player</h1>
    </header>
    <main class="player">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?><?php echo isset($_GET['id']) ? '?id=' . htmlspecialchars($_GET['id']) : ''; ?>" method="post">
            <h3>Player name</h3>
            <textarea name="name"><?php echo htmlspecialchars($name ?? ''); ?></textarea>
            <h3>Team name</h3>
            <textarea name="team"><?php echo htmlspecialchars($team ?? ''); ?></textarea>
            <input type="submit" value="Send">
        </form>
        <form action="logout.php" method="post" class="menu-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <a href="index.php">Back to home</a>
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

