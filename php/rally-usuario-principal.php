<?php
$sql_usuario_checkpoint = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio'" );
$row_usuario_checkpoint = mysqli_fetch_array( $sql_usuario_checkpoint );
$usuario_checkpoint = mysqli_num_rows( $sql_usuario_checkpoint );
if ( isset( $usuario_checkpoint ) ) {
  $numero_maximo_checkpoint = '12';
  if ( $usuario_checkpoint == $numero_maximo_checkpoint ) {
    //echo $usuario_checkpoint . ' Recorrido completo';
  } else if ( $usuario_checkpoint == '0' || $usuario_checkpoint < $numero_media_checkpoint ) {
    //echo $usuario_checkpoint . ' Check Points';
  }
}
?>
<div class="div-cerrar-sesion"> <a id="id-a-cerrar-sesion" class="a-cerrar-sesion">
  <svg class="svg-cerrar-sesion" viewBox="0 0 512 512">
    <path d="M170.698,448H72.757c-4.814-0.012-8.714-3.911-8.725-8.725V72.725c0.012-4.814,3.911-8.714,8.725-8.725h97.941   c17.673,0,32-14.327,32-32s-14.327-32-32-32H72.757C32.611,0.047,0.079,32.58,0.032,72.725v366.549   C0.079,479.42,32.611,511.953,72.757,512h97.941c17.673,0,32-14.327,32-32S188.371,448,170.698,448z"/>
    <path d="M483.914,188.117l-82.816-82.752c-12.501-12.495-32.764-12.49-45.259,0.011s-12.49,32.764,0.011,45.259l72.789,72.768   L138.698,224c-17.673,0-32,14.327-32,32s14.327,32,32,32l0,0l291.115-0.533l-73.963,73.963   c-12.042,12.936-11.317,33.184,1.618,45.226c12.295,11.445,31.346,11.436,43.63-0.021l82.752-82.752   c37.491-37.49,37.491-98.274,0.001-135.764c0,0-0.001-0.001-0.001-0.001L483.914,188.117z"/>
  </svg>
  </a> </div>
<div id="id-div-rally" class="div-contenedor-inicio"> <img draggable="false" class="img-gif-animado" src="gif/telefono-inteligente.gif"> <span class="span-descripcion">PRIMER PUNTO</span> <span class="span-descripcion-hora"> TIENES 3 HORAS</span> <span class="span-descripcion-punto">BUSCA Y ENCUENTRA EL PUNTO EN<br>
  MUSEO BARROCO</span>
  <div id="id-div-qr"></div>
  <form method="post" enctype="multipart/form-data">
    <div style="width: 100%" id="reader" class="div-modulo-qr"></div>
  </form>
</div>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        $('#id-div-qr').text(decodedText);
    }
    function onScanError(errorMessage) {
        // handle on error condition, with error message
    }
    var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script> 
