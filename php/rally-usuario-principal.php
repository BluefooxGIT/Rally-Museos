<?php
//Checkpoints
$sql_checkpoints = $mysqli->query( "SELECT * FROM rally_checkpoint ORDER BY RAND()" );
$row_checkpoints = mysqli_fetch_array( $sql_checkpoints );
$checkpoints_total = mysqli_num_rows( $sql_checkpoints );
//echo 'Total: ' . $checkpoints_total . '<br>';
//Checkpoints Usuario
$sql_checkpoints_usuario = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio'" );
$row_checkpoints_usuario = mysqli_fetch_array( $sql_checkpoints_usuario );
$checkpoints_usuario_total = mysqli_num_rows( $sql_checkpoints_usuario );
//echo 'Registrados: ' . $checkpoints_usuario_total . '<br>';
//Checkpoints Usuario Registrados
$sql_checkpoints_usuario_activados = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio' AND usuarios_checkpoint_registrado = '1' " );
$row_checkpoints_usuario_activados = mysqli_fetch_array( $sql_checkpoints_usuario_activados );
$checkpoints_usuario_total_activados = mysqli_num_rows( $sql_checkpoints_usuario_activados );
//echo 'Escaneados: ' . $checkpoints_usuario_total_activados . '<br>';
//Checkpoints Usuario Registrados
$sql_checkpoints_usuario = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio' AND usuarios_checkpoint_registrado = '0' ORDER BY uid ASC" );
$row_checkpoints_usuario = mysqli_fetch_array( $sql_checkpoints_usuario );
$usuarios_checkpoint_siguiente = $row_checkpoints_usuario[ 'usuarios_checkpoint_checkpoint' ];
//echo 'Siguiente Checkpoint: ' . $usuarios_checkpoint_siguiente;
$sql_checkpoint = $mysqli->query( "SELECT * FROM rally_checkpoint WHERE checkpoint_folio = '$usuarios_checkpoint_siguiente' " );
$row_checkpoint = mysqli_fetch_array( $sql_checkpoint );
//Iniciar Rally
if ( $checkpoints_usuario_total > '0' ) {
  $sql_checkpoints_inicio = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio' AND usuarios_checkpoint_registrado = '0'" );
  $row_checkpoints_inicio = mysqli_fetch_array( $sql_checkpoints_inicio );
  if ( isset( $row_checkpoints_inicio ) ) {
    if ( isset( $_POST[ 'checkpoint' ] ) ) {
      $usuarios_checkpoint_actual = base64_decode( $_POST[ 'checkpoint' ] );
      if ( $usuarios_checkpoint_actual == $usuarios_checkpoint_siguiente ) {
        //Registrar Checkpoint QR
        $usuarios_checkpoint_usuario = $usuario_folio;
        $usuarios_checkpoint_checkpoint = base64_decode( $_POST[ 'checkpoint' ] );
        $usuarios_checkpoint_fecha = date( "Y-m-d" );
        $usuarios_checkpoint_hora = date( "H:i:s" );
        $usuarios_checkpoint_registrado = '1';
        //Filtro Código QR
        $sql_checkpoint_filtro = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuarios_checkpoint_usuario' AND usuarios_checkpoint_checkpoint = '$usuarios_checkpoint_checkpoint'" );
        $row_checkpoint_filtro = mysqli_fetch_array( $sql_checkpoint_filtro );
        $usuarios_checkpoint_registrado = $row_checkpoint_filtro[ 'usuarios_checkpoint_registrado' ];
        if ( $usuarios_checkpoint_registrado == '0' ) {
          $usuarios_checkpoint_fecha = date( "Y-m-d" );
          $usuarios_checkpoint_hora = date( "H:i:s" );
          mysqli_query( $mysqli, "UPDATE rally_usuarios_checkpoint SET usuarios_checkpoint_registrado = '1', usuarios_checkpoint_fecha = '$usuarios_checkpoint_fecha', usuarios_checkpoint_hora = '$usuarios_checkpoint_hora' WHERE usuarios_checkpoint_usuario = '$usuarios_checkpoint_usuario' AND usuarios_checkpoint_checkpoint = '$usuarios_checkpoint_checkpoint'" );
        }
      }
    }
  }
}
?>
<div class="div-cabezal-imagen-2" style="background-image: url('<?php $a = array('jpg/cabezal-02.jpg','jpg/cabezal-03.jpg'); echo $a[array_rand($a)];?>')">&nbsp;</div>
<!--Botón cerrar sesión-->
<div class="div-cerrar-sesion"> <a id="id-a-cerrar-sesion" class="a-cerrar-sesion">
  <svg class="svg-cerrar-sesion" viewBox="0 0 512 512">
    <path d="M170.698,448H72.757c-4.814-0.012-8.714-3.911-8.725-8.725V72.725c0.012-4.814,3.911-8.714,8.725-8.725h97.941   c17.673,0,32-14.327,32-32s-14.327-32-32-32H72.757C32.611,0.047,0.079,32.58,0.032,72.725v366.549   C0.079,479.42,32.611,511.953,72.757,512h97.941c17.673,0,32-14.327,32-32S188.371,448,170.698,448z"/>
    <path d="M483.914,188.117l-82.816-82.752c-12.501-12.495-32.764-12.49-45.259,0.011s-12.49,32.764,0.011,45.259l72.789,72.768   L138.698,224c-17.673,0-32,14.327-32,32s14.327,32,32,32l0,0l291.115-0.533l-73.963,73.963   c-12.042,12.936-11.317,33.184,1.618,45.226c12.295,11.445,31.346,11.436,43.63-0.021l82.752-82.752   c37.491-37.49,37.491-98.274,0.001-135.764c0,0-0.001-0.001-0.001-0.001L483.914,188.117z"/>
  </svg>
  </a> </div>
