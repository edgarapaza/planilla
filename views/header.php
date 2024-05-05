<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo constant('COMPANY'); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- FOUNDATION CSS-PRINCIPAL Y NECESARIO -->
  <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation.css' ?>">
  <!-- FOUNDATION FLOAT -->
  <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation-float.css' ?>">
  <!-- Foundation prototipe-algunas interesantes opciones a utilizar-->
  <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation-prototype.css' ?>">

  <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/footer.css">

  <script src="<?php echo constant('URL'); ?>public/js/jquery.js"></script>


</head>

<body>
  <!-- <div class="top-bar" id="realEstateMenu">
    <div class="top-bar-left">
      <ul class="dropdown menu" data-dropdown-menu>
        <li class="menu-text"><span><?php echo constant('COMPANY'); ?></span></li>
        <li><a href="#">Ingresar planilla</a>
          <ul class="menu vertical">
            <li><a href="<?php echo constant('URL') . 'planilla' ?>">Nueva planilla</a></li>
            <li><a href="#">Editar Planilla</a></li>
            <li><a href="#">Listar Planilla</a></li>
            <li><a href="#">Imprimir Planilla</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="top-bar-right">
      <ul class="dropdown menu" data-dropdown-menu>
        <li>
          <a href="#">Usuario: <?php echo $_SESSION['katari']; ?></a>
          <ul class="menu vertical">
            <li><a href="#">Configuración</a></li>
            <li><a href="#">Cambiar Contraseña</a></li>
            <li>
              <hr>
            </li>
            <li><a href="<?php echo constant('URL'); ?>salir">Salir</a></li>
          </ul>

        </li>

        <li><a href="<?php echo constant('URL'); ?>salir" class="button">Salir</a></li>
      </ul>
    </div>
  </div> -->
  <div class="grid-x header-z">
    <div class="cell large-3">
      <div class="img-t">
        <img class="logo-t" src="https://www.tramites.transportespuno.gob.pe/img/mesadepartes.png" alt="">
      </div>
    </div>
    <div class="cell large-6">
      <div class="grid-x margin-top-1">
        <div class="cell large-4 text-center">
          <p class="lead">
            Servicios Prestados
          </p>
        </div>
        <div class="cell large-4 text-center">
          <p class="lead">
            Aportaciones Fonavi
          </p>
        </div>
        <div class="cell large-4 text-center">
          <p class="lead">
            Liquidaciones
          </p>
        </div>
      </div>
    </div>
    <div class="cell large-3 margin-top-1">
      <div class="grid-x large-up-6 align-spaced">
        <a href="<?php echo constant('URL'); ?>inicio/login" class="ingresar">Ingresar</a>
        <button class="button-register">Registrarse</button>
      </div>
    </div>
  </div>
  <!-- /Navigation -->