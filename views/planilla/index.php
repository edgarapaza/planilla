<?php require ('views/headerSesion.php');
//echo 'ID: '.$_SESSION['idper']. '----Nombre: '.$_SESSION['katari'].'-->'.$_SESSION['tipo'];
if($_SESSION['tipo']=='viewer'){
    header('location: ' . constant('URL') . 'main/');
}
?>
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

/* Inicio de la planilla de pagos */
<div class="grid-container">
    <div class="grid-x">
        <div class="cell text-center titulo">
            <h4>CONST. DE PAGO DE HABERES Y DESCTOS. PARA RECONOCIMIENTOS DE TIEMPO DE SERVICIOS</h4>
        </div>
    </div>
    <form id="planillaForm" method="POST">
        <div class="grid-x grid-margin-x">
            <div class="cell callout small-12 large-6">
                        <div class="cell small-12 medium-2">
                            <label for="nombres">Nombres :</label>
                        </div>
                        <div class="cell small-12 medium-4">
                            <input type="text" name="nombres" id="nombres" placeholder="Nombres"
                                value="<?php echo @$this->data['nombres']; ?>">
                        </div>
                        <div class="cell small-12 medium-2">
                            <label for="apellidop">Apellido Paterno :</label>
                        </div>
                        <div class="cell small-12 medium-4">
                            <input type="text" name="apellidopa" id="apellidop" placeholder="Apellido paterno"
                                value="<?php echo @$this->data['ap']; ?>">
                        </div>
                        <div class="cell small-12 medium-2">
                            <label for="apellidom">Apellido Materno :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="apellidoma" id="apellidom" placeholder="Apellido Materno"
                                value="<?php echo @$this->data['am']; ?>">
                        </div>
                        <div class="cell small-12 medium-2">
                            <label for="cargo">Cargo :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="cargo" id="cargo" placeholder="Cargo"
                                value="<?php echo @$this->data['cargo']; ?>">
                        </div>
            </div>

            <div class="cell callout small-12 large-6">
                <div class="grid-x">
                    <div class="cell">
                        <span>
                            <label for="fechaI">Desde la Fecha :</label>
                            <input type="date" name="fechaI" id="fechaI" placeholder="12-12-1999">
                        </span>
                        <span>
                            <label for="fechaF">Hasta la Fecha :</label>
                            <input type="date" name="fechaF" id="fechaF" placeholder="12-12-2015">
                        </span>
                        <span>
                            <label for="condicion">Condicion :</label>
                            <select id="condicion" name="condicion">
                                <option value="A">Activo</option>
                                <option value="P">Pensionista</option>
                            </select>
                        </span>
                        <span>
                            <label for="moneda">Moneda :</label>
                            <select id="moneda" name="moneda">
                                <option value="S">Nuevo Sol</option>
                                <option value="I">Intis</option>
                                <option value="O">Sol Oro</option>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>

            <div class="cell callout">
                <div class="grid-x">
                    <div class="cell">
                        <span>
                            <label for="muc">Muc. :</label>
                            <input type="text" name="muc" id="muc" placeholder="0.00" value="0">
                        </span>
                        <span>
                            <label for="vet">Bet. :</label>
                            <input type="text" name="vet" id="vet" placeholder="0.00" value="0">
                        </span>
                        <span>
                            <label for="remBasica">Rem. basica :</label>
                            <input type="text" name="remBasica" id="remBasica" placeholder="0.00">
                        </span>
                        <span>
                            <label for="remReunificada">Rem. Reunificada :</label>
                            <input type="text" name="remReunificada" id="remReunificada" placeholder="0.00">
                        </span>
                        <span>
                            <label for="desupremo">D. supremo 276 :</label>
                            <input type="text" name="desupremo" id="desupremo" placeholder="0.00">
                        </span>
                        <span>
                            <label for="otros">Otros :</label>
                            <input type="text" name="otros" id="otros" placeholder="0.00">
                        </span>
                        <span id="total">
                            <label for="totalRemu">Total Remu :</label>
                            <input type="text" name="total" id="totalRemu" placeholder="0.00">
                        </span>
                    </div>
                </div>
            </div>
            <div class="cell callout">
                <div class="grid-x grid-margin-x">

                        <div class="cell small-12 medium-2">
                            <label for="ley19990">Ley 19990 :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="ley19990" id="ley19990" placeholder="00.0">
                        </div>
                        <div class="cell small-12 medium-4">
                            <label for="ley20530">Ley 20530 :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="ley20530" id="ley20530" placeholder="00.0">
                        </div>
                        <div class="cell small-12 medium-4">
                            <label for="afp">AFP :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="afp" id="afp" placeholder="00.0">
                        </div>
                        <div class="cell small-12 medium-4">
                            <label for="ipss">IPSS :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="ipss" id="ipss" placeholder="00.0">
                        </div>
                        <div class="cell small-12 medium-4">
                            <label for="fonavi">Fonavi :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <input type="text" name="fonavi" id="fonavi" placeholder="00.0">
                        </div>
                        <div class="cell small-12 medium-4">
                            <label for="trabajador">Trabajador :</label>
                        </div>
                        <div class="cell small-12 medium-8">
                            <select name="trabajador" id="trabajador">
                                <option value="O">Obrero</option>
                                <option value="E">Empleado</option>
                            </select>
                        </div>

                    <div class="cell">
                        <div class="grid-x align-spaced">
                            <input type="text" name="idpersonal" value="<?php echo $_SESSION['idper']; ?>"
                                id="idpersonal" placeholder="00.0" hidden>

                            <div class="cell small-3"><button type="submit" class="button success">GUARDAR TODO</button>
                            </div>
                            <div class="cell small-3"><a href="<?php echo constant('URL')?>main/render" class="button warning">Ir a Menu</a></div>
                            <div class="cell small-3"><a href="<?php echo constant('URL')?>main/inicio" class="button alert">Planillas</a></div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <script src="<?php echo constant('URL'); ?>public/js/planilla.js"></script>
</div>

<?php require ('views/footer.php'); ?>
