<?php
//Checkpoints
$sql_checkpoints = $mysqli->query( "SELECT * FROM rally_checkpoint ORDER BY RAND()" );
$row_checkpoints = mysqli_fetch_array( $sql_checkpoints );
$checkpoints_total = mysqli_num_rows( $sql_checkpoints );
echo 'total: ' . $checkpoints_total . '<br>';
//Checkpoints Usuario
$sql_checkpoints_usuario = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio'" );
$row_checkpoints_usuario = mysqli_fetch_array( $sql_checkpoints_usuario );
$checkpoints_usuario_total = mysqli_num_rows( $sql_checkpoints_usuario );
echo 'registrados: ' . $checkpoints_usuario_total . '<br>';
//Checkpoints Usuario Registrados
$sql_checkpoints_usuario = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio' AND usuarios_checkpoint_registrado = '0' ORDER BY uid ASC" );
$row_checkpoints_usuario = mysqli_fetch_array( $sql_checkpoints_usuario );
echo $usuarios_checkpoint_siguiente = $row_checkpoints_usuario[ 'usuarios_checkpoint_checkpoint' ];
//Iniciar Rally
if ( $checkpoints_usuario_total == '0' ) {
  //Registro Inicial
  do {
    $usuarios_checkpoint_usuario = $usuario_folio;
    $usuarios_checkpoint_checkpoint = $row_checkpoints[ 'checkpoint_folio' ];
    $usuarios_checkpoint_fecha = date( "Y-m-d" );
    $usuarios_checkpoint_hora = date( "H:i:s" );
    $usuarios_checkpoint_registrado = '0';
    mysqli_query( $mysqli, "INSERT INTO rally_usuarios_checkpoint (usuarios_checkpoint_usuario, usuarios_checkpoint_checkpoint, usuarios_checkpoint_fecha, usuarios_checkpoint_hora, usuarios_checkpoint_registrado) VALUES ('$usuarios_checkpoint_usuario', '$usuarios_checkpoint_checkpoint', '$usuarios_checkpoint_fecha', '$usuarios_checkpoint_hora', '$usuarios_checkpoint_registrado')" );
  } while ( $row_checkpoints = mysqli_fetch_assoc( $sql_checkpoints ) );

} else {
  $sql_checkpoints_inicio = $mysqli->query( "SELECT * FROM rally_usuarios_checkpoint WHERE usuarios_checkpoint_usuario = '$usuario_folio' AND usuarios_checkpoint_registrado = '0'" );
  $row_checkpoints_inicio = mysqli_fetch_array( $sql_checkpoints_inicio );
  if ( isset( $row_checkpoints_inicio ) ) {
    if ( isset( $_POST[ 'checkpoint' ] ) ) {
      $usuarios_checkpoint_actual = base64_decode( $_POST[ 'checkpoint' ] );
      if ( $usuarios_checkpoint_actual == $usuarios_checkpoint_siguiente ) {
        //Registratr Checkpoint QR
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
          mysqli_query( $mysqli, "UPDATE rally_usuarios_checkpoint SET usuarios_checkpoint_registrado = '1' WHERE usuarios_checkpoint_usuario = '$usuarios_checkpoint_usuario' AND usuarios_checkpoint_checkpoint = '$usuarios_checkpoint_checkpoint'" );
        }
      }
    }
  }
}
?>
<div class="div-cerrar-sesion"> <a id="id-a-cerrar-sesion" class="a-cerrar-sesion">
  <svg class="svg-cerrar-sesion" viewBox="0 0 512 512">
    <path d="M170.698,448H72.757c-4.814-0.012-8.714-3.911-8.725-8.725V72.725c0.012-4.814,3.911-8.714,8.725-8.725h97.941   c17.673,0,32-14.327,32-32s-14.327-32-32-32H72.757C32.611,0.047,0.079,32.58,0.032,72.725v366.549   C0.079,479.42,32.611,511.953,72.757,512h97.941c17.673,0,32-14.327,32-32S188.371,448,170.698,448z"/>
    <path d="M483.914,188.117l-82.816-82.752c-12.501-12.495-32.764-12.49-45.259,0.011s-12.49,32.764,0.011,45.259l72.789,72.768   L138.698,224c-17.673,0-32,14.327-32,32s14.327,32,32,32l0,0l291.115-0.533l-73.963,73.963   c-12.042,12.936-11.317,33.184,1.618,45.226c12.295,11.445,31.346,11.436,43.63-0.021l82.752-82.752   c37.491-37.49,37.491-98.274,0.001-135.764c0,0-0.001-0.001-0.001-0.001L483.914,188.117z"/>
  </svg>
  </a> </div>
<div id="id-div-rally" class="div-contenedor-inicio"> <img draggable="false" class="img-gif-animado" src="gif/telefono-inteligente.gif"> <span class="span-descripcion-hora">PRIMER PUNTO</span> 
  <!--<span class="span-descripcion-hora"> TIENES 3 HORAS</span>--> <span class="span-descripcion-punto">BUSCA Y ENCUENTRA EL C&Oacute;DIGO EN<br>
  <?php if(isset($row_checkpoints_disponible)) { echo  $row_checkpoints_disponible[ 'checkpoint_nombre' ]; } ?>
  </span>
  <form id="id-form-qr" method="post" enctype="multipart/form-data">
    <input id="id-input-qr" name="usuarios_checkpoint_checkpoint" type="hidden">
    <div style="width: 100%" id="reader" class="div-modulo-qr"></div>
  </form>
</div>
<script>
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
      location.replace("<?php echo $servidor_dominio; ?>");
    },
    error: function () {
      //Acción en caso de error
      //location.replace("../?e=<?php //echo base64_encode('usuario-registro-qr'); ?>");
      location.replace("<?php echo $servidor_dominio; ?>");
    }
  });
}

function onScanError(errorMessage) {
  //Error
}
var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
  fps: 10,
  qrbox: 250
});
html5QrcodeScanner.render(onScanSuccess, onScanError);
</script> 