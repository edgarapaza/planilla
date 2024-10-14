<?php require ('views/headerSesion.php'); 
if($_SESSION['tipo']=='viewer'){
    header('location: ' . constant('URL') . 'main/');
}
?>

<script type="text/javascript">
    function Restas()
    {
        let rembasica = document.getElementById("remBasica").value;
        let remunific = document.getElementById("remReunificada").value;
        let ds        = document.getElementById("desupremo").value;
        let otros     = document.getElementById("otros");

        let resta = parseInt(rembasica,10) + parseInt(remunific,10) + parseInt(ds,10);
        console.log(resta);
        otros.value = resta;
    }
</script>

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

    <div class="grid-container margin-horizontal-1">
        <div class="grid-x margin-vertical-2">
            <div class="cell callout">
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
            <div class="cell callout">
                <form method="POST" class="grid-x large-up-2 grid-margin-x" id="planillaForm">
                    <div class="cell callout">
                        <div class="grid-x">
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="nombres">Nombres :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="" id="nombres" placeholder="Nombres"
                                        value="<?php echo @$this->data['nombres']; ?>" disabled>
                                        <input type="text" name="nombres" value="<?php echo @$this->data['nombres']; ?>"
                                        id="idpersonal" hidden>
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="apellidop" >Apellido Paterno :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="" id="apellidop" placeholder="Apellido paterno"
                                        value="<?php echo @$this->data['ap']; ?>" disabled>
                                        <input type="text" name="apellidopa" value="<?php echo @$this->data['ap']; ?>"
                                        id="idpersonal" hidden>

                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="apellidom" >Apellido Materno :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="" id="apellidom" placeholder="Apellido Materno"
                                        value="<?php echo @$this->data['am']; ?>" disabled>
                                        <input type="text" name="apellidoma" value="<?php echo @$this->data['am']; ?>" id="idpersonal" hidden>
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="cargo" >Cargo :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="cargo" id="cargo" placeholder="Cargo" value="">
                                </div>
                        </div>
                    </div>
                    <div class="cell callout">
                        <div class="grid-x">
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="fechaI" >Desde la Fecha :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="date" name="fechaI" id="fechaI" placeholder="12-12-1999">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="fechaF" >Hasta la Fecha :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="date" name="fechaF" id="fechaF" placeholder="12-12-2015">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="condicion" >Condicion :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <select id="condicion" name="condicion">
                                        <option value="A">Activo</option>
                                        <option value="P">Pensionista</option>
                                    </select>
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="moneda" >Moneda :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <select id="moneda" name="moneda">
                                        <option value="S">Nuevo Sol</option>
                                        <option value="I">Intis</option>
                                        <option value="O">Sol Oro</option>
                                    </select>
                                </div>


                        </div>
                    </div>
                    <div class="cell callout">
                        <div class="grid-x">
                                <div class="cell small-4 medium-4">
                                    <label class="texto-derecha" for="muc">Muc. :</label>
                                </div>
                                <div class="cell small-4 medium-8">
                                    <input type="text" name="muc" id="muc" placeholder="0.00" value="0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="vet">Vet. :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="vet" id="vet" placeholder="0.00" value="0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="remBasica">Rem. basica :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="remBasica" id="remBasica" value="0" placeholder="0.00">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="remReunificada">Rem. Reunificada :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="remReunificada" id="remReunificada" value="0" placeholder="0.00">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="desupremo">D. supremo 276 :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="desupremo" id="desupremo" value="0" placeholder="0.00">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="otros">Otros :</label>
                                </div>
                                <div class="cell small-12 medium-6">
                                    <input type="text" name="otros" id="otros" placeholder="0.00">
                                </div>
                                <div class="cell small-12 medium-2">
                                    <button type="button" name="btnCalcular" id="btnCalcular" onclick="Restas()">Calc</button>
                                </div>
                        </div>
                    </div>
                    <div class="cell callout">
                        <div class="grid-x">
                              <div class="cell small-12 medium-4">
                                  <label class="texto-derecha" for="ley19990" >Ley 19990 :</label>
                              </div>
                              <div class="cell small-12 medium-8">
                                    <input type="text" name="ley19990" id="ley19990" placeholder="00.0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="ley20530" >Ley 20530 :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="ley20530" id="ley20530" placeholder="00.0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="afp" >AFP :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="afp" id="afp" placeholder="00.0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="ipss" >IPSS :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="ipss" id="ipss" placeholder="00.0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="fonavi" >Fonavi :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="fonavi" id="fonavi" placeholder="00.0">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="trabajador" >Trabajador :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <select name="trabajador" id="trabajador">
                                        <option value="O">Obrero</option>
                                        <option value="E">Empleado</option>
                                    </select>
                                </div>

                        </div>
                        <div class="grid-x">
                            <div>
                                    <input type="text" name="idpersonal" value="<?php echo $_SESSION['idper']; ?>" id="idpersonal" placeholder="00.0" hidden>
                                    <input type="text" name="id" value="<?php echo $_SESSION['id']; ?>" id="id" placeholder="00.0" hidden>
                                </div>
                            <div class="cell small-12 medium-4">
                                <button type="submit" class="button">Actualizar</button>
                            </div>
                            <div class="cell small-12 medium-4">
                                <a href="<?php echo constant('URL')?>main/render" class="button warning">Ir a Menu</a>
                            </div>
                            <div class="cell small-12 medium-4">
                                <a href="<?php echo constant('URL')?>main/inicio" class="button info">Planillas</a>
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