let carreto = null; function netejarCarreto() { let e = new XMLHttpRequest; e.open("POST", "/netejar-carreto", !0), e.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), e.onreadystatechange = function () { 4 === e.readyState && (200 === e.status ? (console.log("Respuesta del servidor:", e.responseText), carregarCarreto(function (e) { carreto = e, console.log("Carreto limpiado:", carreto) })) : console.error("Error en la petici\xf3n:", e.status)) }, e.send("msg=Hola desde JavaScript") } function afegirArticle(e, t) { let a = new XMLHttpRequest; a.open("POST", "/afegir-article-carreto", !0), a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), a.onreadystatechange = function () { 4 === a.readyState && (200 === a.status ? (console.log("Respuesta del servidor:", a.responseText), carregarCarreto(function (e) { carreto = e, console.log("Carreto actualizado:", carreto) })) : console.error("Error en la petici\xf3n:", a.status)) }; let r = JSON.stringify([e, t]); a.send("data=" + r) } function carregarCarreto(e) { let t = new XMLHttpRequest; t.open("POST", "/carregar-carreto", !0), t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), t.onreadystatechange = function () { if (4 === t.readyState) { if (200 === t.status) { let a = JSON.parse(t.responseText), r = 1 === a.res ? a.carreto : null; actualitzarLlistaCarreto(r), e && e(r) } else e && e(null) } }, t.send() } function crearTicket(e) { let t = new XMLHttpRequest; t.open("POST", "/crear-ticket", !0), t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), t.onreadystatechange = function () { if (4 === t.readyState) { if (200 === t.status) { let a = JSON.parse(t.responseText); e && e(1 === a.res ? a.ticket : null) } else e && e(null) } }, t.send() } function actualitzarLlistaCarreto(e) {
    let t = document.getElementById("carreto"); if (!t) { console.error('No se encontr\xf3 el elemento con id "carreto"'); return } if (!e || 0 === Object.keys(e).length) {
        t.innerHTML = `
        <div class="cart-header">
            <h4 style="margin: 0;">🛒 Mi Carrito</h4>
            <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">\xd7</button>
        </div>
        <div class="cart-content">
            <div class="cart-items">
                <div style="text-align: center; padding: 40px 20px; color: #999;">
                    <p>Tu carrito est\xe1 vac\xedo</p>
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
    `; let a = document.getElementById("closeCart"); a && a.addEventListener("click", function () { t.style.display = "none" }); return
    } let r = Object.values(e), n = 0; r.forEach(e => { let t = parseFloat(e.precio) || 0, a = parseInt(e.cantidad) || 1; n += t * a }); let o = .1 * n, i = n + o, s = r.map(e => {
        let t = parseFloat(e.precio) || 0, a = parseInt(e.cantidad) || 1, r = e.descripcion || ""; return `
        <div class="item-card">
            <div class="row" style="align-items: center;">
                <div class="col-8">
                    <div class="item-nombre">${e.nombre}</div>
                    <div class="item-descripcion">${r}</div>
                </div>
                <div class="col-4 precio-info">
                    <div class="cantidad-precio">${a} \xd7 ${t.toFixed(2)}€</div>
                    <div class="total-item">${(t * a).toFixed(2)}€</div>
                </div>
            </div>
        </div>
    `}).join(""), c = `
    <div class="cart-header">
        <h4 style="margin: 0;">🛒 Mi Carrito</h4>
        <button class="cart-close-btn" id="closeCart" aria-label="Cerrar carrito">\xd7</button>
    </div>
    <div class="cart-content">
        <div class="cart-items">
            ${s}
        </div>
        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>${n.toFixed(2)}€</span>
            </div>
            <div class="summary-row">
                <span>IVA (10%):</span>
                <span>${o.toFixed(2)}€</span>
            </div>
            <div class="summary-row summary-total">
                <span>TOTAL:</span>
                <span>${i.toFixed(2)}€</span>
            </div>
            <button class="btn-comprar">
                Proceder al Pago
            </button>
        </div>
    </div>
`; t.innerHTML = c; let l = document.getElementById("closeCart"); l && l.addEventListener("click", function () { t.style.display = "none" })
} function añadirAlCarrito(e) { let t = document.querySelector(`[data-file="${e}"]`), a = parseInt(t.querySelector(".cantidad").textContent); a > 0 ? afegirArticle(e, a) : alert("Selecciona una cantidad mayor a 0") } document.addEventListener("DOMContentLoaded", function () { carregarCarreto(function (e) { carreto = e, console.log("Carreto inicial cargado:", carreto) }), document.querySelectorAll(".btn-plus").forEach(e => { e.addEventListener("click", function (e) { e.stopPropagation(); let t = this.getAttribute("data-article"), a = document.querySelector(`[data-file="${t}"]`), r = a.querySelector(".cantidad"), n = a.querySelector(".total"), o = parseFloat(a.getAttribute("data-precio")), i = parseInt(r.textContent); i++, r.textContent = i; let s = (o * i).toFixed(2); n.textContent = s }) }), document.querySelectorAll(".btn-minus").forEach(e => { e.addEventListener("click", function (e) { e.stopPropagation(); let t = this.getAttribute("data-article"), a = document.querySelector(`[data-file="${t}"]`), r = a.querySelector(".cantidad"), n = a.querySelector(".total"), o = parseFloat(a.getAttribute("data-precio")), i = parseInt(r.textContent); if (i > 0) { i--, r.textContent = i; let s = (o * i).toFixed(2); n.textContent = s } }) }) });