<?php

class Controller
{
  public $view;
  public $model;

  function __construct()
  {
    #echo "<h1>Controlador Base</h1>";
    $this->view = new View();
  }

  function loadModel($model)
  {
    $url = 'models/' . $model . "model.php";

    if (file_exists($url)) {

      require $url;

      $modelName = $model . 'Model';
      $this->model = new $modelName();
    }
  }
  // Validaciones--> Devuelve TRUE si la validacion es correcta
  public function validacionDatos($nombre = null, $apellido = null, $direccion = null, $dni = null, $email = null, $telefono = null, $sexo = null, $fecha = null, $descripcion = null, $texto = null, $numero = null,$numeros = null)
  {
      // fecha Formato YYYY-MM-DD
      $patronesValidos = array(
           // Este patrón valida que una cadena contenga solo caracteres alfabéticos (mayúsculas y minúsculas) del alfabeto español y los espacios en blanco.
          "caracteres" => "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/",
            //Este patrón valida que una cadena contenga caracteres alfanuméricos (mayúsculas y minúsculas), así como algunos caracteres especiales comunes y signos de puntuación.
          "textos" => "/^[A-Za-z0-9ÁÉÍÓÚáéíóúÜüÑñ\s.,;:¡!¿?@#$%^&*()-_+=<>]+$/",
          //Este patrón valida que una cadena contenga exactamente 8 dígitos numéricos.
          "dni" => "/^[0-9]{8}$/",
          //Este patrón valida que una cadena tenga el formato de una dirección de correo electrónico válida. Utiliza una expresión regular para validar la estructura básica de una dirección de correo electrónico.
          "email" =>  "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/",
          //Este patrón valida que una cadena contenga solo dígitos numéricos, así como algunos caracteres especiales comunes utilizados en números de teléfono (como ()+-).
          "telefono" => "/^[0-9()+-]+$/",
          //Este patrón valida que una cadena tenga el formato de fecha YYYY-MM-DD (año-mes-día). Requiere que la cadena tenga exactamente 10 caracteres y que los primeros 4 caracteres sean dígitos para el año, seguidos de un guión, luego 2 dígitos para el mes, otro guión, y finalmente 2 dígitos para el día.
          "fecha" => "/^\d{4}-\d{2}-\d{2}$/",
          "genero" => ["masculino", "femenino"],
          //Este patrón valida que una cadena contenga solo dígitos numéricos, permitiendo opcionalmente un punto decimal seguido de uno o más dígitos, lo que permite números enteros y flotantes.
          "numeros" => "/^[0-9]+(?:\.[0-9]+)?$/",
      );
      $validacion = array();
      if ($nombre == !null) {
          $patronCoincidencia = preg_match($patronesValidos['caracteres'], $nombre);
          if ($patronCoincidencia && strlen($nombre) < 50) {
              $validacion["nombre"] = true;
          } else {
              $validacion["nombre"] = false;
          }
      }
      if ($apellido == !null) {
          $patronCoincidencia = preg_match($patronesValidos['caracteres'], $apellido);
          if ($patronCoincidencia && strlen($apellido) < 100) {
              $validacion["apellido"] = true;
          } else {
              $validacion["apellido"] = false;
          }
      }
      if ($direccion == !null) {
          $patronCoincidencia = preg_match($patronesValidos['textos'], $direccion);
          if ($patronCoincidencia && strlen($direccion) < 45) {
              $validacion["direccion"] = true;
          } else {
              $validacion["direccion"] = false;
          }
      }
      if ($dni == !null) {
          $patronCoincidencia = preg_match($patronesValidos['dni'], $dni);
          if ($patronCoincidencia && strlen($dni) < 9) {
              $validacion["dni"] = true;
          } else {
              $validacion["dni"] = false;
          }
      }
      if ($email == !null) {
          $patronCoincidencia = preg_match($patronesValidos['email'], $email);
          if ($patronCoincidencia && strlen($email) < 80) {
              $validacion["email"] = true;
          } else {
              $validacion["email"] = false;
          }
      }
      if ($telefono == !null) {
          $patronCoincidencia = preg_match($patronesValidos['telefono'], $telefono);
          if ($patronCoincidencia && strlen($telefono) < 15) {
              $validacion["telefono"] = true;
          } else {
              $validacion["telefono"] = false;
          }
      }
      if ($sexo == !null) {
          $patronCoincidencia = in_array($sexo, $patronesValidos['genero']);
          if ($patronCoincidencia && strlen($sexo) < 10) {
              $validacion["sexo"] = true;
          } else {
              $validacion["sexo"] = false;
          }
      }
      if ($fecha == !null) {
          $fechaStr = strtotime($fecha);
          $anio = date('Y', $fechaStr);
          $patronCoincidencia = preg_match($patronesValidos['fecha'], $fecha);
          if ($patronCoincidencia) {
              $validacion["fecha"] = true;
          } else {
              $validacion["fecha"] = false;
          }
      }
      if ($descripcion == !null) {
          $patronCoincidencia = preg_match($patronesValidos['textos'], $descripcion);
          if ($patronCoincidencia && strlen($descripcion) < 200) {
              $validacion["descripcion"] = true;
          } else {
              $validacion["descripcion"] = false;
          }
      }
      if ($texto == !null) {
          $patronCoincidencia = preg_match($patronesValidos['textos'], $texto);
          if ($patronCoincidencia && strlen($texto) < 100) {
              $validacion["texto"] = true;
          } else {
              $validacion["texto"] = false;
          }
      }
      if ($numero == !null) {
          $patronCoincidencia = preg_match($patronesValidos['numeros'], $numero);
          if ($patronCoincidencia && strlen($numero) < 15) {
              $validacion["numero"] = true;
          } else {
              $validacion["numero"] = false;
          }
      }
      if ($numeros == !null) {
        $list = array();
        for ($i = 0; $i < count($numeros); $i++) {
            $patronCoincidencia = preg_match($patronesValidos['numeros'], $numeros[$i]);
            if ($patronCoincidencia && strlen($numeros[$i]) < 15) {
                $list['num'.$i] = true; 
            } else {
                $list['num'.$i] = false; 
            }
        }
        $result1 = count(array_unique(array_values($list)));
        $valorTrue1 = array_unique(array_values($list));
        if (in_array(true, $valorTrue1) && $result1 === 1) {
            $validacion["numeros"] = true;
        } else {
            $validacion["numeros"] = false;
        }
    }
      // cuenta los valores repetidos de un array- colo debe existir 1: true o false
      $result = count(array_unique(array_values($validacion)));
      //verigica el valor que se repite en el array: solo debe ser entre true y false
      $valorTrue = array_unique(array_values($validacion));
      // echo var_dump($validacion) . "<br>";
      if (in_array(true, $valorTrue) && $result === 1) {
          //echo "bien validado";
          return true;
      } else {
          //echo "validacion incorrecta";
          return false;
      }
  }
}
