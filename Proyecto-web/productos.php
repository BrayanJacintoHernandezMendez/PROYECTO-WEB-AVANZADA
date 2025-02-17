<?php
session_start();

$productos = [
    1 => ['nombre' => 'HP Laptop 15-fc0080la AMD Ryzen 7, 16 GB, 512 GB SSD', 'precio' => 11299.00, 'imagen' => 'laptop.png'],
    2 => ['nombre' => 'SAMSUNG Galaxy S24 FE 5G', 'precio' => 9999.00, 'imagen' => 'samsung.png'],
    3 => ['nombre' => 'Sony Audífonos inalámbricos', 'precio' => 849.00, 'imagen' => 'audifonos.png'],
    4 => ['nombre' => 'Xiaomi Redmi Pad SE 8+256GB', 'precio' => 3795.00, 'imagen' => 'tablet.png'],
    5 => ['nombre' => 'Razer BlackWidow V4 Pro - Mechanical Gaming Keyboard', 'precio' => 4846.31, 'imagen' => 'teclado.png'],
    6 => ['nombre' => 'UGREEN Mouse Inalámbrico 2.4 GHz con Receptor USB', 'precio' => 299.00, 'imagen' => 'mouse.png'],
    7 => ['nombre' => 'Acer Monitor SB2 Ultra Slim 21.5" FHD (1920 x 1080)"', 'precio' => 1449.00, 'imagen' => 'monitor.png'],
    8 => ['nombre' => 'HP Impresora Multifuncional HP Smart Tank 530', 'precio' => 4759.30, 'imagen' => 'impresora.png'],
    9 => ['nombre' => 'Cable para iPhone ORIGINAL USB a Lightning', 'precio' => 149.00, 'imagen' => 'cable.png'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
        $id = (int)$_POST['producto_id'];
        $cantidad = (int)$_POST['cantidad'];

        if ($cantidad > 0) {
            $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + $cantidad;
        }
    }

    if (isset($_POST['nueva_compra'])) {
        unset($_SESSION['carrito']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        .catalogo {
            width: 65%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .productos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .producto {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px;
        }
        .producto img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 10px;
        }
        .producto h3 {
            flex-grow: 1;
            font-size: 16px;
        }
        .producto p {
            font-weight: bold;
            color: #007bff;
        }
        .carrito {
            width: 30%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
            height: fit-content;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .cerrar-sesion {
            background-color: #dc3545;
        }
        .cerrar-sesion:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="catalogo">
    <h2>Catálogo de Productos</h2>
    <div class="productos">
        <?php foreach ($productos as $id => $producto): ?>
            <div class="producto">
                <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                <h3><?php echo $producto['nombre']; ?></h3>
                <p>$<?php echo number_format($producto['precio'], 2); ?></p>
                <form method="post">
                    <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                    <label>
                        Cantidad:
                        <input type="number" name="cantidad" min="1" value="1">
                    </label>
                    <button type="submit">Agregar al Carrito</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="carrito">
    <h2>Resumen de Compra</h2>
    <form method="post">
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul>
                <?php
                $total = 0;
                foreach ($_SESSION['carrito'] as $id => $cantidad):
                    $subtotal = $productos[$id]['precio'] * $cantidad;
                    $total += $subtotal;
                    ?>
                    <li><?php echo $productos[$id]['nombre']; ?> - Cantidad: <?php echo $cantidad; ?> - Subtotal: $<?php echo number_format($subtotal, 2); ?></li>
                <?php endforeach; ?>
            </ul>
            <h3>Total a Pagar: $<?php echo number_format($total, 2); ?></h3>
            <button type="submit" name="nueva_compra">Nueva Compra</button>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </form>
    <form method="post">
        <button type="submit" name="cerrar_sesion" class="cerrar-sesion">Cerrar Sesión</button>
    </form>
</div>
</body>
</html>