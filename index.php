<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CarritoBD - Víctor Emmanuel Molinas</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/ingreso.css" type  ="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
  <?php
  if (!empty($_SESSION["datos"])) {
    session_destroy();
  }
  session_start();

  $hoy = getdate();
  $fecha = $hoy['year'] - 18 . "-01-01";
  ?>
  <script type="text/javascript" src="js/funciones.js"></script>
  <header>
    <img src="https://images.milled.com/2019-01-03/2T7oJHb-mVVZD-iV/MMCdwzleMX0w.gif" alt="rebajas">
  </header>
  <div id="contenedor">
    <?php
    if (isset($_POST["alta"])) {
      $error = "";
      $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
      if (mysqli_connect_errno()) {
        printf("Conexión fallida: %s\n", mysqli_connect_error());
        exit();
      } else {

        $nombre = mb_strtoupper($_POST['nombre']);
        $apellido = mb_strtoupper($_POST['apellido']);
        $fechanac = $_POST["fechanac"];

        $sql = "INSERT INTO usuarios VALUES (' ','" . $_POST["usu"] . "','" . hash_hmac('sha512',$_POST["pass"],'primeraweb') . "', 'consultor','$fechanac','$nombre','$apellido','" . $_POST["email"] . "');";

        if (mysqli_multi_query($conexion, $sql)) {
    ?>
          <script>
            alert("USUARIO REGISTRADO\nLogueate para entrar en la tienda");
          </script>
    <?php
          mysqli_close($conexion);
        }
      }
    }

    if (isset($_POST["ingresar"])) {
      $error = "";
      $conexion = @mysqli_connect('localhost', 'acceso', '1234', 'ventas');
      if (mysqli_connect_errno()) {
        printf("Conexión fallida: %s\n", mysqli_connect_error());
        exit();
      } else {

        $sql = "SELECT usuario, password, rol, nombre, apellidos, idUsuario from usuarios where usuario='" . $_POST["user"] . "' and password='" . hash_hmac('sha512',$_POST["pass"],'primeraweb') . "'";

        $resultado = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
        if ($row == null) {
          $error = "Usuario y/o contraseña no valido/s";
        } else {
          $_SESSION["datos"] = $row;
          mysqli_close($conexion);

          if ($_SESSION["datos"]["rol"] == "administrador") {
            header('Location: menuAdmin.php');
          } else if ($_SESSION["datos"]["rol"] == "consultor") {
            $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
            if (mysqli_connect_errno()) {
              printf("Conexión fallida: %s\n", mysqli_connect_error());
              exit();
            } else {
              $_SESSION['total'] = 0;
              $_SESSION['compra'] = false;
              $_SESSION["carrito"] = [];
              $sql1 = "SELECT idArticulo, precio, descripcion, imagen from articulos;";
              $resultado = mysqli_query($conexion, $sql1);
              while ($registro = mysqli_fetch_row($resultado)) {
                $_SESSION["carrito"][$registro[0]] = [0, $registro[1], $registro[2], $registro[0], $registro[3]];
              }
              mysqli_close($conexion);
              header('Location: productos.php');
            }
          }
        }
      }
    }
    ?>

    <?php if (isset($_POST['registrar'])) { ?>
      <div id="registro">
        <h1 id="bienvenida">REGISTRO DE NUEVO USUARIO</h1>
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
      <div id="login">
        <form action="" id="ingreso" method="POST">
          <h4><label for="user">Usuario</label><br /></h4>
          <input type="text" name="user" class="form" value="<?php if (isset($_POST['ingresar'])) echo $_POST['user'] ?>" required>
          <h4><label for="pass">Contraseña</label><br /></h4>
          <input type="password" name="pass" class="form" value="<?php if (isset($_POST["ingresar"])) echo $_POST["pass"] ?>" required>
          <input type="submit" name="ingresar" class="boton" value="INGRESAR A LA TIENDA"><br /><br />
        </form>
        <form action="" id="ingreso" style="height: 2px; margin-top:-50px;" method="POST">
          <p style="font-size:15px;margin-top:10px;line-height:25px;">¿TODAVÍA NO ERES CLIENTE?</p>
          <input type="submit" name="registrar" class="boton" value="REGISTRATE">
        </form>
      </div>
      <span class="error">
        <h4><?php if (isset($_POST["ingresar"]))  echo $error ?></h4>
      </span>
      <div class="slider">
        <ul>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/612gUJd0phL._SL1200_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61TmUVua4XL._SL1016_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61s9D4c-UGL._SL1000_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61nYK91POwL._SL1500_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/51UrH20pkzL._SL1000_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61luVj-p3KL._SL1500_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61ini80CcuL._SL1500_.jpg" alt="articulo"></li>
          <li><img src="https://images-na.ssl-images-amazon.com/images/I/61EJGlaUl2L._SL1000_.jpg" alt="articulo"></li>
        </ul>
      </div>
    <?php } ?>
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