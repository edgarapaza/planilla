<!doctype html>
<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo constant('COMPANY'); ?></title>
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo constant('URL');?>public/css/footer.css">
    <link rel="stylesheet" href="<?php echo constant('URL');?>public/css/buscar.css">

    <script src="<?php echo constant('URL'); ?>public/js/jquery.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/foundation.js"></script>
    <script src="<?php echo constant('URL'); ?>public/js/buscar.js"></script>
  </head>
  <body>

<!-- Navigation -->
<div class="title-bar" data-responsive-toggle="realEstateMenu" data-hide-for="small">
  <button class="menu-icon" type="button" data-toggle></button>
  <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="realEstateMenu">
  <div class="top-bar-left">
    <ul class="dropdown menu" data-dropdown-menu >
      <li class="menu-text"><span><?php echo constant('COMPANY'); ?></span></li>
      <li><a href="#">Ingresar planilla</a>
        <ul class="menu vertical">
          <li><a href="#">Nueva planilla</a></li>
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
        <a href="#">Usuario: <?php echo $_SESSION['katari'];?></a>
        <ul class="menu vertical">
          <li><a href="#">Configuración</a></li>
          <li><a href="#">Cambiar Contraseña</a></li>
          <li><hr></li>
          <li><a href="<?php echo constant('URL');?>salir">Salir</a></li>
        </ul>

      </li>

      <li><a href="<?php echo constant('URL');?>salir" class="button">Salir</a></li>
    </ul>
  </div>
</div>
<!-- /Navigation -->
