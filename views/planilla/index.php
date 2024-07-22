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
<div class="grid-container">
    <div class="cell text-center titulo">
        <h4>CONST. DE PAGO DE HABERES Y DESCTOS. PARA RECONOCIMIENTOS DE TIEMPO DE SERVICIOS</h4>
    </div>
    <div class="">
        <form id="planillaForm" method="POST" class="grid-x large-up-2 grid-margin-x">
            <div class="cell callout">
                <div class="grid-x">
                    <div class="cell">
                        <span class="">
                            <label for="nombres" class="large-4">Nombres :</label>
                            <input type="text" name="nombres" id="nombres" placeholder="Nombres"
                                value="<?php echo @$this->data['nombres']; ?>">
                        </span>
                        <span>
                            <label for="apellidop" class="large-4">Apellido Paterno :</label>
                            <input type="text" name="apellidopa" id="apellidop" placeholder="Apellido paterno"
                                value="<?php echo @$this->data['ap']; ?>">
                        </span>
                        <span>
                            <label for="apellidom" class="large-4">Apellido Materno :</label>
                            <input type="text" name="apellidoma" id="apellidom" placeholder="Apellido Materno"
                                value="<?php echo @$this->data['am']; ?>">
                        </span>
                        <span>
                            <label for="cargo" class="large-4">Cargo :</label>
                            <input type="text" name="cargo" id="cargo" placeholder="Cargo"
                                value="<?php echo @$this->data['cargo']; ?>">
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
                            <label for="vet" class="large-4">Bet. :</label>
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
                        <span id="total">
                            <label for="totalRemu" class="large-4">Total Remu :</label>
                            <input type="text" name="total" id="totalRemu" placeholder="0.00">
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
                                <option value="O">Obrero</option>
                                <option value="E">Empleado</option>
                            </select>
                        </span>
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
    </div>
    <script src="<?php echo constant('URL'); ?>public/js/planilla.js"></script>
</div>

<?php require ('views/footer.php'); ?>
