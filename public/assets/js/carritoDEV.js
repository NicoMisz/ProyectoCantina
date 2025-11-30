let carreto = null;

function actualitzarBadgeCarreto(carreto) {
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        // Contar el número de artículos diferentes (claves del objeto)
        const numArticulos = carreto && typeof carreto === 'object' ? Object.keys(carreto).length : 0;
        badge.textContent = numArticulos;

        // Opcional: ocultar badge si está vacío
        if (numArticulos === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'flex';
        }
    }
}

function netejarCarreto() {
    // Petición AJAX para limpiar el carrito en el servidor
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/netejar-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
                // Recargar el carrito después de limpiarlo
                carregarCarreto(function (carretoRecibido) {
                    carreto = carretoRecibido;
                    // console.log("Carreto limpiado:", carreto);
                    actualitzarBadgeCarreto(carreto);
                });
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };
    xhr.send("msg=Hola desde JavaScript");
}

function afegirArticle(id, quantitat, preu = null) {
    // Petición AJAX para añadir artículo al carrito
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/afegir-article-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
                // Recargar carrito para reflejar los cambios
                carregarCarreto(function (carretoRecibido) {
                    carreto = carretoRecibido;
                    actualitzarBadgeCarreto(carreto);
                });
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };
    // Preparar datos: [id, cantidad, precio (opcional)]
    let data = [id, quantitat];
    if (preu != null) {
        data.push(preu)
    }
    let json = JSON.stringify(data);
    xhr.send("data=" + json);
}

function eliminarArticle(key) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/eliminar-article-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
                carregarCarreto(function (carretoRecibido) {
                    carreto = carretoRecibido;
                    actualitzarBadgeCarreto(carreto);
                });
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };

    let json = JSON.stringify(key);
    xhr.send("data=" + json);
}

// function eliminarArticle(key) {
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "/eliminar-article-carreto", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 console.log("Respuesta del servidor:", xhr.responseText);
//                 carregarCarreto(function (carretoRecibido) {
//                     carreto = carretoRecibido;
//                     actualitzarBadgeCarreto(carreto);
//                 });
//             } else {
//                 console.error("Error en la petición:", xhr.status);
//             }
//         }
//     };

//     let json = JSON.stringify(key);
//     xhr.send("data=" + json);
// }

function carregarCarreto(callback) {
    // Petición AJAX para obtener el contenido actual del carrito
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/carregar-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                let carretoData = res.res === 1 ? res.carreto : null;

                // Actualizar la interfaz
                actualitzarLlistaCarreto(carretoData);
                actualitzarBadgeCarreto(carretoData);
                // Llamar al callback con los datos
                if (callback) {
                    callback(carretoData);
                }
            } else {
                if (callback) {
                    callback(null);
                }
            }
        }
    };

    xhr.send();
}

function crearTicket(callback) {
    // Petición AJAX para generar un ticket de compra
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/crear-ticket", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                if (res.res === 1) {
                    // Redirigir a Tickets
                    if (res.redirect) {
                        window.location.href = res.redirect;
                    }
                    // Ejecutar callback si existe
                    if (callback) {
                        callback(res.ticket || true);
                    }
                } else {
                    // Error del servidor (res === 0)
                    console.error(res.msg || "Error desconocido");
                    alert(res.msg || "Error al crear el ticket");
                    if (callback) {
                        callback(null);
                    }
                }
            } else {
                console.error("Error:", xhr.status);
                if (callback) {
                    callback(null);
                }
            }
        }
    };
    xhr.send();
}



