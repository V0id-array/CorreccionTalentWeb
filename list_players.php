<?php
require_once dirname(__FILE__) . '/private/conf.php';
require_once dirname(__FILE__) . '/private/auth.php';

requireLogin();

// Prepare the SQL statement
$stmt = $db->prepare("SELECT playerid, name, team FROM players ORDER BY playerId DESC");
$result = $stmt->execute();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Players List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="listado">
        <h1>Players List</h1>
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
            <input type="submit" name="Logout" value="Logout" class="logout">
        </form>
    </main>
    <footer class="listado">
        <img src="images/logo-iesra-cadiz-color-blanco.png" alt="Logo">
        <h4>Puesta en producción segura</h4>
    </footer>
</body>
</html>

