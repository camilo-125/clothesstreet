<?php
// Conectamos la vista con el controlador para procesar los POSTs
require_once __DIR__ . '/../app/controllers/procesar_compra_directa.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Simulado — CLOTHESSTREET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header-items">
        <div class="logo">CLOTHES<span>STREET</span></div>
        <nav class="nav-items">
            <ul><li><a href="index.php">Volver al inicio</a></li></ul>
        </nav>
    </header>

    <!-- Usa la clase checkout-container que ya tienes en style.css -->
    <main class="checkout-container">
        <div class="col-form">
            <h2>PASARELA DE PAGO (SIMULACIÓN)</h2>
            <p style="color: #777; font-size: 13px; margin-bottom: 20px;">Los datos ingresados aquí no serán guardados ni procesados por ninguna entidad bancaria.</p>
            
            <form id="form-pago" action="procesar_compra_directa.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="confirmar_pago" value="1">
                <input type="hidden" name="origen_compra" value="<?php echo htmlspecialchars($origen); ?>">
                
                <?php if ($origen === 'directa'): ?>
                    <input type="hidden" name="id_inventario" value="<?php echo htmlspecialchars($_POST['id_inventario']); ?>">
                    <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($_POST['cantidad']); ?>">
                <?php endif; ?>

                <div class="field-group">
                    <label>Nombre del Titular</label>
                    <input type="text" placeholder="Ej. Carlos Mendoza" required>
                </div>

                <div class="field-group">
                    <label>Número de Tarjeta Simulado</label>
                    <input type="text" maxlength="19" placeholder="4000 0000 0000 0000" pattern="[0-9 ]+" required>
                </div>

                <div class="row-2">
                    <div class="field-group" style="flex: 1;">
                        <label>Fecha Exp.</label>
                        <input type="text" placeholder="MM/AA" maxlength="5" required>
                    </div>
                    <div class="field-group" style="flex: 1;">
                        <label>CVC / CVV</label>
                        <input type="password" maxlength="4" placeholder="123" pattern="[0-9]+" required>
                    </div>
                </div>

                <button type="submit" id="btn-submit" class="btn-pagar">CONFIRMAR Y PAGAR ($<?php echo number_format($subtotal, 0, ',', '.'); ?> COP)</button>
            </form>
        </div>

        <div class="col-resumen">
            <h3>Resumen de Compra</h3>
            <hr style="margin: 10px 0;">
            <p><strong>Origen:</strong> <?php echo ($origen === 'carrito') ? 'Productos del Carrito' : 'Compra Directa'; ?></p>
            <hr style="margin: 10px 0;">
            <h4>Total a Pagar: <br><span style="color: #000; font-size: 20px;">$<?php echo number_format($subtotal, 0, ',', '.'); ?> COP</span></h4>
        </div>
    </main>

    <script>
        document.getElementById('form-pago').addEventListener('submit', function() {
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerText = 'Verificando transacción...';
        });
    </script>
</body>
</html>