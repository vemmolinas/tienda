<?php
session_start();

$tiquet = 0;

$fecha = date("Y-m-d H:i:s");

function menor10($dato)
{
  if ($dato < 10) {
    $dato = "0" . $dato;
  }
  return $dato;
}

if (isset($_POST["añadir"])) {
  $_SESSION['compra'] = true;
  $_SESSION["carrito"][$_POST["añadir"]][0]++;
  header('Location: productos.php');
} else if (isset($_POST["quitar"])) {
  if ($_SESSION["carrito"][$_POST["quitar"]][0] > 0) {
    $_SESSION["carrito"][$_POST["quitar"]][0]--;
  }
  header('Location: productos.php');
} else {
  $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
  $sql = "SELECT MAX(tiquet) as 'ULTIMO' from compras";
  $resultado = mysqli_query($conexion, $sql);
  $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
  $tiquet = $row['ULTIMO'] + 1;

  foreach ($_SESSION["carrito"] as $dato) {
    if ($dato[0] > 0) {
      $sql = "INSERT INTO compras VALUES (" . $_SESSION["datos"]["idUsuario"] . ", $dato[3] , '$fecha' , $dato[0] ,$tiquet);";

      $sql2 = "SELECT stock as 'STOCK' from articulos where idArticulo=$dato[3];";
      $resultado = mysqli_query($conexion, $sql2);
      $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
      $nuevoStock = $row['STOCK'] - $dato[0];
      $_SESSION["PEDIDO"] = $_SESSION["datos"]["idUsuario"] . $tiquet . '/' . date("Y-m");

      if (!mysqli_multi_query($conexion, $sql)) {
        echo "ERROR";
      }
      if (!mysqli_multi_query($conexion, $sql2)) {
        echo "ERROR2";
      }
      $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
      $sql3 = "UPDATE articulos set stock=$nuevoStock where idArticulo=" . $dato[3] . ";";

      if (!mysqli_multi_query($conexion, $sql3)) {
        echo "ERROR3";
      }
    }
  }
  mysqli_close($conexion);
  header('Location: confirmar.php');
}


// $conexion = @mysqli_connect('localhost', 'consultor', '1234', 'ventas');
//   $sql = "SELECT MAX(tiquet) as 'ULTIMO' from compras";
//   $resultado = mysqli_query($conexion, $sql);
//   $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
//   $tiquet = $row['ULTIMO'] + 1;

//   foreach ($_SESSION["carrito"] as $dato) {
//     if ($dato[0] > 0) {
//       $sql = "INSERT INTO compras VALUES (" . $_SESSION["datos"]["idUsuario"] . ", $dato[3] , '$fecha' , $dato[0] ,$tiquet);";

//       $_SESSION["PEDIDO"] = $_SESSION["datos"]["idUsuario"] . $tiquet . '/' . date("Y-m");

//       if (mysqli_multi_query($conexion, $sql)) {
//         $sql2 = "SELECT stock as 'STOCK' from articulos where idArticulo=$dato[3];";
//         $resultado = mysqli_query($conexion, $sql2);
//         $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
//         $nuevoStock = $row['STOCK'] - $dato[0];
//         if (mysqli_multi_query($conexion, $sql2)) {
//           $conexion = @mysqli_connect('localhost', 'AdminCarrito', '1234', 'ventas');
//           $sql3 = "UPDATE articulos set stock=$nuevoStock where idArticulo=" . $dato[3] . ";";
//           if (mysqli_multi_query($conexion, $sql2)) {
//             mysqli_close($conexion);
//             header('Location: confirmar.php');
//           }
//         }
//       } else {
//         mysqli_close($conexion);
//         header('Location: confirmar.php');
//       }
//     }
//   }