<!--Anuncio Checkpoint Registrado-->
<div id="id-div-checkpoint-leido" class="<?php if(isset($_GET['ch'])) { $checkpoint_leido = base64_decode($_GET['ch']); if($checkpoint_leido == '1') { echo 'div-contenedor-checkpoints'; } else { echo 'div-oculto'; } } else { echo 'div-oculto'; } ?>">
  <div class=""> <img draggable="false" class="img-gif-animado" src="gif/verificado.gif"> <span id="id-span-texto" class="span-descripcion-punto">¡Excelente ya tienes!<br>
    </span> <span class="span-descripcion-hora">
    <?php if(isset($_GET['l'])) { $checkpoint_lugar = base64_decode($_GET['l']); echo $checkpoint_lugar; } ?>
    </span><br>
    <input id="id-input-siguiente" class="input-registro-submit" type="button" value="Siguiente Checkpoint">
  </div>
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<!--Siguiente Checkpoint-->
<div id="id-div-rally" class="<?php if(isset($_GET['ch'])) { $checkpoint_leido = base64_decode($_GET['ch']); if($checkpoint_leido == '1') { echo 'div-oculto'; } else { if($checkpoints_total == $checkpoints_usuario_total_activados) { echo 'div-oculto'; } else { echo 'div-contenedor-checkpoints'; } } } else { if($checkpoints_total == $checkpoints_usuario_total_activados) { echo 'div-oculto'; } else { echo 'div-contenedor-checkpoints'; } } ?>"> <img id="id-img-camino" draggable="false" class="img-gif-animado" src="gif/camino.gif"><img id="id-img-codigoqr" draggable="false" class="div-oculto img-gif-animado" src="gif/codigo-qr.gif">
  <div id="id-div-contenedor-checkpoint"><span id="id-span-texto" class="span-descripcion-punto">Checkpoint encu&eacute;ntralo en:</span><span class="span-descripcion-hora">
    <?php if(isset($row_checkpoint)) { echo $row_checkpoint[ 'checkpoint_nombre' ]; } ?>
    </span> <span class="span-descripcion-direccion">
    <?php if(isset($row_checkpoint)) { echo 'Direcci&oacute;n: '.$row_checkpoint[ 'checkpoint_direccion' ]; } ?>
    </span>
    <iframe id="id-frame-gmap" class="iframe-gmaps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.483211093123!2d-98.2015712258168!3d19.042480853025957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc0e7f040bb81%3A0x26f40cbe4118a8ad!2sGaleria%20Tesoros%20de%20la%20Catedral!5e0!3m2!1ses-419!2smx!4v1708808608486!5m2!1ses-419!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <form id="id-form-qr" method="post" enctype="multipart/form-data" class="">
    <input id="id-input-qr" name="usuarios_checkpoint_checkpoint" type="hidden">
    <div style="width: 100%" id="reader" class="div-modulo-qr"></div>
  </form>
  <input id="id-input-regresar" class="input-registro-volver div-oculto" type="submit" value="Regresar">
  <div class="div-contenedor-inicio-c"> <span class="span-subtitulo-a">Activar C&aacute;mara y <br>
    Escanear C&oacute;digo</span><br>
    <br>
    <div class="div-participar-pasos">
      <div class="div-pasos">Paso 1</div>
      <div class="div-pasos-descripcion">Presiona el bot&oacute;n <b>"Activar C&aacute;mara y Escanear C&oacute;digo"</b>.</div>
    </div>
    <div class="div-participar-pasos">
      <div class="div-pasos">Paso 2</div>
      <div class="div-pasos-descripcion"><b>Permite</b> al navegador acceder a la c&aacute;mara.</div>
    </div>
    <div class="div-participar-pasos">
      <div class="div-pasos">Paso 3</div>
      <div class="div-pasos-descripcion">Selecciona la cámara, te recomendamos <b>"C&aacute;mara Tracera"</b> y escan&eacute;a tu <i>checkpoint</i>.</div>
    </div>
  </div>
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<!--Checkpoint Capturados-->
<div id="id-div-rally-finalizado" class="<?php if(isset($_GET['ch'])) { $checkpoint_leido = base64_decode($_GET['ch']); if($checkpoint_leido == '1') { echo 'div-oculto'; } else { if($checkpoints_total == $checkpoints_usuario_total_activados) { echo 'div-contenedor-checkpoints'; } else { echo 'div-oculto'; } } } else { if($checkpoints_total == $checkpoints_usuario_total_activados) { echo 'div-contenedor-checkpoints'; } else { echo 'div-oculto'; } } ?>"> <img draggable="false" class="img-gif-animado" src="gif/premio.gif"><span class="span-subtitulo">Felicidades</span><br>
  <span class="span-descripcion-punto">Haz recorrido todos los checkpoints, ahora puedes ir por tu premio al:</span><br>
  <span class="span-descripcion-hora"> Museo Internacional del Barroco </span><span class="span-descripcion-direccion">Direcci&oacute;n: Bulevar Atlixcáyotl 2501. Reserva Territorial Atlixcáyotl.</span>
  <div class="div-contenedor-inicio-b">
    <div class="div-contenedor-inicio-c"> <span class="span-subtitulo">Museos Participantes</span>
      <div class="g-scrolling-carousel carousel">
        <div class="items"><a href="#" style="background-image: url('jpg/slider-01.jpg')">&nbsp;</a><a href="#" style="background-image: url('jpg/slider-02.jpg')">&nbsp;</a><a href="#" style="background-image: url('jpg/slider-03.jpg')">&nbsp;</a></div>
      </div>
    </div>
  </div>
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<script>
//Slider Museos
$(document).ready(function(){
    $(".g-scrolling-carousel .items").gScrollingCarousel({
        mouseScrolling: true,
        scrollAmount: 'viewport',
        draggable: true,
        snapOnDrag: true,
        mobileNative: false,
    });
});
//Botón Siguiente Checkpoint
$('#id-input-siguiente').click(function() {
    location.replace("<?php echo $servidor_dominio; ?>");
});
//Lector QR
function onScanSuccess(decodedText, decodedResult) {
  $('#id-input-qr').val(decodedText);
  var he_ac = $('#id-input-qr').val();
  var checkpoint = btoa(he_ac);
  $.ajax({
    type: 'post',
    data: 'checkpoint=' + checkpoint,
    beforeSend: function () {
      //Acción antes de continuar
    },
    success: function (response) {
      //Acción en caso de éxito
      location.replace("<?php echo $servidor_dominio.'?ch='.base64_encode('1').'&l='.base64_encode($row_checkpoint[ 'checkpoint_nombre' ]); ?>");
    },
    error: function () {
      //Acción en caso de error
      location.replace("<?php echo $servidor_dominio.'?ch='.base64_encode('1').'&l='.base64_encode($row_checkpoint[ 'checkpoint_nombre' ]); ?>");
    }
  });
}
function onScanError(errorMessage) {
  //Error
}
var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
  fps: 10,
  qrbox: 250,
  aspectRatio: 1.333334,
});
html5QrcodeScanner.render(onScanSuccess, onScanError);
</script> 