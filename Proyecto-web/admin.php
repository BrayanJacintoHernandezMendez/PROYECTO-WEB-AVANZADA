<?php
// Verificar si es administrador
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Cerrar sesión
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Contenedor principal -->
<div class="main-container">

    <!-- Sidebar (Menú lateral) -->
    <nav class="sidebar" id="sidebar">
        <button class="toggle-sidebar" onclick="toggleSidebar()">☰</button>
        <h2>Tablero</h2>
        <ul>
            <li><a href="productos.php">Productos</a></li>
        </ul>
        <form method="post" class="logout-form">
            <button type="submit" name="logout">Cerrar Sesión</button>
        </form>
    </nav>

    <!-- Contenido principal -->
    <div class="content">
        <h1>Dashboard del Administrador</h1>
        <h2>Resumen de Ventas</h2>
        <canvas id="ventasGrafica" width="400" height="200"></canvas>
    </div>

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
    }

    // Datos de ventas
    const datosVentas = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
        datasets: [{
            label: 'Ventas del primer semestre',
            data: [120, 150, 180, 100, 90, 200],
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    // Configuración del gráfico
    const config = {
        type: 'bar',
        data: datosVentas,
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    };

    // Inicializar la gráfica
    new Chart(document.getElementById('ventasGrafica'), config);
</script>

</body>
</html>