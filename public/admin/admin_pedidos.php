<?php
require_once __DIR__ . '/../../app/views/admin/admin_pedidos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos — Admin CLOTHESSTREET</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav-bar { background: #000; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .admin-nav-bar a { color: #fff; text-decoration: none; font-weight: bold; margin-left: 15px; font-size: 13px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 13px; }
        th { background: #000; color: #fff; }
        .select-estado { padding: 5px; font-weight: bold; }
        .btn-actualizar { background: #000; color: #fff; border: none; padding: 5px 10px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>
    <div class="admin-nav-bar">
        <div><strong>CLOTHESSTREET</strong> | Pedidos</div>
        <div>
            <a href="admin_inventario.php">Volver al Inventario</a>
            <a href="admin_dashboard.php">Volver al Panel</a>
            <a href="logout.php" style="color: #ff4d4d;">(Salir)</a>
            
        </div>
    </div>

    <main class="container">
        <h2>HISTORIAL Y ESTADO DE PEDIDOS</h2>
        <table>
            <thead>
                <tr>
                    <th># Pedido</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Entrega</th>
                    <th>Total</th>
                    <th>Estado Actual</th>
                    <th>Cambiar Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ped = mysqli_fetch_assoc($res_pedidos)): ?>
                    <tr>
                        <td><strong>#<?php echo $ped['id_pedido']; ?></strong></td>
                        <td><?php echo $ped['fecha_pedido']; ?></td>
                        <td><?php echo htmlspecialchars($ped['cliente']); ?><br><small><?php echo htmlspecialchars($ped['correo']); ?></small></td>
                        <td><?php echo htmlspecialchars($ped['direccion_entrega']); ?></td>
                        <td>$<?php echo number_format($ped['total'], 0, ',', '.'); ?> COP</td>
                        <td><span style="text-transform: uppercase; font-weight: bold;"><?php echo $ped['estado']; ?></span></td>
                        <td>
                            <form action="admin_pedidos.php" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="id_pedido" value="<?php echo $ped['id_pedido']; ?>">
                                <select name="nuevo_estado" class="select-estado">
                                    <option value="pendiente" <?php echo ($ped['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="pagado" <?php echo ($ped['estado'] === 'pagado') ? 'selected' : ''; ?>>Pagado</option>
                                    <option value="enviado" <?php echo ($ped['estado'] === 'enviado') ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="entregado" <?php echo ($ped['estado'] === 'entregado') ? 'selected' : ''; ?>>Entregado</option>
                                    <option value="cancelado" <?php echo ($ped['estado'] === 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                                <button type="submit" class="btn-actualizar">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>