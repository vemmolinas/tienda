<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CarritoBD - Víctor Emmanuel Molinas</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
  <script type="text/javascript" src="js/funciones.js"></script>
  <?php session_start() ?>
  <header>
    <a href="productos.php" style="float: left; margin-left:8%; margin-top: 1%;width: 190px; height: 70%;"></a>
    <nav id="menu">
      <ul>
        <li><a href="productos.php">Tienda</a></li>
        <li><a href="menuCliente.php">Mi perfil</a></li>
        <li><a href="index.php" onclick="return cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>

  <div id="contenedor">
    <h1 id="bienvenida">FELICIDADES &nbsp;<?php echo $_SESSION["datos"]["nombre"]; ?>!!!</h1>

    <section id="contenidoFinal">

      <img alt=" envio" id="preparacionFoto" src="https://pro2-bar-s3-cdn-cf6.myportfolio.com/111b8e4c2a0aed4177442ca28505c75f/09d2a884-df6e-4c53-963c-4079acbf9077_rw_1920.gif">
    </section>

    <aside id="compraFinal">
      <h3>TU PEDIDO <?php echo $_SESSION["PEDIDO"]; ?><br>YA ESTÁ EN CAMINO</h3>
      <table>
        <tr>
          <th colspan="2">CANTIDAD</th>
          <th>ARTÍCULO</th>
          <th>PRECIO</th>
        </tr>
        <?php
        foreach ($_SESSION["carrito"] as $dato) {
          if ($dato[0] > 0) {
        ?>
            <tr>
              <td class="cantidad"><?php echo $dato[0] ?> X</td>
              <td class="cantidad"><img src="<?php echo $dato[4] ?>"></td>
              <td class="cesta"><?php echo  $dato[2] ?></td>
              <td class="precio"><?php echo ($dato[1] * $dato[0]) . "€" ?></td>
            </tr>
        <?php }
        } ?>
      </table>
      <h4>TOTAL <?php echo $_SESSION['total'] ?>€</h4>
    </aside>
  </div>

  <?php
  $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
  if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
  } else {
    $_SESSION['total'] = 0;
    $_SESSION['compra'] = false;
    $sql1 = "SELECT idArticulo, precio, descripcion, imagen from articulos;";
    $resultado = mysqli_query($conexion, $sql1);
    while ($registro = mysqli_fetch_row($resultado)) {
      $_SESSION["carrito"][$registro[0]] = [0, $registro[1], $registro[2], $registro[0], $registro[3]];
    }
    mysqli_close($conexion);
  }
  ?>

  <footer>
    <div id="email">
      <a href="mailto:contacto@vemmolinas.dev">contacto@vemmolinas.dev</a></div>
    </div>
    <div id="aviso">
      <p>Desarrollado por Víctor Emmanuel Molinas &copy;
        <?= date('Y') ?>
    </div>
  </footer>

</body>

</html>