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
  <?php session_start(); ?>
  <header>
    <nav id="menu">
      <ul>
        <!-- <li><a href="">Inicio</a></!-->
        <li><a href="menuCliente.php">Mi perfil</a></li>
        <li><a href="index.php" onclick="return cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>
  <div id="contenedor">
    <h1 id="bienvenida">Bienvenid@ &nbsp;<?php echo $_SESSION["datos"]["nombre"] . ' ' . $_SESSION["datos"]["apellidos"]; ?></h1>

    <aside id="carrito">
      <?php
      $total = 0;
      if ($_SESSION['compra'] == true) {
      ?>
        <h3>CARRITO</h3>
        <form action="control.php" method="POST">
          <table>
            <?php
            foreach ($_SESSION["carrito"] as $dato) {
              if ($dato[0] > 0) {
            ?>
                <tr>
                  <td class="cantidad"><?php echo $dato[0] ?></td>
                  <td class="cesta"><?php echo  $dato[2] ?></td>
                  <td class="precio"><?php echo ($dato[1] * $dato[0]) . "€" ?></td>
                  <td><button type='submit' name='quitar' class='boton' id='quitar' value=<?php echo $dato[3] ?>>X</button></td>
                </tr>
            <?php
              }
              $total += $dato[1] * $dato[0];
            }
            if ($total == 0) {
              $_SESSION['compra'] = false;
              header('Location: productos.php');
            } else {
              $_SESSION['total'] = $total;
            }
            ?>
          </table>
          <h4 id="total"><?php echo $_SESSION['total'] ?>€ TOTAL</h4>
          <input type='submit' name='fincompra' onclick='return confirmarCompra()' id='compra' class='boton' value="FINALIZAR COMPRA">
        </form>
      <?php } else { ?>
        <img src="https://images.milled.com/2019-02-08/VTf3v0UAh6ccaXW9/nuThXvqqkZOr.gif">
      <?php } ?>
    </aside>

    <section id="contenido">
      <form action="control.php" method="POST" id="catalogo">
        <?php
        $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
        if (mysqli_connect_errno()) {
          printf("Conexión fallida: %s\n", mysqli_connect_error());
          exit();
        } else {

          $sql = "SELECT idArticulo, imagen, descripcion, caracteristicas, precio, stock from articulos;";

          $resultado = mysqli_query($conexion, $sql);

          while ($registro = mysqli_fetch_array($resultado)) {
        ?>
            <div class='producto' align='center'>
              <img src="<?php echo $registro[1] ?>" alt="<?php echo $registro[2] ?>">

              <h3><b><?php echo $registro[2] ?></b></h3>
              <p><?php echo $registro[3] ?> </p>
              <p>PRECIO: <?php echo $registro[4] ?>€</p>
              <?php
              if ($_SESSION["carrito"][$registro[0]][0] >= $registro[5]) {
              ?>
                <p class="stock"><b>SIN STOCK</b></p>
              <?php
              } else {
              ?>
                <button type="submit" name="añadir" class="boton" value="<?php echo $registro[0] ?>"><b>Añadir al carrito</b></button>
              <?php } ?>
            </div>
        <?php
          }
        }
        ?>
      </form>
    </section>

  </div>

  <footer>
    <div id="email">
      <a href="mailto:contacto@vemmolinas.dev">contacto@vemmolinas.dev</a></p>
    </div>
    <div id="aviso">
      <p>Desarrollado por Víctor Emmanuel Molinas &copy;
        <?= date('Y') ?>
    </div>
  </footer>


</body>

</html>