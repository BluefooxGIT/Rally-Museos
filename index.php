<?php
include_once( 'php/rally-conexion.php' );
//Detección de sesión
if ( isset( $_COOKIE[ 'usuario_nivel_sesion' ] ) ) {
  $usuario_email = base64_decode( $_COOKIE[ 'usuario_email' ] );
  $usuario_nivel = base64_decode( $_COOKIE[ 'usuario_nivel_sesion' ] );
  $usuario_folio = base64_decode( $_COOKIE[ 'usuario_sesion' ] );
  $herramienta_actual = 'rally-usuario-principal';
}

if ( isset( $_POST[ 'rally_herramienta' ] ) ) {
  $herramienta = base64_decode( $_POST[ 'rally_herramienta' ] );
  //Registro de usuario
  if ( $herramienta == 'registro' ) {
    $usuarios_folio = date( 'YmdHis' ) . rand( 11, 99 );
    $usuarios_nombre = $_POST[ 'usuarios_nombre' ];
    $usuarios_email = $_POST[ 'usuarios_email' ];
    $usuarios_celular = $_POST[ 'usuarios_celular' ];
    $usuarios_contrasena = password_hash( $_POST[ 'usuarios_contrasena' ], PASSWORD_DEFAULT );
    $usuarios_fecha = date( "Y-m-d" );
    $usuarios_hora = date( "H:i:s" );
    $usuarios_nivel = '1';
    $sql_usuario_filtro = $mysqli->query( "SELECT * FROM rally_usuarios WHERE usuarios_email = '$usuarios_email'" );
    $row_usuario_filtro = mysqli_fetch_array( $sql_usuario_filtro );
    if ( isset( $row_usuario_filtro ) ) {
      $usuarios_email_filtro = $row_usuario_filtro[ 'usuarios_email' ];
      if ( $usuarios_email == $usuarios_email_filtro ) {
        //Usuario registrado
      }
    } else {
      //Registro usuario
      mysqli_query( $mysqli, "INSERT INTO rally_usuarios (usuarios_folio, usuarios_nombre, usuarios_email, usuarios_celular, usuarios_contrasena, usuarios_fecha, usuarios_hora, usuarios_nivel) VALUES ('$usuarios_folio', '$usuarios_nombre', '$usuarios_email', '$usuarios_celular', '$usuarios_contrasena', '$usuarios_fecha', '$usuarios_hora', '$usuarios_nivel')" );
      $sql_usuario_registrado = $mysqli->query( "SELECT * FROM rally_usuarios WHERE usuarios_email = '$usuarios_email'" );
      $row_usuario_registrado = mysqli_fetch_array( $sql_usuario_registrado );
      if ( isset( $row_usuario_registrado ) ) {
        $usuario_email_registrado == $row_usuario_registrado[ 'usuarios_email' ];
        //Sesión
        $usuario_email_cookie = base64_encode( $usuarios_email );
        $usuario_nivel_sesion_cookie = base64_encode( $usuarios_nivel );
        $usuario_sesion_cookie = base64_encode( $usuarios_folio );
        setcookie( "usuario_email", $usuario_email_cookie, time() + 3600 * 24 * 30, '/' );
        setcookie( "usuario_nivel_sesion", $usuario_nivel_sesion_cookie, time() + 3600 * 24 * 30, '/' );
        setcookie( "usuario_sesion", $usuario_sesion_cookie, time() + 3600 * 24 * 30, '/' );
      }
    }
  }
  //Logueo de usuario
  else if ( $herramienta == 'logueo' ) {
    $usuarios_email = $_POST[ 'usuarios_email' ];
    $usuarios_contrasena = $_POST[ 'usuarios_contrasena' ];
    $sql_usuario_filtro = $mysqli->query( "SELECT * FROM rally_usuarios WHERE usuarios_email = '$usuarios_email'" );
    $row_usuario_filtro = mysqli_fetch_array( $sql_usuario_filtro );
    if ( isset( $row_usuario_filtro ) ) {
      $usuarios_contrasena_filtro = $row_usuario_filtro[ 'usuarios_contrasena' ];
      if ( password_verify( $usuarios_contrasena, $usuarios_contrasena_filtro ) ) {
        $usuarios_email = $row_usuario_filtro[ 'usuarios_email' ];
        $usuarios_nivel = $row_usuario_filtro[ 'usuarios_nivel' ];
        $usuarios_folio = $row_usuario_filtro[ 'usuarios_folio' ];
        //Sesión
        $usuario_email_cookie = base64_encode( $usuarios_email );
        $usuario_nivel_sesion_cookie = base64_encode( $usuarios_nivel );
        $usuario_sesion_cookie = base64_encode( $usuarios_folio );
        setcookie( "usuario_email", $usuario_email_cookie, time() + 3600 * 24 * 30, '/' );
        setcookie( "usuario_nivel_sesion", $usuario_nivel_sesion_cookie, time() + 3600 * 24 * 30, '/' );
        setcookie( "usuario_sesion", $usuario_sesion_cookie, time() + 3600 * 24 * 30, '/' );
      }
    }
  }
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Rally Museos Puebla</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
<script src="js/html5-qrcode.min.js"></script>
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if ( isset( $herramienta_actual ) ) {
  if ( $herramienta_actual == 'rally-usuario-principal' ) {
    include( 'php/rally-usuario-principal.php' );

  }
} else {
  include( 'php/rally-principal.php' );
}
?>
</body>
</html>
<script>
//Registro usuario
$("#id-form-registro").on("submit", function () {
  event.preventDefault();
  if ($('#id-usuarios-nombre').val().length === 0) {
    $("#id-usuarios-nombre").focus();
    $("#id-usuarios-nombre").attr("placeholder", "Escribe tu nombre");
    $("#id-usuarios-nombre").removeClass("input-registro");
    $("#id-usuarios-nombre").addClass("input-registro-novalido");
    return false;
  } else if ($("#id-usuarios-email").val().indexOf('@', 0) == -1 || $("#id-usuarios-email").val().indexOf('.', 0) == -1) {
    $("#id-usuarios-email").focus();
    $("#id-usuarios-email").attr("placeholder", "Escribe tu correo electrónico");
    $("#id-usuarios-email").removeClass("input-registro");
    $("#id-usuarios-email").addClass("input-registro-novalido");
    return false;
  } else if ($('#id-usuarios-celular').val().length === 0) {
    $("#id-usuarios-celular").focus();
    $("#id-usuarios-celular").attr("placeholder", "Escribe tu celular");
    $("#id-usuarios-celular").removeClass("input-registro");
    $("#id-usuarios-celular").addClass("input-registro-novalido");
    return false;
  } else if ($('#id-usuarios-contrasena').val().length === 0) {
    $("#id-usuarios-contrasena").focus();
    $("#id-usuarios-contrasena").attr("placeholder", "Escribe tu contraseña");
    $("#id-usuarios-contrasena").removeClass("input-registro");
    $("#id-usuarios-contrasena").addClass("input-registro-novalido");
    return false;
  } else if ($("input[type='checkbox']").is(':checked') === false) {
    $("#id-usuarios-aviso").removeClass("div-checkbox-text");
    $("#id-usuarios-aviso").addClass("div-checkbox-text-novalido");
  } else {
    var he_ac = 'registro';
    var rally_herramienta = btoa(he_ac);
    var usuarios_nombre = $('#id-usuarios-nombre').val();
    var usuarios_email = $('#id-usuarios-email').val();
    var usuarios_celular = $('#id-usuarios-celular').val();
    var usuarios_contrasena = $('#id-usuarios-contrasena').val();
    $.ajax({
      type: 'post',
      data: 'rally_herramienta=' + rally_herramienta + '&usuarios_nombre=' + usuarios_nombre + '&usuarios_email=' + usuarios_email + '&usuarios_celular=' + usuarios_celular + '&usuarios_contrasena=' + usuarios_contrasena,
      beforeSend: function () {
        //Acción antes de continuar
      },
      success: function (response) {
        //Acción en caso de éxito
        location.replace("<?php echo $servidor_dominio; ?>");
      },
      error: function () {
        //Acción en caso de error
        location.replace("../?e=<?php echo base64_encode('usuario-registro-problema'); ?>");
      }
    });
  }
});

//Logueo usuario
$("#id-form-logueo").on("submit", function () {
  event.preventDefault();
  if ($("#id-usuarios-email-logueo").val().indexOf('@', 0) == -1 || $("#id-usuarios-email-logueo").val().indexOf('.', 0) == -1) {
    $("#id-usuarios-email-logueo").focus();
    $("#id-usuarios-email-logueo").attr("placeholder", "Escribe tu correo electrónico");
    $("#id-usuarios-email-logueo").removeClass("input-registro");
    $("#id-usuarios-email-logueo").addClass("input-registro-novalido");
    return false;
  } else if ($('#id-usuarios-contrasena-logueo').val().length === 0) {
    $("#id-usuarios-contrasena-logueo").focus();
    $("#id-usuarios-contrasena-logueo").attr("placeholder", "Escribe tu contraseña");
    $("#id-usuarios-contrasena-logueo").removeClass("input-registro");
    $("#id-usuarios-contrasena-logueo").addClass("input-registro-novalido");
    return false;
  } else {
    var he_ac = 'logueo';
    var rally_herramienta = btoa(he_ac);
    var usuarios_email = $('#id-usuarios-email-logueo').val();
    var usuarios_contrasena = $('#id-usuarios-contrasena-logueo').val();
    $.ajax({
      type: 'post',
      data: 'rally_herramienta=' + rally_herramienta + '&usuarios_email=' + usuarios_email + '&usuarios_contrasena=' + usuarios_contrasena,
      beforeSend: function () {
        //Acción antes de continuar
      },
      success: function (response) {
        //Acción en caso de éxito
        location.replace("<?php echo $servidor_dominio; ?>");
      },
      error: function () {
        //Acción en caso de error
        location.replace("../?e=<?php echo base64_encode('usuario-registro-problema'); ?>");
      }
    });
  }
});

$('#id-a-registro').click(function () {
  $('#id-div-inicio').fadeOut(300);
  $('#id-div-registro').fadeIn(300);
})

$('#id-a-iniciar').click(function () {
  $('#id-div-inicio').fadeOut(300);
  $('#id-div-logueo').fadeIn(300);
})
</script>