window.onload = function() {
  document.getElementById("contenedor").style.height = (window.innerHeight - 200) + "px";
  console.log(document.getElementById("contenedor").style.height);
}

function altaUsu() {
  console.log("comprobando alta");
  var nombre = document.getElementById('nombre');
  var apellido = document.getElementById('apellido');
  var contra1 = document.getElementById('pass');
  var contra2 = document.getElementById('pass2');
  var nombreRexp = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/g;
  var apellidoRexp = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
  var aviso = "";

  if (!nombreRexp.test(nombre.value)) {
    aviso += "Formato de nombre incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (!apellidoRexp.test(apellido.value)) {
    aviso += "\nFormato de apellido incorrecto. Solo son válidos letras y espacios en blanco";
  }

  if (contra1.value != contra2.value) {
    aviso += "\nLa contraseñas no coinciden";
  }

  if (aviso == "") {
    return true;
  } else {
    alert(aviso);
    return false;
  }
}

function fechaMin() {
  var fechaini = document.getElementById("fechaini");
  console.log(fechaini.value)
  fechafin.min = fechaini.value;
}


function confirmarCompra() {
  return confirm("¿Desea finalizar su pedido?");
}

function cierreSesion() {
  return confirm("¿Está seguro que desea cerrar sesión?");
}