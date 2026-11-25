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
        .container { max-width: 1150px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; font-size: 13px; }
        th { background: #000; color: #fff; }
        .select-estado { padding: 5px; font-weight: bold; }
        .btn-actualizar { background: #000; color: #fff; border: 1px solid #fff; padding: 5px 10px; cursor: pointer; font-size: 12px; font-weight: bold; }
        .btn-detalle { background: transparent; color: #fff; border: 1px solid #fff; padding: 6px 12px; cursor: pointer; font-size: 12px; font-weight: bold; transition: 0.2s; }
        .btn-detalle:hover { background: #fff; color: #000; }

        /* ESTILOS DE LA VENTANA MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.82);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .modal-overlay.activo { display: flex; }
        .modal-caja {
            background: #111;
            color: #fff;
            border: 1px solid #444;
            width: 100%;
            max-width: 680px;
            padding: 24px;
            position: relative;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .modal-header h3 { margin: 0; font-size: 18px; letter-spacing: 0.5px; }
        .btn-cerrar {
            background: none;
            border: 1px solid #555;
            color: #fff;
            font-size: 14px;
            padding: 4px 10px;
            cursor: pointer;
        }
        .btn-cerrar:hover { background: #fff; color: #000; }
        .modal-info-cliente {
            font-size: 13px;
            color: #ccc;
            margin-bottom: 16px;
            line-height: 1.6;
        }
        .tabla-modal { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabla-modal th, .tabla-modal td { border: 1px solid #333; padding: 8px 10px; font-size: 12px; }
        .tabla-modal th { background: #000; color: #fff; }
        .modal-footer {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
        }
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
                    <th>Detalle</th>
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
                            <button type="button" 
                                    class="btn-detalle"
                                    onclick="abrirDetallePedido(
                                        <?php echo (int)$ped['id_pedido']; ?>,
                                        '<?php echo htmlspecialchars(addslashes($ped['cliente'])); ?>',
                                        '<?php echo htmlspecialchars(addslashes($ped['direccion_entrega'])); ?>',
                                        '<?php echo htmlspecialchars(addslashes($ped['telefono'] ?? 'No registrado')); ?>',
                                        '<?php echo number_format($ped['total'], 0, ',', '.'); ?>'
                                    )">
                                Ver Detalle
                            </button>
                        </td>
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

    <!-- VENTANA MODAL DE DETALLE DEL PEDIDO -->
    <div id="modalDetalle" class="modal-overlay" onclick="if(event.target === this) cerrarDetallePedido()">
        <div class="modal-caja">
            <div class="modal-header">
                <h3 id="modalTitulo">DETALLE DEL PEDIDO</h3>
                <button type="button" class="btn-cerrar" onclick="cerrarDetallePedido()">✕</button>
            </div>
            <div id="modalInfoCliente" class="modal-info-cliente"></div>
            <table class="tabla-modal">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Talla / Color</th>
                        <th>Cant.</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="modalCuerpoTabla"></tbody>
            </table>
            <div class="modal-footer">
                <span id="modalTotalPrendas">Total prendas: 0</span>
                <span id="modalTotalPagado">Total: $0 COP</span>
            </div>
        </div>
    </div>

    <script>
        const detallesPorPedido = <?php echo json_encode($detalles_pedidos, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        function formatoCOP(valor) {
            return '$' + Number(valor).toLocaleString('es-CO') + ' COP';
        }

        function abrirDetallePedido(idPedido, cliente, direccion, telefono, totalFormateado) {
            const items = detallesPorPedido[idPedido] || [];
            document.getElementById('modalTitulo').textContent = 'DETALLE DEL PEDIDO #' + idPedido;
            document.getElementById('modalInfoCliente').innerHTML =
                `<strong>Cliente:</strong> ${cliente} &nbsp;|&nbsp; <strong>Tel:</strong> ${telefono}<br>` +
                `<strong>Dirección de entrega:</strong> ${direccion}`;

            const tbody = document.getElementById('modalCuerpoTabla');
            tbody.innerHTML = '';
            let totalUnidades = 0;

            if (items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No hay ítems registrados para este pedido.</td></tr>';
            } else {
                items.forEach(item => {
                    totalUnidades += item.cantidad;
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${item.producto}</td>
                        <td>${item.talla} / ${item.color}</td>
                        <td>${item.cantidad}</td>
                        <td>${formatoCOP(item.precio)}</td>
                        <td><strong>${formatoCOP(item.subtotal)}</strong></td>
                    `;
                    tbody.appendChild(fila);
                });
            }

            document.getElementById('modalTotalPrendas').textContent = 'Total prendas: ' + totalUnidades;
            document.getElementById('modalTotalPagado').textContent = 'Total: $' + totalFormateado + ' COP';
            document.getElementById('modalDetalle').classList.add('activo');
        }

        function cerrarDetallePedido() {
            document.getElementById('modalDetalle').classList.remove('activo');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') cerrarDetallePedido();
        });
    </script>
</body>
</html>