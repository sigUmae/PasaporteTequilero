<?php 
  if ( !isset($_SERVER['HTTPS'])) {
    header('Location: https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']);
  }
?>
<?php echo $header; ?>
<div class="app green">
  <div class="center-block w-xxl w-auto-xs p-v-md">
    <div class="navbar">
      <div class="navbar-brand m-t-lg text-center logo-blanco"></div>
    </div>
    <div class="p-lg panel md-whiteframe-z1 text-color m">
      <div class="m-b">
        ¿Olvidaste tu contraseña?
        <p class="text-xs m-t">Ingresa tu correo y nosotros te enviarémos intrucciones de cómo recuperarla.</p>
      </div>
      <?php echo validation_errors(); ?>
      <form id="frm-recuperar" name="reset" method="post">
        <div class="md-form-group">
          <input id="correo" type="email" ng-model="email" class="md-input" required>
          <label>Correo</label>
        </div>
        <button md-ink-ripple type="submit" class="md-btn md-raised pink btn-block p-h-md" title="Hey!" data-content="Instructions sent to your email." data-type="info" data-container="#alerts-container" bs-alert  ng-disabled="reset.$invalid" >Enviar</button>
      </form>
    </div>
    <p id="alerts-container"></p>
    <div class="p-v-lg text-center">Regresar a
      <a href="<?php echo base_url('/login')?>">
        <button ui-sref="access.signin" class="md-btn">Iniciar sesión</button>
      </a>
    </div>
    <div class="espacio">
        Derechos Reservados 2015 <br> Sitio Desarrollado por bienTICS & Bridgestudio
    </div>
  </div>
</div>
</body>
</html>
