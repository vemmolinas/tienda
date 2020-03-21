<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CarritoBD - Víctor Emmanuel Molinas</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/menu.css" type="text/css">
  <link rel="stylesheet" href="css/ingreso.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
  <script type="text/javascript" src="js/funciones.js"></script>
  <?php session_start() ?>
  <header>
    <nav id="menu">
      <ul>
        <!-- <li><a href="">Inicio</a></li> -->
        <!-- <li><a href="">Mi perfil</a></li> -->
        <li><a href="index.php" onclick="return cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>


  <div id="contenedor">
    <h1 id="bienvenida">Bienvenid@ <?php echo $_SESSION["datos"]["nombre"]; ?></h1>

    <?php if (isset($_POST['nuevoAdmin'])) { ?>

      <div id="registro">
        <h2 id="bienvenida" style="font-size:20px;">REGISTRO DE NUEVO ADMINISTRADOR</h1>
          <form action="" method="POST" onsubmit="return altaUsu()">
            <div id="datos1">
              <h4><label for="nombre">Nombre</label><br /></h4>
              <input type="text" name="nombre" id="nombre" class="form" value="<?php if (isset($_POST['alta'])) echo $_POST['user'] ?>" required>
              <h4><label for="apellido">Apellido</label><br /></h4>
              <input type="text" name="apellido" id="apellido" class="form" value="<?php if (isset($_POST['alta'])) echo $_POST['user'] ?>" required>
              <h4><label for="fechanac">Fecha de nacimiento</label><br></h4>
              <input type="date" name="fechanac" id="fechanac" class="form" value="<?php if (isset($_post["alta"])) echo $_POST["fechanac"] ?>" max="<?php echo $fecha ?>" required>
              <h4><label for="email">E-Mail</label><br /></h4>
              <input type="email" name="email" class="form" value="<?php if (isset($_POST['alta'])) echo $_POST['user'] ?>" required>
            </div>
            <div id="datos2">
              <h4><label for="usu">Usuario</label><br /></h4>
              <input type="text" name="usu" class="form" value="<?php if (isset($_POST["alta"])) echo $_POST["pass"] ?>" required>
              <h4><label for="pass">Contraseña</label><br /></h4>
              <input type="password" name="pass" id="pass" class="form" minlength="6" value="<?php if (isset($_POST["alta"])) echo $_POST["pass"] ?>" required>
              <h4><label for="pass2">Repetir contraseña</label><br /></h4>
              <input type="password" name="pass2" id="pass2" class="form" minlength="6" value="<?php if (isset($_POST["alta"])) echo $_POST["pass2"] ?>" required><br>
              <input type="submit" name="alta" id="alta" class="boton" value="REGISTRAR">
            </div>
          </form>
          <h4><span class="error"><?php if (isset($_POST["alta"]))  echo $error ?></span></h4>
      </div>
    <?php } else { ?>

      <div id="menuAdmin">
        <form action="" method="POST">
          <input type="submit" name="stockDisp" class="boton" <?php if (isset($_POST['stockDisp'])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="STOCK DISPONIBLE">
          <input type="submit" name="nuevoArt" class="boton" <?php if (isset($_POST['nuevoArt'])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="NUEVO ARTÍCULO">
          <input type="submit" name="historial" class="boton" <?php if (isset($_POST['historial']) || isset($_POST["detalle"])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="HISTORIAL DE VENTAS">
          <input type="submit" name="usuarios" class="boton" <?php if (isset($_POST['usuarios'])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="LISTA DE USUARIOS">
          <input type="submit" name="nuevoAdmin" class="boton" <?php if (isset($_POST['nuevoAdmin'])) echo 'style="font-weight:bold; background-color:#BF1414; box-shadow:0px 0px 5px black;"' ?> value="NUEVO ADMINISTRADOR">
        </form>
      </div>
      <div id="area">
        <?php
        if (isset($_POST['nuevoArt'])) {
        ?>
          <form action="" method="POST" id="altaArt">
            <label for="desc">DESCRIPCIÓN</label>
            <input type="text" required name="desc" id="desc"><br>
            <label for="imagen">IMÁGEN (URL)</label>
            <input type="text" required name="imagen" id="imagen"><br>
            <label for="totalStock">STOCK</label>
            <input type="number" min="1" required name="totalStock" id="totalStock">
            <label for="precio">PRECIO</label>
            <input type="number" min="1" required name="precio" id="precio"><br>
            <label for="caract" id="caract">CARACTERÍSTICAS</label><br>
            <textarea name="caract" required rows="3" cols="40"></textarea><br>
            <input type="submit" name="confirmarAlta" class="boton" value="CONFIRMAR">
          </form>
          <?php
        } else if (isset($_POST["stockDisp"])) {
          $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT idArticulo, stock, precio,descripcion, caracteristicas from articulos;";

            $resultado = mysqli_query($conexion, $sql);
            $total = mysqli_num_rows($resultado);

            if ($total != 0) {
          ?>
              <table id="stock">
                <tr>
                  <td colspan="5">
                    <h2>STOCK REGISTRADO AL DÍA <?= date('d-m-Y') ?></h2>
                  </td>
                </tr>
                <tr>
                  <th>CÓDIGO</th>
                  <th>UNIDADES</th>
                  <th>PRECIO</th>
                  <th>DESCRIPCIÓN</th>
                  <th>CARACTERÍSTICAS</th>
                </tr>
                <div></div>
                <?php
                $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
                while ($registro = mysqli_fetch_row($resultado)) {
                ?>
                  <tr>
                    <td><?php echo $registro[0] ?></td>
                    <td><?php echo $registro[1] ?> </td>
                    <td><?php echo  $registro[2] ?>€</td>
                    <td><?php echo  $registro[3] ?></td>
                    <td><?php echo  $registro[4] ?></td>
                  </tr>
                <?php
                }
                ?>
              </table>
            <?php
            } else {
              echo "<h2>NO EXÍSTEN   ARTÍCULOS EN STOCK</h2>";
            }
            mysqli_close($conexion);
          }
        } else if (isset($_POST["usuarios"])) {
          $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT usuario, nombre, apellidos, fechaNac, correo from usuarios where rol!='Administrador';";

            $resultado = mysqli_query($conexion, $sql);
            $total = mysqli_num_rows($resultado);

            if ($total != 0) {
            ?>
              <table id="tabla">
                <tr>
                  <td colspan="5">
                    <h2>USUARIOS REGISTRADOS AL DÍA <?= date('d-m-Y') ?></h2>
                  </td>
                </tr>
                <tr>
                  <th>USUARIO</th>
                  <th>NOMBRE</th>
                  <th>APELLIDOS</th>
                  <th>FECHA NAC.</th>
                  <th>CORREO</th>
                </tr>
                <?php
                while ($registro = mysqli_fetch_row($resultado)) {
                ?>
                  <tr>
                    <td><?php echo $registro[0] ?> </td>
                    <td><?php echo  $registro[1] ?></td>
                    <td><?php echo  $registro[2] ?></td>
                    <td><?php echo date("d/m/Y", strtotime($registro[3])) ?></td>
                    <td><?php echo  $registro[4] ?></td>
                  </tr>
                <?php
                }
                ?>
              </table>
            <?php
            } else {
              echo "<h2>NO EXÍSTEN ARTÍCULOS EN STOCK</h2>";
            }
            mysqli_close($conexion);
          }
        } else if (isset($_POST["historial"])) {
          $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');

          if (mysqli_connect_errno()) {
            printf("Conexión fallida: %s\n", mysqli_connect_error());
            exit();
          } else {
            $sql = "SELECT c.tiquet, c.fecha, u.usuario, u.nombre, u.apellidos,
                  sum(c.cantidad * a.precio)
                  from usuarios u
                  inner join compras c on u.idusuario = c.idusuario
                  inner join articulos a on c.idarticulo = a.idArticulo
                  group by c.tiquet";

            // var_dump($sql);

            $resultado = mysqli_query($conexion, $sql);
            $total = mysqli_num_rows($resultado);

            if ($total != 0) {
            ?>
              <div id="coso">
                <form action="" method="POST">
                  <table id="tabla">
                    <tr>
                      <td colspan="6">
                        <h2>VENTAS REGISTRADAS AL DÍA <?= date('d-m-Y') ?></h2>
                      </td>
                    </tr>
                    <tr>
                      <th>TIQUET</th>
                      <th>FECHA</th>
                      <th>USUARIO</th>
                      <th>NOMBRE</th>
                      <th>TOTAL</th>
                      <th>DETALLE</th>
                    </tr>
                    <?php
                    $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
                    while ($registro = mysqli_fetch_row($resultado)) {
                    ?>
                      <tr>
                        <td><?php echo $registro[0] ?> </td>
                        <td><?php echo date("d/m/Y", strtotime($registro[1])) ?></td>
                        <td><?php echo  $registro[2] ?></td>
                        <td><?php echo  $registro[3] . " " . $registro[4] ?></td>
                        <td><?php echo $registro[5] ?>€</td>
                        <td><button type='submit' name='detalle' class='boton' value='<?php echo $registro[0] ?>'>VER</button></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </table>
                </form>
              </div>
            <?php
            } else {
              echo "<h2>NO EXÍSTEN VENTAS REGISTRADAS</h2>";
            }
            mysqli_close($conexion);
          }
        } else if (isset($_POST["detalle"])) {
          $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
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
                  <h2 style="text-align:left;margin: -20px 0px 20px 0px;">USUARIO: <?php echo $registro[0] . " " . $registro[1] ?></h2>
                </tr>
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
              <h2>MENÚ DE ADMINISTRADOR DE SISTEMA</h2>
              <br><br><br>
              <h3>SELECCIONE UNA OPCIÓN PARA INICIAR UNA TAREA</h3>
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
      if (isset($_POST["alta"])) {
        $error = "";
        $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
        if (mysqli_connect_errno()) {
          printf("Conexión fallida: %s\n", mysqli_connect_error());
          exit();
        } else {

          $nombre = mb_strtoupper($_POST['nombre']);
          $apellido = mb_strtoupper($_POST['apellido']);
          $fechanac = $_POST["fechanac"];

          $sql = "INSERT INTO usuarios VALUES (' ','" . $_POST["usu"] . "','" . hash_hmac('sha512', $_POST["pass"], 'primeraweb') . "', 'administrador','$fechanac','$nombre','$apellido','" . $_POST["email"] . "');";

          if (mysqli_multi_query($conexion, $sql)) {
  ?>
        <script>
          alert("NUEVO ADMINISTRADOR REGISTRADO CORRECTAMENTE");
        </script>
      <?php
            mysqli_close($conexion);
          }
        }
      }


      if (isset($_POST['confirmarAlta'])) {
        $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');

        if (mysqli_connect_errno()) {
          printf("Conexión fallida: %s\n", mysqli_connect_error());
          exit();
        } else {

          $sql = "INSERT INTO articulos VALUES ('', '" . $_POST['desc'] . "','" . $_POST['precio'] . "', '" . $_POST['caract'] . "','" . $_POST['totalStock'] . "', '" . $_POST['imagen'] . "');";

          if (mysqli_multi_query($conexion, $sql)) {
      ?>
        <script>
          alert("Artículo registrado correctamente");
        </script>
<?php
          } else {
            echo "Error en la consulta: " . $sql . "<br>" . mysqli_error($conexion);
          }

          mysqli_close($conexion);
        }
      }
    }
?>

</body>

</html>