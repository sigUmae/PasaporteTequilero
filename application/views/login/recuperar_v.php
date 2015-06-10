<?php echo $header; ?>
<div class="app green">
  <div class="center-block w-xxl w-auto-xs p-v-md">
    <div class="navbar">
      <div class="navbar-brand m-t-lg text-center logo-blanco">
        <!-- <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" style="
                width: 24px; height: 24px;">
          <path d="M 50 0 L 100 14 L 92 80 Z" fill="rgba(139, 195, 74, 0.5)"></path>
          <path d="M 92 80 L 50 0 L 50 100 Z" fill="rgba(139, 195, 74, 0.8)"></path>
          <path d="M 8 80 L 50 0 L 50 100 Z" fill="#fff"></path>
          <path d="M 50 0 L 8 80 L 0 14 Z" fill="rgba(255, 255, 255, 0.6)"></path>
        </svg>
        <span class="m-l inline">Pasaporte tequilero</span> -->
      </div>
    </div>
    <div class="p-lg panel md-whiteframe-z1 text-color m">
      <div class="m-b">
        Recuperación de cuenta
        <p class="text-xs m-t">Ingresa una nueva contraseña</p>
      </div>
      <?php echo validation_errors(); ?>
      <form id="frm-nuevo-contrasena" name="reset" method="post">
        <div class="md-form-group">
          <input id="contrasena" type="password" class="md-input" ng-model="user.password" required="">
          <label>Contraseña</label>
        </div>
        <div class="md-form-group">
          <input id="contrasena-confirmar" type="password" class="md-input" ng-model="user.password" required="">
          <label>Confirmar contraseña</label>
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
  </div>
</div>
<script type="text/javascript"> var token = '<?php echo $token;?>';</script>
</body>
</html>