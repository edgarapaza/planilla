<?php

class View
{
  public $mensaje;
  public $data;
  public $d1;
  public $d2;
  public $d3;

  function __construct()
  {
    #echo "<h1>View Base</h1>";
  }

  function Render($nombre)
  {
    require 'views/' . $nombre . '.php';
  }
}
