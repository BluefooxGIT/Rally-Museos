<?php
$sql_usuario_checkpoint = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio'" );
$row_usuario_checkpoint = mysqli_fetch_array( $sql_usuario_checkpoint );
$usuario_checkpoint = mysqli_num_rows( $sql_usuario_checkpoint );
if ( isset( $usuario_checkpoint ) ) {
  $numero_maximo_checkpoint = '12';
  if ( $usuario_checkpoint == $numero_maximo_checkpoint ) {
    echo $usuario_checkpoint . ' Recorrido completo';
  } else if ( $usuario_checkpoint == '0' || $usuario_checkpoint < $numero_media_checkpoint ) {
    echo $usuario_checkpoint . ' Check Points';
  }
}
?>
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
