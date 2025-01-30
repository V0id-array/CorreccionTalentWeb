<?php
require_once dirname(__FILE__) . '/private/conf.php';

if (isset($_POST['name']) && isset($_POST['team'])) {
    $name = SQLite3::escapeString($_POST['name']);
    $team = SQLite3::escapeString($_POST['team']);

    if (isset($_GET['id'])) {
        $id = SQLite3::escapeString($_GET['id']);
        $query = "INSERT OR REPLACE INTO players (playerid, name, team) VALUES ('$id','$name', '$team')";
    } else {
        $query = "INSERT INTO players (name, team) VALUES ('$name', '$team')";
    }

    $db->exec($query);
    header("Location: list_players.php");
    exit();
} elseif (isset($_GET['id'])) {
    $id = SQLite3::escapeString($_GET['id']);
    $query = "SELECT name, team FROM players WHERE playerid = '$id'";
    $result = $db->query($query);
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
        <form action="#" method="post">
            <h3>Player name</h3>
            <textarea name="name"><?php echo htmlspecialchars($name ?? ''); ?></textarea>
            <h3>Team name</h3>
            <textarea name="team"><?php echo htmlspecialchars($team ?? ''); ?></textarea>
            <input type="submit" value="Send">
        </form>
        <form action="#" method="post" class="menu-form">
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

