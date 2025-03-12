# Correcciones de seguridad implementadas

## Vulnerabilidades corregidas

### Cross-Site Scripting (XSS)

Se ha prevenido la inyección de código JavaScript malicioso en las páginas web mediante el uso de la función `htmlspecialchars()` en todas las salidas de datos provenientes del usuario. Esto incluye:

*   Parámetros GET y POST
*   Cookies
*   Variables de sesión

### Inyección SQL

Se ha prevenido la inyección de código SQL malicioso en las consultas a la base de datos mediante el uso de consultas preparadas con parámetros vinculados. Esto asegura que los datos del usuario se traten como datos y no como código SQL.

### Cross-Site Request Forgery (CSRF)

Se ha prevenido la falsificación de peticiones entre sitios mediante la implementación de tokens CSRF en todos los formularios. Esto asegura que solo las peticiones originadas en el sitio web sean procesadas.

### Gestión de sesiones

Se ha mejorado la gestión de sesiones mediante el uso de variables de sesión en lugar de cookies para almacenar información sensible. Esto reduce el riesgo de robo de sesión.

## Cambios desde oldweb

### Nuevos archivos

- login.php
- logout.php

### Archivos eliminados

- .DS_Store
- add_comment.php~.php
- buscador.html
- index.php
- show_comments.php
- private/createDatabase.sh
- private/database.db

### Archivos modificados

- add_comment.php
- buscador.php
- insert_player.php
- list_players.php
- register.php
- private/auth.php
- private/conf.php

## Archivos modificados

*  `private/auth.php`
    * Se usa `session_start()` y `$_SESSION` para la gestión de sesiones, en lugar de cookies.
    * Se usa `password_verify()` para la verificación de contraseñas.
    * Se usan consultas preparadas con `bindValue` para prevenir inyección SQL.
    * Se usa `session_regenerate_id(true)` para mitigar ataques de fijación de sesión.
    * Se añadió protección CSRF con `csrf_token()` y `verify_csrf_token()`.
    * Se añadió verificación de expiración de sesión (30 minutos).
    * Se fuerza el uso de HTTPS.
    * Se separó el formulario de login a un archivo dedicado `login.php`.
*   `add_comment.php`
    *   Se requiere inicio de sesión con `requireLogin()`.
    *   Se usa `$_SESSION['userId']` en lugar de `$_COOKIE['userId']` para la autenticación.
    *   Se aplica `htmlspecialchars()` a `$_POST['body']` y `$_GET['id']` para prevenir XSS.
    *   Se usan consultas preparadas con `bindValue` para prevenir inyección SQL.
    *   Se añadió protección CSRF al formulario de logout.
    *   Se usa `htmlspecialchars($_SERVER['PHP_SELF'])` para la acción del formulario.
*   `buscador.php`
    *   Se usan consultas preparadas con `bindValue` para prevenir inyección SQL.
    *   Se aplicó `htmlspecialchars()` a las variables `$name`, `$row['name']`, `$row['team']` y `$row['playerid']` para prevenir XSS.
    *   Se añadió protección CSRF al formulario de logout.
*   `insert_player.php`
    *   Se usan consultas preparadas con `bindValue` para todas las interacciones con la base de datos, previniendo inyección SQL.
    *   Se aplicó `htmlspecialchars()` a las variables `$_POST['name']`, `$_POST['team']`, `$name` y `$team` para prevenir XSS.
    *   Se requiere inicio de sesión con `requireLogin()`.
    *   Se añadió protección CSRF al formulario de logout.
    *   Se usa `htmlspecialchars($_SERVER['PHP_SELF'])` para la acción del formulario.
*   `list_players.php`
    *   Se usan consultas preparadas.
    *   Se aplicó `htmlspecialchars()` a las variables `$row['name']`, `$row['team']` y `$row['playerid']` para prevenir XSS.
    *   Se requiere inicio de sesión con `requireLogin()`.
    *   Se añadió protección CSRF al formulario de logout.
*   `register.php`
    *   Se usa `password_hash()` para hashear la contraseña de forma segura.
    *   Se usan consultas preparadas con `bindValue` para prevenir inyección SQL.
    *   Se aplicó `htmlspecialchars()` a la variable `$username` para prevenir XSS.
    *   Se añadió validación de campos vacíos para el nombre de usuario y la contraseña.
    *   Se añadió manejo de errores básico para el fallo de registro.
    *   Se redirige a `login.php` después de un registro exitoso.
