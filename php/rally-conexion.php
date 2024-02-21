<?php
$academy_host = 'localhost';
$academy_usuario = 'bluefoox_user';
$academy_contrasena = '#o6AtIGasw0*h*W=Cane';
$academy_basedatos = 'bluefoox_rallymuseos';
$mysqli = new mysqli( $academy_host, $academy_usuario, $academy_contrasena, $academy_basedatos );
$mysqli->set_charset( "utf8" );
$protocolo_temp = stripos( $_SERVER[ 'SERVER_PROTOCOL' ], 'https' ) === true ? 'https://' : 'http://';
$protocolo = 'https://';
$dominio = $_SERVER[ 'HTTP_HOST' ];
$carpeta = '/rallymuseos';
$servidor_dominio = $protocolo . $dominio . $carpeta;
date_default_timezone_set( 'America/Mexico_City' );
set_time_limit( 0 );
error_reporting( 0 );
?>