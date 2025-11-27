let carreto = null;

function netejarCarreto() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/netejar-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
                carregarCarreto(function (carretoRecibido) {
                    carreto = carretoRecibido;
                    console.log("Carreto limpiado:", carreto);
                });
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };
    xhr.send("msg=Hola desde JavaScript");
}

function afegirArticle(id, quantitat) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/afegir-article-carreto", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText);
                carregarCarreto(function (carretoRecibido) {
                    carreto = carretoRecibido;
                    console.log("Carreto actualizado:", carreto);
                });
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    };
    let data = [id, quantitat];
    let json = JSON.stringify(data);
    xhr.send("data=" + json);
}

function carregarCarreto(callback) {
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
    const carretoElement = document.getElementById('carreto');

    if (!carretoElement) {
        console.error('No se encontró el elemento con id "carreto"');
        return;
    }

    // Verificar si el carreto es null, undefined o está vacío
    if (!carreto || Object.keys(carreto).length === 0) {
        carretoElement.innerHTML = `
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
        </div>
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
                <button class="btn-comprar" disabled style="opacity: 0.5; cursor: not-allowed;">
                    Proceder al Pago
                </button>
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

    const items = Object.values(carreto);

    let subtotal = 0;
    items.forEach(item => {
        const precio = parseFloat(item.precio) || 0;
        const cantidad = parseInt(item.cantidad) || 1;
        subtotal += precio * cantidad;
    });

    const iva = subtotal * 0.10;
    const total = subtotal + iva;

    const itemsHTML = items.map(item => {
        const precio = parseFloat(item.precio) || 0;
        const cantidad = parseInt(item.cantidad) || 1;
        const totalItem = precio * cantidad;
        const descripcion = item.descripcion || '';

        return `
        <div class="item-card">
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

    const contenidoHTML = `
    <div class="cart-header">
        <h4 style="margin: 0;">🛒 Mi Carrito</h4>
        <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">×</button>
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
            <button class="btn-comprar">
                Proceder al Pago
            </button>
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



function añadirAlCarrito(articleId) {
    const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
    const cantidad = parseInt(articleDiv.querySelector('.cantidad').textContent);

    if (cantidad > 0) {
        afegirArticle(articleId, cantidad);
        // Opcional: resetear cantidad después de añadir
        // articleDiv.querySelector('.cantidad').textContent = '0';
        // articleDiv.querySelector('.total').textContent = '0.00';
    } else {
        alert('Selecciona una cantidad mayor a 0');
    }
}



document.addEventListener('DOMContentLoaded', function () {

    // 1. Cargar el carrito al iniciar
    carregarCarreto(function (carretoRecibido) {
        carreto = carretoRecibido;
        console.log("Carreto inicial cargado:", carreto);
    });

    // 2. Manejadores para botones + (aumentar cantidad)
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const articleId = this.getAttribute('data-article');
            const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
            const cantidadSpan = articleDiv.querySelector('.cantidad');
            const totalSpan = articleDiv.querySelector('.total');
            const precio = parseFloat(articleDiv.getAttribute('data-precio'));

            let cantidad = parseInt(cantidadSpan.textContent);
            cantidad++;
            cantidadSpan.textContent = cantidad;

            const total = (precio * cantidad).toFixed(2);
            totalSpan.textContent = total;
        });
    });

    // 3. Manejadores para botones - (disminuir cantidad)
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const articleId = this.getAttribute('data-article');
            const articleDiv = document.querySelector(`[data-file="${articleId}"]`);
            const cantidadSpan = articleDiv.querySelector('.cantidad');
            const totalSpan = articleDiv.querySelector('.total');
            const precio = parseFloat(articleDiv.getAttribute('data-precio'));

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