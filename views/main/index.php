<?php require ('views/header.php'); ?>

<link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/buscar.css">
<div class="grid-container full margin-1">
  <!-- <div class="grid-x">
    <div class="cell small-12">
      <div class="input-group searchbar">
        <div class="input-group-button">
          <button class="button search">
            <svg width="100" height="100" viewBox="0 0 100 100">
              <path fill="#FFF" fill-rule="evenodd"
                d="M42.117,12.246 C50.1209,12.246 57.797,15.4257 63.453,21.0858 C69.1132,26.742 72.2928,34.4178 72.2928,42.4218 C72.2928,50.4258 69.1131,58.1018 63.453,63.7578 C57.7968,69.418 50.121,72.5976 42.117,72.5976 C34.1131,72.5976 26.437,69.4179 20.781,63.7578 C15.1208,58.1016 11.9412,50.4258 11.9412,42.4218 C11.9412,34.4178 15.1209,26.7418 20.781,21.0858 C26.4372,15.4256 34.113,12.246 42.117,12.246 L42.117,12.246 Z M76.0828827,67.3362833 C82.3527829,58.7859894 85.2617455,48.0434678 83.9173,37.22271 C82.0618,22.28871 72.3743,9.47671 58.5153,3.61771 L58.51139,3.61771 C53.32389,1.41851 47.74139,0.28961 42.10539,0.29741 L42.117,0.305 C29.058,0.30891 16.742,6.3675 8.769001,16.707 C0.7924008,27.047 -1.933999,40.5 1.382301,53.129 C4.698701,65.758 13.6833,76.137 25.7103,81.223 L25.7103,81.22691 C39.5733,87.08631 55.5113,85.10191 67.5153,76.02771 C67.5852345,75.9748392 67.6549736,75.9217748 67.724517,75.8685177 L91.555,99.6990032 L100.0003,91.253703 L76.0828827,67.3362833 Z" />
            </svg>
          </button>
        </div>
        <input class="input-field search-field" type="search" id="search" placeholder="Escribe un nombre o apellido..." />
      </div>
    </div>
  </div> -->
  <div class="grid-x margin-vertical-1 large-up-4">
    <div class="cell">
      <h5>Busqueda por nombres</h5>
      <div class="search-zeta">
        <div class="search" id="search">
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
        <div class="search" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch1" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch').value = ''"></span>
        </div>
      </div>
    </div>
    <div class="cell">
      <h5>Busqueda por apellido materno</h5>
      <div class="search-zeta">
        <div class="search" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch2" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch').value = ''"></span>
        </div>
      </div>
    </div>
    <div class="cell">
      <h5>Busqueda por cargo</h5>
      <div class="search-zeta">
        <div class="search" id="search">
          <div class="icon" id="icon"></div>
          <div class="input">
            <input type="text" placeholder="Search" id="mysearch3" class="input-zeta">
          </div>
          <span class="clear" onclick="document.getElementById('mysearch').value = ''"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="grid-x">
    <div class="cell large-12">
      <h4>Registros</h4>
      <table>
        <thead>
          <tr>
            <th>Num</th>
            <th>Nombre y apellidos</th>
            <th>Cargo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <th>Ingreso</th>
            <th>Impresion</th>
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
              <a href="#" class="button success">Liquidacion</a>
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