document.addEventListener('DOMContentLoaded', () => {

    // 1. Manejo del botón "Add to Cart"
    const botonesCarrito = document.querySelectorAll('.agre-carrito');
    const contadorCarrito = document.querySelector('.cart-contador');

    botonesCarrito.forEach(boton => {
        boton.addEventListener('click', (e) => {
            // Obtener el ID del producto desde el atributo data-id
            const idProducto = boton.getAttribute('data-id');
            
            // Enviar los datos mediante fetch a PHP
            const formData = new FormData();
            formData.append('id_producto', idProducto);
            formData.append('accion', 'agregar');

            fetch('agregar_carrito.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Actualizar el contador en el header
                    if (contadorCarrito) {
                        contadorCarrito.textContent = data.total_items;
                    }
                    
                    // Feedback visual breve en el botón
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
                    alert('Debes iniciar sesión para agregar productos al carrito.');
                    window.location.href = 'login.php';
                }
            })
            .catch(error => {
                console.error('Error al agregar al carrito:', error);
            });
        });
    });

  // Manejo del botón "Add to Favorites" con conexión a Base de Datos
const botonesFavoritos = document.querySelectorAll('.agre-favorito');

botonesFavoritos.forEach(boton => {
    boton.addEventListener('click', () => {
        const idProducto = boton.getAttribute('data-id');
        const corazon = boton.querySelector('span:first-child');

        // FormData para enviar por AJAX
        const formData = new FormData();
        formData.append('id_producto', idProducto);

        fetch('agregar_favorito.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'auth_required') {
                alert(data.message);
                window.location.href = 'login.php';
            } else if (data.action === 'added') {
                corazon.textContent = '♥';
                corazon.style.color = 'red';
            } else if (data.action === 'removed') {
                corazon.textContent = '♡';
                corazon.style.color = '';
            }
        })
        .catch(error => console.error('Error al actualizar favoritos:', error));
    });
});

    // ---------------------------------------------------------------
    // 3. MEGA MENÚ — soporte para tap en pantallas táctiles
    //    (con mouse/hover ya funciona solo con CSS; esto es para
    //    celulares y tablets, donde no existe el "hover")
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
    //    Ahí ".lupa" es un <div> (no un <form> como en catalogo.php
    //    y nosotros.php), así que el botón/Enter no hacían nada.
    // ---------------------------------------------------------------
    document.querySelectorAll('.lupa').forEach((lupa) => {
        if (lupa.tagName === 'FORM') return; // ya funciona solo, es un form real

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