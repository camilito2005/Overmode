<!-- ===================== -->
<!-- CARRITO DE COMPRAS -->
<!-- ===================== -->
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Overmode - Carrito</title>
  <style>
    .cart {
      padding: 2rem 1rem;
      max-width: 1200px;
      margin: auto;
    }
    .cart table {
      width: 100%;
      border-collapse: collapse;
    }
    .cart th, .cart td {
      border-bottom: 1px solid #ddd;
      padding: 1rem;
      text-align: left;
    }
    .checkout-btn {
      background: black;
      color: white;
      border: none;
      padding: 1rem 2rem;
      cursor: pointer;
      border-radius: 0.3rem;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
  <header>
    <div><strong>OVERMODE</strong></div>
    <nav>
      <a href="#">Inicio</a>
      <a href="#">Catálogo</a>
      <a href="#">Carrito</a>
    </nav>
  </header>

  <section class="cart">
    <h2>Shopping Cart</h2>
    <table>
      <thead>
        <tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>Beige Sweater</td>
          <td>$49.00</td>
          <td>1</td>
          <td>$49.00</td>
        </tr>
        <tr>
          <td>Dark Jeans</td>
          <td>$69.00</td>
          <td>1</td>
          <td>$69.00</td>
        </tr>
      </tbody>
    </table>
    <p><strong>Subtotal:</strong> $118.00</p>
    <button class="checkout-btn">Proceder al pago</button>
  </section>
</body>
</html>
