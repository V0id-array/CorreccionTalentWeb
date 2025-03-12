<?php
require_once dirname(__FILE__) . '/private/conf.php';
require_once dirname(__FILE__) . '/private/auth.php';

// Verificar que el usuario ha iniciado sesión
requireLogin();

// Verificar que el parámetro name existe
if (!isset($_GET['name'])) {
    header("Location: list_players.php");
    exit();
}

$name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');

$stmt = $db->prepare("SELECT playerid, name, team FROM players WHERE name = :name ORDER BY playerId DESC");
$stmt->bindValue(':name', $name, SQLITE3_TEXT);
$result = $stmt->execute();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="listado">
        <h1>Búsqueda de <?php echo htmlspecialchars($name); ?></h1>
    </header>
    <main class="listado">
        <ul>
        <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <li>
                <div>
                    <span>Name: <?php echo htmlspecialchars($row['name']); ?></span>
                    <span>Team: <?php echo htmlspecialchars($row['team']); ?></span>
                </div>
                <div>
                    <a href="show_comments.php?id=<?php echo htmlspecialchars($row['playerid']); ?>">(show/add comments)</a> 
                    <a href="insert_player.php?id=<?php echo htmlspecialchars($row['playerid']); ?>">(edit player)</a>
                </div>
            </li>
        <?php endwhile; ?>
        </ul>
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

