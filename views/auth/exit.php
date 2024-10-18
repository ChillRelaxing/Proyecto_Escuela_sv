<?php
session_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

// Limpiamos todas las variables de sesión
$_SESSION = array();

// Destruimos la cookie de sesión si es necesario
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruimos la sesión
session_destroy();

// Redirigimos al usuario a la página de inicio de sesión con un mensaje
header('Location: ../../index.php?logout=1'); // Ajuste aquí
exit;