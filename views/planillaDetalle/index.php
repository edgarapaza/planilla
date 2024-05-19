<?php require ('views/headerSesion.php'); ?>
<link rel="stylesheet" href="<?php echo constant('URL') . 'public/css/planilla.css' ?>">
<div class="modal-overlay">
    <div class="modal">
        <div class="callout text-center">
            <h2 id="title-modal"></h2>
            <img src="" alt="modal-img" class="img-modal" id="img-modal">
            <p id="text-modal">Contenido de la ventana modal aquí</p>
            <a href="<?php echo constant('URL') . 'impresion/pdf/' . @$this->data['id']?>" class="pdf" id="pdf" target="_blank" style="display: none;">pdf</a>
            <button class="close-modal">Cerrar</button>
        </div>
    </div>
</div>
<div class="grid-container full margin-horizontal-1">
    <div class="grid-x margin-vertical-2">
        <div class="cell">
            <div class="grid-x">
                <div class="cell large-6">
                    <h2>Registro de <?php echo $this->data['nombres']; ?></h2>
                </div>
                <div class="cell large-3 padding-horizontal-1">
                    Mes
                    <!-- <input type="text" name="mes" id="mes" maxlength="2"> -->
                    <select name="mes" id="mes">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="cell large-3">
                    Año
                    <!-- SE DEBE PRESIONAR ENTER PARA CAPTAR EL EVENTO CON JAVASCRIPT -->
                    <input type="text" name="anio" id="anio" maxlength="4">
                </div>
            </div>

        </div>
        <div class="cell">
            <form method="POST" class="grid-x large-up-2 grid-margin-x" id="planillaForm">
                <div class="cell callout">
                    <div class="grid-x">
                        <div class="cell">
                            <span class="">
                                <label for="nombres" class="large-4">Nombres :</label>
                                <input type="text" name="" id="nombres" placeholder="Nombres"
                                    value="<?php echo @$this->data['nombres']; ?>" disabled>
                                    <input type="text" name="nombres" value="<?php echo @$this->data['nombres']; ?>"
                                    id="idpersonal" hidden>
                            </span>
                            <span>
                                <label for="apellidop" class="large-4">Apellido Paterno :</label>
                                <input type="text" name="" id="apellidop" placeholder="Apellido paterno"
                                    value="<?php echo @$this->data['ap']; ?>" disabled>
                                    <input type="text" name="apellidopa" value="<?php echo @$this->data['ap']; ?>"
                                    id="idpersonal" hidden>
                                    
                            </span>
                            <span>
                                <label for="apellidom" class="large-4">Apellido Materno :</label>
                                <input type="text" name="" id="apellidom" placeholder="Apellido Materno"
                                    value="<?php echo @$this->data['am']; ?>" disabled>
                                    <input type="text" name="apellidoma" value="<?php echo @$this->data['am']; ?>" id="idpersonal" hidden>
                            </span>
                            <span>
                                <label for="cargo" class="large-4">Cargo :</label>
                                <input type="text" name="cargo" id="cargo" placeholder="Cargo" value="">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="cell callout">
                    <div class="grid-x">
                        <div class="cell">
                            <span>
                                <label for="fechaI" class="large-4">Desde la Fecha :</label>
                                <input type="date" name="fechaI" id="fechaI" placeholder="12-12-1999">
                            </span>
                            <span>
                                <label for="fechaF" class="large-4">Hasta la Fecha :</label>
                                <input type="date" name="fechaF" id="fechaF" placeholder="12-12-2015">
                            </span>
                            <span>
                                <label for="condicion" class="large-4">Condicion :</label>
                                <select id="condicion" name="condicion">
                                    <option value="A">Activo</option>
                                    <option value="P">Pensionista</option>
                                    <option value="S">S</option>
                                    <option value="NA">NA</option>
                                </select>
                            </span>
                            <span>
                                <label for="moneda" class="large-4">Moneda :</label>
                                <select id="moneda" name="moneda">
                                    <option value="S">Nuevo Sol</option>
                                    <option value="I">Intis</option>
                                    <option value="O">Sol Oro</option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="cell callout">
                    <div class="grid-x">
                        <div class="cell">
                            <span>
                                <label for="muc" class="large-4">Muc. :</label>
                                <input type="text" name="muc" id="muc" placeholder="0.00" value="0">
                            </span>
                            <span>
                                <label for="vet" class="large-4">Vet. :</label>
                                <input type="text" name="vet" id="vet" placeholder="0.00" value="0">
                            </span>
                            <span>
                                <label for="remBasica" class="large-4">Rem. basica :</label>
                                <input type="text" name="remBasica" id="remBasica" placeholder="0.00">
                            </span>
                            <span>
                                <label for="remReunificada" class="large-4">Rem. Reunificada :</label>
                                <input type="text" name="remReunificada" id="remReunificada" placeholder="0.00">
                            </span>
                            <span>
                                <label for="desupremo" class="large-4">D. supremo 276 :</label>
                                <input type="text" name="desupremo" id="desupremo" placeholder="0.00">
                            </span>
                            <span>
                                <label for="otros" class="large-4">Otros :</label>
                                <input type="text" name="otros" id="otros" placeholder="0.00">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="cell callout">
                    <div class="grid-x grid-margin-x">
                        <div class="cell">
                            <span>
                                <label for="ley19990" class="large-4">Ley 19990 :</label>
                                <input type="text" name="ley19990" id="ley19990" placeholder="00.0">
                            </span>
                            <span>
                                <label for="ley20530" class="large-4">Ley 20530 :</label>
                                <input type="text" name="ley20530" id="ley20530" placeholder="00.0">
                            </span>
                            <span>
                                <label for="afp" class="large-4">AFP :</label>
                                <input type="text" name="afp" id="afp" placeholder="00.0">
                            </span>
                            <span>
                                <label for="ipss" class="large-4">IPSS :</label>
                                <input type="text" name="ipss" id="ipss" placeholder="00.0">
                            </span>
                            <span>
                                <label for="fonavi" class="large-4">Fonavi :</label>
                                <input type="text" name="fonavi" id="fonavi" placeholder="00.0">
                            </span>
                            <span>
                                <label for="trabajador" class="large-4">Trabajador :</label>
                                <select name="trabajador" id="trabajador">
                                    <option value="O">O</option>
                                    <option value="E">E</option>
                                    <option value="0">0</option>
                                    <option value="NA">NA</option>
                                </select>
                            </span>
                        </div>
                        <div class="cell">
                            <div class="grid-x align-spaced">
                                <input type="text" name="idpersonal" value="<?php echo $_SESSION['idper']; ?>"
                                    id="idpersonal" placeholder="00.0" hidden>
                                
                                <div class="cell small-3"><button type="submit" class="button success">Actualizar</button>
                                </div>
                                <div class="cell small-3"><a href="<?php echo constant('URL')?>main/render" class="button warning">Ir a Menu</a></div>
                            <div class="cell small-3"><a href="<?php echo constant('URL')?>main/inicio" class="button alert">Planillas</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="grid-x">
    <div class="cell large-12">
      <h4>Registros de todas sus planillas</h4>
      <table>
        <thead>
          <tr>
            <th>Num</th>
            <th>Nombre y apellidos</th>
            <th>Cargo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <th>Ingreso</th>
            <th colspan="2">Impresion</th>
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
    </div>
  </div>
    <script src="<?php echo constant('URL') . 'public/js/planillaDetalle.js' ?>"></script>
</div>

<?php require ('views/footer.php'); ?>