<div class="div-cabezal-imagen" style="background-image: url('<?php $a = array('jpg/cabezal-01.jpg','jpg/cabezal-02.jpg','jpg/cabezal-03.jpg'); echo $a[array_rand($a)];?>')">&nbsp;</div>
<div id="id-div-inicio" class="div-contenedor-inicio"><span class="span-titulo">RALLY</span><span class="span-subtitulo">Museos Puebla</span><a id="id-a-iniciar" class="a-boton-inicia hvr-skew-forward">Ingresar<a id="id-a-registro" class="a-boton-inicia hvr-skew-forward">Registro</a>
  <div class="div-contenedor-inicio-b">
    <video class="div-contenedor-video" autoplay="autoplay" loop="loop" muted playsinline>
      <source src="mp4/edificio.mp4" type="video/mp4">
    </video>
    <div class="div-contenedor-inicio-c"> <span class="span-subtitulo-b">Museos Participantes</span>
      <div class="g-scrolling-carousel carousel">
        <div class="items"><a href="#" style="background-image: url('jpg/slider-01.jpg')">&nbsp;</a><a href="#" style="background-image: url('jpg/slider-02.jpg')">&nbsp;</a><a href="#" style="background-image: url('jpg/slider-03.jpg')">&nbsp;</a></div>
      </div>
    </div>
  </div>
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<div class="div-pie-principal">&nbsp;</div>
<div id="id-div-registro" class="div-contenedor-registro div-oculto"> <span class="span-descripcion">Reg&iacute;strate Aqu&iacute;</span>
  <form id="id-form-registro" method="post" enctype="multipart/form-data">
    <input id="id-usuarios-nombre" name="usuarios_nombre" class="input-registro" type="text" placeholder="Nombre">
    <input id="id-usuarios-email" name="usuarios_email" class="input-registro" type="email" placeholder="Email">
    <input id="id-usuarios-celular" name="usuarios_celular" class="input-registro" type="number" placeholder="Teléfono">
    <input id="id-usuarios-contrasena" name="usuarios_contrasena" class="input-registro" type="password" placeholder="Contrase&ntilde;a">
    <div class="div-checkbox">
      <div class="checkbox-wrapper-12">
        <div class="cbx">
          <input id="cbx-12" type="checkbox"/>
          <label for="cbx-12"></label>
          <svg width="15" height="14" viewbox="0 0 15 14" fill="none">
            <path d="M2 8.36364L6.23077 12L13 2"></path>
          </svg>
        </div>
        <svg>
          <defs>
            <filter id="goo-12">
              <fegaussianblur in="SourceGraphic" stddeviation="4" result="blur"></fegaussianblur>
              <fecolormatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12"></fecolormatrix>
              <feblend in="SourceGraphic" in2="goo-12"></feblend>
            </filter>
          </defs>
        </svg>
      </div>
      <div id="id-usuarios-aviso" class="div-checkbox-text">Acepto haber le&iacute;do y estar de acuerdo con el Aviso de Privacidad.</div>
    </div>
    <input class="a-boton-inicia hvr-skew-forward" type="submit" value="Registrarme">
  </form>
  <input class="input-registro-volver hvr-skew-forward" type="submit" value="Volver a Inicio">
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<div id="id-div-logueo" class="div-contenedor-logueo div-oculto"><span class="span-descripcion">¡Hola!</span>
  <form id="id-form-logueo" method="post" enctype="multipart/form-data">
    <input id="id-usuarios-email-logueo" name="usuarios_email" class="input-registro" type="email" placeholder="Email">
    <input id="id-usuarios-contrasena-logueo" name="usuarios_contrasena" class="input-registro" type="password" placeholder="Contrase&ntilde;a">
    <input id="id-input-ingresar" class="a-boton-inicia hvr-skew-forward" type="submit" value="Ingresar">
  </form>
  <input class="input-registro-volver hvr-skew-forward" type="submit" value="Volver a Inicio">
  <div class="div-contenedor-inicio-d">&nbsp;</div>
</div>
<script>

  $(document).ready(function(){
    $(".g-scrolling-carousel .items").gScrollingCarousel({
  mouseScrolling: true,
  scrollAmount: 'viewport',
  draggable: true,
  snapOnDrag: true,
  mobileNative: true,
});
  });

  </script>