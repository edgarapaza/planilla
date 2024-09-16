<?php require ('views/headerSesion.php');
?>

<input type="text" name="tipo" id="tipo" value="<?php echo $_SESSION['tipo']?>" hidden style="display: none;">

<div class="grid-container">
  <div class="grid-x">
    <div class="cell">
      <h2>Datos del trabajador</h2>
      <p>Nombre: nombre del trabajador </p>
      <p>Cargo: mi cargo</p>
    </div>
  </div>

  <form action="">
    <div class="grid-x grid-margin-x">
      <div class="cell small-12 medium-4">
          <label for="fechaInicio">Fecha Inicial (Obligatorio)</label>
          <input type="date" name="fechaInicio" id="fechaInicio" required>
      </div>
      <div class="cell small-12 medium-4">
          <label for="fechaFinal">Fecha Final (Obligatorio)</label>
          <input type="date" name="fechaFinal" id="fechaFinal" required>
          <input type="text" name="idpersonal" id="idpersonal" value="<?php echo $this->datos;?>">
      </div>
      <div class="cell small-12 medium-4">
          <button type="submit" class="button" name="btnImprimir" id="btnImprimir">Imprimir planilla</button>
      </div>
    </div>
  </form>

  <div class="grid-x">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  </div>
</div>

<script src="<?php echo constant('URL') . 'public/js/main.js'; ?>"></script>
<?php require ('views/footer.php'); ?>
