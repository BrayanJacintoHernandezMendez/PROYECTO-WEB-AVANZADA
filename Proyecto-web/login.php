<?php
session_start();

// Credenciales predefinidas
$usuarios = [
    "administrador" => "asd",
    "cliente" => "123"
];


// Manejar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
        $_SESSION['usuario'] = $usuario;

        // Redirigir según el tipo de usuario
        if ($usuario === "administrador") {
            header("Location: admin.php");
        } else {
            header("Location: productos.php");
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Si ya está autenticado, redirigir directamente
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario'] === "administrador") {
        header("Location: admin.php");
    } else {
        header("Location: productos.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>