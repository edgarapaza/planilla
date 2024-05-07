<?php require ('views/header.php'); ?>
<link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
<div class="container full">
  <div class="grid-x large-up-2">
    <div class="cell formulario">
      <form method="POST" action="<?php echo constant('URL') ?>login/user" class="form-z">
        <div class="row">
          <h3 class="text-center">Bienvenido</h3>
          <div class="small-12 columns">
            <label>Usuario
              <input type="text" name="usuario" id="usuario" placeholder="" value="edgar">
            </label>
          </div>
          <div class="small-12 columns">
            <label>Contraseña
              <input type="password" name="passwd" id="passwd" placeholder="***" value="edgar">
            </label>
            <button type="submit" class="button">INGRESAR</button>
          </div>
        </div>
      </form>
      <small class="copyright">
        <span class=""> ©
          <script>
            document.write(new Date().getFullYear())
          </script>2024 KATARI SOFTWARE
        </span>
        Copyrigth Katari. Inc.
      </small>
    </div>
    <div class="cell imagen-z">
      <img src="https://www.tramites.transportespuno.gob.pe/img/mesadepartes.png" alt="">
    </div>
  </div>
</div>


<!-- <div class="row">
  <div class="medium-7 large-6 columns">
    <h1>Close Your Eyes and Open Your Mind</h1>
    <p class="subheader">There is beauty in space, and it is orderly. There is no weather, and there is regularity. It is predictable. Everything in space obeys the laws of physics. If you know these laws, and obey them, space will treat you kindly.</p>
    <button class="button">Take a Tour</button>
    <button class="button">Start a free trial</button>
  </div>

  <div class="show-for-large large-3 columns">
    <img src="https://placehold.it/400x370&text=PSR1257 + 12 C" alt="picture of space">
  </div>

  <div class="medium-5 large-3 columns">
    <div class="callout secondary">
      <form method="post" action="<?php echo constant('URL') ?>login/user">
        <div class="row">
          <div class="small-12 columns">
            <label>Usuario
              <input type="text" name="usuario" id="usuario" placeholder="" value="edgar">
            </label>
          </div>
          <div class="small-12 columns">
            <label>Password
              <input type="password" name="passwd" id="passwd" placeholder="***" value="edgar">
            </label>
            <button type="submit" class="button">Ingresar</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div> -->


<?php //require ('views/footer.php'); ?>