function actualitzarLlistaCarreto(carreto) {
    // Actualiza el HTML del panel lateral del carrito
    const carretoElement = document.getElementById('carreto');

    if (!carretoElement) {
        console.error('No se encontró el elemento con id "carreto"');
        return;
    }

    // Verificar si el carreto es null
    if (!carreto || Object.keys(carreto).length === 0) {
        // Mostrar mensaje de carrito vacío
        carretoElement.innerHTML = `
        <div class="cart-content">
            <div class="cart-items">
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <p>Tu carrito está vacío</p>
                </div>
            </div>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>0.00€</span>
                </div>
                <div class="summary-row">
                    <span>IVA (10%):</span>
                    <span>0.00€</span>
                </div>
                <div class="summary-row summary-total">
                    <span>TOTAL:</span>
                    <span>0.00€</span>
                </div>
                <a class="btn-comprar" href="/carrito" style="opacity: 0.5; cursor: not-allowed;">
                    Proceder al Pago
                </a>
            </div>
        </div>
    `;
        const closeBtn = document.getElementById('closeCart');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                carretoElement.style.display = 'none';
            });
        }

        return;
    }

    const items = Object.entries(carreto);
    console.log(items);

    // Calcular subtotal sumando precio × cantidad de cada artículo
    // const items = Object.values(carreto);
    // console.log(items)
    let subtotal = 0;
    items.forEach(([key, item]) => {
        const precio = parseFloat(item.precio) || 0;
        const cantidad = parseInt(item.cantidad) || 1;
        subtotal += precio * cantidad;
    });

    // Calcular IVA (10%) y total
    const iva = subtotal * 0.10;
    const total = subtotal + iva;

    // Generar HTML para cada artículo del carrito

    const itemsHTML = items.map(([key, item]) => {
        const precio = parseFloat(item.precio) || 0;
        const cantidad = parseInt(item.cantidad) || 1;
        const totalItem = precio * cantidad;
        const descripcion = item.descripcion || '';

        return `
        <div class="item-card">
            <a onclick="eliminarArticle('${key}')">x</a>
            <div class="row" style="align-items: center;">
                <div class="col-8">
                    <div class="item-nombre">${item.nombre}</div>
                    <div class="item-descripcion">${descripcion}</div>
                </div>
                <div class="col-4 precio-info">
                    <div class="cantidad-precio">${cantidad} × ${precio.toFixed(2)}€</div>
                    <div class="total-item">${totalItem.toFixed(2)}€</div>
                </div>
            </div>
        </div>
    `;
    }).join('');

    // Construir HTML completo del carrito con artículos y resumen
    const contenidoHTML = `
    <div class="cart-header">
        <h4 style="margin: 0;">Mi Carrito</h4>
    </div>
    <div class="cart-content">
        <div class="cart-items">
            ${itemsHTML}
        </div>
        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${subtotal.toFixed(2)}€</span>
            </div>
            <div class="summary-row">
                <span>IVA (10%):</span>
                <span>${iva.toFixed(2)}€</span>
            </div>
            <div class="summary-row summary-total">
                <span>TOTAL:</span>
                <span>${total.toFixed(2)}€</span>
            </div>
            <a href="/carrito" class="btn-comprar">
                Proceder al Pago
            </a>
        </div>
    </div>
`;

    carretoElement.innerHTML = contenidoHTML;

    const closeBtn = document.getElementById('closeCart');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            carretoElement.style.display = 'none';
        });
    }
}


function añadirAlCarrito(articleId, num = 0) {
    // A partir de data amb el id del fitxer i la quantitat es manda a la funcio afegir article
    if (num != 0) {
        const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
        const cantidad = parseInt(articleDiv.querySelector('.cantidad-display').textContent);
        if (cantidad > 0) {
            afegirArticle(articleId, cantidad);
        } else {
            alert('Selecciona una cantidad mayor a 0');
        }
    }
    if (num == 0) {
        const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
        const cantidad = parseInt(articleDiv.querySelector('.cantidad-display').textContent);
        if (cantidad > 0) {
            afegirArticle(articleId, cantidad);
        } else {
            alert('Selecciona una cantidad mayor a 0');
        }
    }
}



document.addEventListener('DOMContentLoaded', function () {
    // Cargar el carrito al iniciar la pagina
    carregarCarreto(function (carretoRecibido) {
        carreto = carretoRecibido;
        actualitzarBadgeCarreto(carreto);
    });

    // Event listener globales al cargar la pagina
    // Sumar numero
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const articleId = this.getAttribute('data-article');
            const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
            const cantidadSpan = articleDiv.querySelector('.cantidad-display');
            const totalSpan = articleDiv.querySelector('producto-total');
            const precio = parseFloat(articleDiv.getAttribute('precio-valor'));

            // Incrementar cantidad y actualizar precio total
            let cantidad = parseInt(cantidadSpan.textContent);
            cantidad++;
            cantidadSpan.textContent = cantidad;

            const total = (precio * cantidad).toFixed(2);
            totalSpan.textContent = total;
        });
    });

    // Restar numero
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const articleId = this.getAttribute('data-article');
            const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
            const cantidadSpan = articleDiv.querySelector('.cantidad-display');
            const totalSpan = articleDiv.querySelector('.producto-total');
            const precio = parseFloat(articleDiv.getAttribute('precio-valor'));

            // Decrementar cantidad si es mayor que 0 y actualizar precio total
            let cantidad = parseInt(cantidadSpan.textContent);
            if (cantidad > 0) {
                cantidad--;
                cantidadSpan.textContent = cantidad;

                const total = (precio * cantidad).toFixed(2);
                totalSpan.textContent = total;
            }
        });
    });
});