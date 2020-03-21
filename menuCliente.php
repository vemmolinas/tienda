<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CarritoBD - Víctor Emmanuel Molinas</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
  <script type="text/javascript" src="js/funciones.js"></script>
  <?php session_start() ?>
  <header>
    <a href="productos.php" style="float: left; margin-left:8%; margin-top: 1%;width: 190px; height: 70%;"></a>
    <nav id="menu">
      <ul>
        <!-- <li><a href="">Inicio</a></li> -->
        <li><a href="productos.php">Tienda</a></li>
        <li><a href="index.php" onclick="return cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>


  <div id="contenedor">
    <h1 id="bienvenida">Bienvenid@ <?php echo $_SESSION["datos"]["nombre"]; ?></h1>
    <div id="menuUser">
      <form action="" method="POST">
        <input type="submit" name="datos" class="boton" <?php if (isset($_POST['datos'])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="MIS DATOS">
        <input type="submit" name="pedido" class="boton" <?php if (isset($_POST['pedido'])  || isset($_POST["buscarPed"])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="BUSCAR PEDIDO">
        <input type="submit" name="pedidos" class="boton" <?php if (isset($_POST['pedidos']) || isset($_POST["detalle"])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="TODOS MIS PEDIDOS">
      </form>
    </div>
    <div id="area">
      <?php
      if (isset($_POST["datos"])) {
        $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
        if (mysqli_connect_errno()) {
          printf("Conexión fallida: %s\n", mysqli_connect_error());
          exit();
        } else {
          $sql = "SELECT idUsuario, usuario, nombre, apellidos, fechaNac, correo from usuarios where idUsuario=" . $_SESSION['datos']['idUsuario'] . ";";
          $resultado = mysqli_query($conexion, $sql);
          while ($registro = mysqli_fetch_row($resultado)) {
      ?>
            <table id="stock" class="datosUser">
              <tr>
                <td colspan="5">
                  <h2>DATOS REGISTRADOS DEL USUARIO Nº <?php echo $registro[0] ?></h2>
                </td>
              </tr>
              <tr>
                <th>USUARIO</th>
                <td><?php echo $registro[1] ?> </td>
                <td style="text-align: center;" rowspan="5"><img src="https://cdn0.iconfinder.com/data/icons/user-interface-vol-3-12/66/68-512.png" alt=""></td>
              </tr>
              <tr>
                <th>NOMBRE</th>
                <td><?php echo  $registro[2] ?></td>
              </tr>
              <tr>
                <th>APELLIDOS</th>
                <td><?php echo  $registro[3] ?></td>
              </tr>
              <tr>
                <th>FECHA NAC.</th>
                <td><?php echo date("d/m/Y", strtotime($registro[4])) ?></td>
              </tr>
              <tr>
                <th>E-MAIL</th>
                <td><?php echo  $registro[5] ?></td>
              </tr>
            <?php
          }
            ?>
            </table>
          <?php
          mysqli_close($conexion);
        }
      } else if (isset($_POST["pedido"])) {
        $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
        if (mysqli_connect_errno()) {
          printf("Conexión fallida: %s\n", mysqli_connect_error());
          exit();
        } else {
          ?>
            <div>
              <form action="" id="buscar" method="POST">
                <h4><label for="fechaini">Desde</label><br></h4>
                <input type="date" name="fechaini" class="form" id="fechaini" onblur="fechaMin()" value="<?php if (isset($_post["buscar"])) echo $_POST["fechaini"] ?>" min="" max="<?= date('Y-m-d') ?>" required> <br><br>
                <h4><label for="fechafin">Hasta</label><br></h4>
                <input type="date" name="fechafin" class="form" id="fechafin" value="<?php if (isset($_post["buscar"])) echo $_POST["fechafin"] ?>" min="" max="<?= date('Y-m-d') ?>" required> <br>
                <br><br>
                <input type="submit" name="buscarPed" id="buscarPed" class="boton" value="BUSCAR">
              </form>
            </div>
            <?php
          }
        } else if (isset($_POST["buscarPed"])) {
          $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT c.fecha, c.tiquet, sum(c.cantidad * a.precio)
                  from usuarios u
                  inner join compras c on u.idusuario = c.idusuario
                  inner join articulos a on c.idarticulo = a.idArticulo
                  WHERE u.idUsuario=" . $_SESSION['datos']['idUsuario'] . " AND c.fecha BETWEEN '" . $_POST['fechaini'] . "' AND '" . $_POST['fechafin'] . "'
                  group by c.tiquet;";
            // var_dump($sql);
            $resultado = mysqli_query($conexion, $sql);
            $total = mysqli_num_rows($resultado);
            verCompras($total, $resultado, $_POST['fechaini'], $_POST['fechafin']);
            mysqli_close($conexion);
          }
        } else if (isset($_POST["pedidos"])) {
          $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT c.fecha, c.tiquet, sum(c.cantidad * a.precio)
                  from usuarios u
                  inner join compras c on u.idusuario = c.idusuario
                  inner join articulos a on c.idarticulo = a.idArticulo
                  WHERE u.idUsuario =" . $_SESSION['datos']['idUsuario'] . "
                  group by c.tiquet;";
            $resultado = mysqli_query($conexion, $sql);
            $total = mysqli_num_rows($resultado);
            verCompras($total, $resultado, "histo", null);
            mysqli_close($conexion);
          }
        } else if (isset($_POST["detalle"])) {
          $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
          $total = 0;
          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT DISTINCT u.nombre, u.apellidos, c.fecha from usuarios u inner join compras c on u.idusuario = c.idusuario where c.tiquet =" . $_POST['detalle'];
            $resultado = mysqli_query($conexion, $sql);
            $total = 0;
            while ($registro = mysqli_fetch_row($resultado)) {
            ?>
              <table id="tabla">
                <tr>
                  <td colspan="6">
                    <h2>DETALLE DEL TIQUET <?php echo $_POST['detalle'] ?> - FECHA DE COMPRA: <?php echo date("d/m/Y", strtotime($registro[2])) ?></h2>
                  </td>
                </tr>
                <tr>
                  <th>IMÁGEN</th>
                  <th>ARTICULO</th>
                  <th>DESCRIPCIÓN</th>
                  <th>CANTIDAD</th>
                  <th>PRECIO</th>
                </tr>
              <?php
            }
            $sql2 = "SELECT DISTINCT c.fecha, a.descripcion, a.caracteristicas, c.cantidad, a.precio, a.imagen
                  from usuarios u
                  inner join compras c on u.idusuario = c.idusuario
                  inner join articulos a on c.idarticulo = a.idArticulo
                  where c.tiquet =" . $_POST['detalle'];
            $resultado = mysqli_query($conexion, $sql2);
            while ($registro = mysqli_fetch_array($resultado)) {
              ?>
                <tr>
                  <td><img style="width:50px;height:50px;" src="<?php echo $registro[5] ?>" alt="<?php echo $registro[1] ?>"></td>
                  <td><?php echo $registro[1] ?></td>
                  <td><?php echo $registro[2] ?></td>
                  <td><?php echo $registro[3] ?></td>
                  <td><?php echo $registro[4] ?>€</td>
                </tr>
              <?php
              $total += $registro[3] * $registro[4];
            }
              ?>
              <td colspan="6">
                <h3 style="text-align:right;">TOTAL DE COMPRA: <?php echo $total ?> €</h3>
              </td>
              </table>
            <?php
            mysqli_close($conexion);
          }
        } else { ?>
            <br><br><br><br>
            <div>
              <h2>BIENVENIDO A TU PERFIL DE CLIENTE</h2>
              <br><br><br>
              <h3>SELECCIONA UNA OPCIÓN PARA INICIAR UNA TAREA</h3>
            </div>
          <?php
        }
          ?>
    </div>
  </div>
  <footer>
    <div id="email">
      <a href="mailto:contacto@vemmolinas.dev">contacto@vemmolinas.dev</a></div>
    </div>
    <div id="aviso">
      <p>Desarrollado por Víctor Emmanuel Molinas &copy;
        <?= date('Y') ?>
    </div>
  </footer>
  <?php
  function verCompras($total, $resultado, $fecha1, $fecha2)
  {
    if ($total != 0) {
  ?>
      <form action="" method="POST">
        <table id="tabla">
          <tr>
            <td colspan="6">
              <?php
              if ($fecha2 == null) {
              ?>
                <h2>COMPRAS REGISTRADAS HASTA A DÍA <?= date('d-m-Y') ?></h2>
              <?php
              } else {
              ?>
                <h2>COMPRAS DESDE <?php date("d/m/Y", strtotime($fecha1)) ?> HASTA <?php date("d/m/Y", strtotime($fecha2)) ?></h2>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <th>FECHA</th>
            <th>TIQUET</th>
            <th>TOTAL</th>
            <th>DETALLE</th>
          </tr>
          <?php
          $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
          while ($registro = mysqli_fetch_row($resultado)) {
          ?>
            <tr>
              <td><?php echo date("d/m/Y", strtotime($registro[0])) ?></td>
              <td><?php echo  $registro[1] ?></td>
              <td><?php echo $registro[2] ?>€</td>
              <td><button type='submit' name='detalle' class='boton' value='<?php echo $registro[1] ?>'>VER</button></td>
            </tr>
          <?php
          }
          ?>
        </table>
      </form>
      <?php
    } else {
      if ($fecha2 == null) {
      ?>
        <h2>NO EXISTEN COMPRAS REGISTRADAS AL DÍA <?= date('d-m-Y') ?></h2>
      <?php
      } else {
      ?>
        <h2>NO EXISTEN COMPRAS REGISTRADAS <br> ENTRE LOS DÍAS <?= date("d/m/Y", strtotime($fecha1)) ?> Y <?= date("d/m/Y", strtotime($fecha2)) ?></h2>
  <?php }
    }
  }

  ?>
</body>

</html>