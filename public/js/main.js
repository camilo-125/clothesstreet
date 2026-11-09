document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // FUNCIÓN TOAST (Reemplazo de alert() - ISO/IEC 25000)
    // =========================================================
    function mostrarToast(mensaje, tipo = 'success') {
        let container = document.getElementById('toast-container');
        
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast ${tipo}`;
        toast.textContent = mensaje;

        container.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // =========================================================
    // LECTOR DE REDIRECCIONES PHP
    // =========================================================
    const flash = document.getElementById('flash-message');
    if (flash) {
        mostrarToast(flash.getAttribute('data-mensaje'), flash.getAttribute('data-tipo'));
    }

    // ---------------------------------------------------------------
    // 1. Manejo del botón "Add to Cart"
    // ---------------------------------------------------------------
    const botonesCarrito = document.querySelectorAll('.agre-carrito');
    const contadorCarrito = document.querySelector('.cart-contador');

    botonesCarrito.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const idProducto = boton.getAttribute('data-id');
            
            const formData = new FormData();
            formData.append('id_producto', idProducto);
            formData.append('accion', 'agregar');


            fetch('../app/controllers/agregar_carrito.php', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error('Error en la red');
                return res.json(); // Si el PHP tiene un espacio en blanco, fallará aquí
            })
            .then(data => {
                if (data.status === 'success') {
                    if (contadorCarrito) contadorCarrito.textContent = data.total_items;
                    
                    mostrarToast('Producto agregado al carrito', 'success');

                    const textoBoton = boton.querySelector('span:last-child');
                    const textoOriginal = textoBoton.textContent;
                    textoBoton.textContent = 'ADDED!';
                    boton.style.backgroundColor = '#111';
                    boton.style.color = '#fff';

                    setTimeout(() => {
                        textoBoton.textContent = textoOriginal;
                        boton.style.backgroundColor = '';
                        boton.style.color = '';
                    }, 1200);

                } else if (data.status === 'auth_required') {
                    mostrarToast('Debes iniciar sesión para comprar', 'warning');
                    setTimeout(() => { window.location.href = 'login.php'; }, 1500);

                } else if (data.status === 'error') {
                    mostrarToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error al agregar al carrito:', error);
                // Si el JSON falla o hay error de PHP, muestra este toast:
                mostrarToast('Error de conexión con el servidor', 'error');
            });
        });
    });

    // ---------------------------------------------------------------
    // 2. Manejo del botón "Add to Favorites"
    // ---------------------------------------------------------------
    const botonesFavoritos = document.querySelectorAll('.agre-favorito');

    botonesFavoritos.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const idProducto = boton.getAttribute('data-id');
            const corazon = boton.querySelector('span:first-child');

            const formData = new FormData();
            formData.append('id_producto', idProducto);

            // CÁMBIALO A ESTO:
            fetch('../app/controllers/agregar_favorito.php', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error('Error en la red');
                return res.json();
            })
            .then(data => {
                if (data.status === 'auth_required') {
                    mostrarToast('Debes iniciar sesión para guardar favoritos', 'warning');
                    setTimeout(() => { window.location.href = 'login.php'; }, 1500);
                    
                } else if (data.action === 'added') {
                    corazon.textContent = '♥';
                    corazon.style.color = 'red';
                    mostrarToast('Agregado a favoritos', 'success');

                } else if (data.action === 'removed') {
                    corazon.textContent = '♡';
                    corazon.style.color = '';
                    mostrarToast('Eliminado de favoritos', 'success');
                }
            })
            .catch(error => {
                console.error('Error al actualizar favoritos:', error);
                mostrarToast('Error al procesar favoritos', 'error');
            });
        });
    });

    // ---------------------------------------------------------------
    // 3. MEGA MENÚ — soporte para tap en pantallas táctiles
    // ---------------------------------------------------------------
    const itemsConMegaMenu = document.querySelectorAll('.has-megamenu');

    itemsConMegaMenu.forEach((item) => {
        const link = item.querySelector('.nav-link');
        if (!link) return;

        link.addEventListener('click', (e) => {
            const esTouch = window.matchMedia('(hover: none)').matches;
            if (!esTouch) return;

            const yaEstaAbierto = item.classList.contains('open');
            itemsConMegaMenu.forEach((otro) => otro.classList.remove('open'));

            if (!yaEstaAbierto) {
                e.preventDefault();
                item.classList.add('open');
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.has-megamenu')) {
            itemsConMegaMenu.forEach((item) => item.classList.remove('open'));
        }
    });

    // ---------------------------------------------------------------
    // 4. BUSCADOR DE index.php
    // ---------------------------------------------------------------
    document.querySelectorAll('.lupa').forEach((lupa) => {
        if (lupa.tagName === 'FORM') return;

        const input = lupa.querySelector('input[type="text"], input:not([type])');
        const boton = lupa.querySelector('button');
        if (!input) return;

        const irABuscar = () => {
            const q = input.value.trim();
            const destino = 'catalogo.php' + (q ? ('?busqueda=' + encodeURIComponent(q)) : '');
            window.location.href = destino;
        };

        if (boton) boton.addEventListener('click', irABuscar);
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') irABuscar();
        });
    });

});