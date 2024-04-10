<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo constant('COMPANY'); ?></title>

  <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/foundation.css">
  <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/foundation-float.css">
  <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/foundation-prototype.css">
  <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/main.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@200;400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="<?php echo constant('URL'); ?>public/js/jquery.js"></script>
  <script src="<?php echo constant('URL'); ?>public/js/foundation.js"></script>

</head>

<body>

  <div class="header">
    <div class="header_logo">
      <span><?php echo constant('COMPANY'); ?></span>
      <a href="<?php echo constant('URL'); ?>main">
        <img src="<?php echo constant('URL'); ?>public/img/katari_med.png" alt="Logo Katari" width="60px" class="img-logo">
      </a>
    </div>
    <nav class="header_menu">
      <ul>
        <li><a href="<?php echo constant('URL'); ?>main">Inicio</a></li>
      </ul>
    </nav>
  </div>