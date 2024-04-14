<?php
session_start();
class Salir extends Controller
{

  function __construct()
  {
    parent::__construct();
  }

  function render()
  {
    session_destroy();
    $_SESSION['katari'] = "";
    $this->view->Render('login/index');
  }
}
