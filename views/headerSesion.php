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
    <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/inicio.css' ?>">
    <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation.css' ?>">
    <!-- FOUNDATION FLOAT -->
    <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation-float.css' ?>">
    <!-- Foundation prototipe-algunas interesantes opciones a utilizar-->
    <link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/foundation-prototype.css' ?>">
      <!-- ICONOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/footer.css">

    <script src="<?php echo constant('URL'); ?>public/js/jquery.js"></script>


</head>

<body>
    <div class="grid-container">

    </div>
    <div class="grid-x header-z">
        <div class="cell small-12 medium-2 large-2">
            <div class="img-t">
                <img class="logo-t" src="https://www.tramites.transportespuno.gob.pe/img/mesadepartes.png" alt="">
            </div>
        </div>

        <div class="cell small-12 medium-7 large-7">
            <div class="grid-x margin-top-1">
                <div class="cell large-12 text-center">
                    <!-- Menu -->
                    <ul class="menu align-center">
                      <li><a href="<?php echo constant('URL')?>main/render" class="">Ir al Inicio</a></li>
                      <li><a href="<?php echo constant('URL')?>main/inicio" class="">Ver listado de personal</a></li>
                      <li><a href="<?php echo constant('URL');?>planilla">Nueva planilla (Persona nueva)</a></li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="cell small-12 medium-2 large-2 margin-top-1">
            <div class="cell large-8" style="display:flex;">
                <p class="name-z">Bienvenido: <?php echo $_SESSION['katari']; ?></p>
            </div>
        </div>

        <div class="cell small-12 medium-1 large-1 margin-top-1">
            <ul class="menu align-center">
              <li><a href="<?php echo constant('URL'); ?>login/salir" class="salir">Salir</a></li>
            </ul>
        </div>
    </div>
    <!-- /Navigation -->