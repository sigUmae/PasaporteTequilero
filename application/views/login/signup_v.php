
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
        </svg> -->
        <!-- <span class="m-l inline">Pasaporte tequilero</span> -->
      </div>
    </div>

    <div class="p-lg panel md-whiteframe-z1 text-color m">
      <div class="m-b text-sm">
        Inscríbete a una cuenta
      </div>
      <form name="form" method="post" id="frm-crear">
        <div class="md-form-group">
          <input id="usuario" type="text" class="md-input" ng-model="user.name" required>
          <label>Usuario</label>
        </div>
        <div class="md-form-group">
          <input id="correo" type="email" class="md-input" ng-model="user.email" required>
          <label>Correo</label>
        </div>
        <div class="md-form-group">
          <input id="contrasena" type="password" class="md-input" ng-model="user.password" required>
          <label>Contraseña</label>
        </div>
        <div class="m-b-md">
          <label class="md-check">
            <input type="checkbox" ng-model="agree" required><i class="indigo"></i><a href="javascript:;"> Acepto los términos y condiciones</a>
          </label>
        </div>
        <button id="cuenta" md-ink-ripple type="submit" class="md-btn md-raised pink btn-block p-h-md">Crear cuenta</button>
      </form>
    </div>

    <div class="p-v-lg text-center">
      <div>
        ¿Ya tienes una cuenta?
        <a href="<?php echo base_url('/login')?>"><button ui-sref="access.signin" class="md-btn">Iniciar sesión</button></a> 
      </div>
    </div>
  </div>
</div>

</body>
</html>