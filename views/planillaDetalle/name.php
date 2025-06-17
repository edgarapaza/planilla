<?php require ('views/headerSesion.php');
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

    <div class="grid-container margin-horizontal-1">
        <div class="grid-x margin-vertical-2">
            <div class="cell callout">
                <div class="grid-x">
                    <div class="cell large-6">
                        <h2>Cambio de nombre: Registro de <?php echo $this->data['nombres']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="cell callout">
                <form method="POST" class="grid-x large-up-2 grid-margin-x" id="changeName">
                    <div class="cell callout">
                        <div class="grid-x">
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="nombres">Nombres :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="nombres" id="nombres" placeholder="Nombres" value="<?php echo @$this->data['nombres']; ?>" >

                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="apellidop" >Apellido Paterno :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="apellidop" id="apellidop" placeholder="Apellido paterno"
                                        value="<?php echo @$this->data['ap']; ?>" >

                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="apellidom" >Apellido Materno :</label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <input type="text" name="apellidom" id="apellidom" placeholder="Apellido Materno"
                                        value="<?php echo @$this->data['am']; ?>">
                                </div>
                                <div class="cell small-12 medium-4">
                                    <label class="texto-derecha" for="cargo" ></label>
                                </div>
                                <div class="cell small-12 medium-8">
                                    <button type="submit" class="button success">Cambiar datos</button>
                                </div>
                        </div>
                        <div class="grid-x">
                            <div class="cell small-12 medium-4">
                                <input type="hidden" name="idpersonal" value="<?php echo $_SESSION['idper']; ?>" id="idpersonal">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>" id="id">
                                <input type="hidden" name="codPersonal" id="codPersonal" value="<?php echo $this->data['id']; ?>">


                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="cell small-12 medium-4">
                                <a href="<?php echo constant('URL')?>main/render" class="button warning">Ir a Menu</a>
                            </div>
                            <div class="cell small-12 medium-4">
                                <a href="<?php echo constant('URL')?>main/inicio" class="button info">Volver a Planillas</a>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>

    </div>

<script src="<?php echo constant('URL') . 'public/js/planillaDetalle.js' ?>"></script>
</div>

<?php require ('views/footer.php'); ?>