<?php require ('views/headerSesion.php'); 
//echo 'ID: '.$_SESSION['idper']. '----Nombre: '.$_SESSION['katari'].'-->'.$_SESSION['tipo'];
?>

<link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/buscar.css">
<input type="text" name="tipo" id="tipo" value="<?php echo $_SESSION['tipo']?>" hidden style="display: none;">
<div class="grid-container full margin-1">
  <div class="grid-x margin-vertical-1 large-up-4">
    <div class="cell">
      <h5>Busqueda por nombres</h5>
      <div class="search-zeta">
        <div class="search active" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch').value = ''"></span>
        </div>
      </div>
    </div>
    <div class="cell">
      <h5>Busqueda por apellido paterno</h5>
      <div class="search-zeta">
        <div class="search active" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch1" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch1').value = ''"></span>
        </div>
      </div>
    </div>
    <div class="cell">
      <h5>Busqueda por apellido materno</h5>
      <div class="search-zeta">
        <div class="search active" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch2" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch2').value = ''"></span>
        </div>
      </div>
    </div>
    <div class="cell">
      <h5>Busqueda por cargo</h5>
      <div class="search-zeta">
        <div class="search active" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch3" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch3').value = ''"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="grid-x">
    <div class="cell large-12">
      <div class="cell">
      <h4>Registros</h4>
      <a href="<?php echo constant('URL');?>planilla" class="button success">Nueva Planilla</a>
      </div>
      <table class="text-center">
        <thead>
          <tr>
            <th class="text-center">Num</th>
            <th class="text-center">Nombre y apellidos</th>
            <th class="text-center">Cargo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <?php if($_SESSION['tipo']!='viewer'){?>
            <th class="text-center">Ingreso</th>
            <?php }?>
            <th class="text-center" colspan="2">Impresion</th>
          </tr>
        </thead>
        <tbody id="datos">
          <tr>
            <td>1</td>
            <td>Juan Carlos Tolima Cruz</td>
            <td>Tec. Admin III</td>
            <td>1978</td>
            <td>2023</td>
            <td>
              <a href="#" class="button">Ingresar Planilla</a> |
              <a href="#" class="button">Editar</a>
            </td>
            <td>
              <a href="#" class="button success">Planilla</a>
              <a href="#" class="button success">FONAVI</a>
            </td>
          </tr>
        </tbody>
      </table>
      <div id="paginacion"></div>
    </div>
  </div>
</div>
<script src="<?php echo constant('URL') . 'public/js/main.js'; ?>"></script>
<?php require ('views/footer.php'); ?>