<?php echo $header; ?>
    <div class="app">  
      <!-- aside -->
      <aside id="aside" class="app-aside modal fade " role="menu">
        <div class="left">
          <div class="box bg-white">
            <div class="navbar md-whiteframe-z1 no-radius blue">
                <a class="navbar-brand logo-blanco"></a>
            </div>
            <div class="box-row">
              <div class="box-cell scrollable hover">
                <div class="box-inner">
                  <div class="p hidden-folded blue-50" style="background-image:url(images/bg.png); background-size:cover">
                    <div class="rounded w-64 bg-white inline pos-rlt">
                      <img src="<?php echo base_url('assets/images')."/".$avatar?>" class="img-responsive rounded">
                    </div>
                    <a class="block m-t-sm" ui-toggle-class="hide, show" target="#nav, #account">
                      <span class="block font-bold">Usuario</span>
                      <span class="pull-right auto">
                        <i class="fa inline fa-caret-down"></i>
                        <i class="fa none fa-caret-up"></i>
                      </span>
                      pasaportetequilero1@gmail.com
                    </a>
                  </div>
                  <div id="nav">
                    <nav ui-nav>
                      <ul class="nav">
                       <?php foreach ($menu_1 as $menu_1v) { ?>
                          <li>
                          <?php if ($menu_1v->c_menu != 0) {  ?>
                            <a md-ink-ripple href>
                              <span class="pull-right text-muted">
                                <i class="fa fa-caret-down"></i>
                              </span>
                              <i class="icon mdi-content-sort i-20"></i>
                              <span><?php echo $menu_1v->menu_1;?></span>
                            <?php if ($menu_1v->c_menu != 0) { ?>
                              <ul class="nav nav-sub">
                              <?php foreach ($menu_2 as $menu_2v) { ?>
                                <li>
                                <?php if ($menu_2v->id_menu1 == $menu_1v->id) { 
                                  if ($menu_2v->c_menu != 0) { ?>
                                  <a md-ink-ripple href>
                                    <span class="pull-right text-muted">
                                      <i class="fa fa-caret-down"></i>
                                    </span>
                                    <span class="font-normal"><?php echo $menu_2v->menu_2;?></span>
                                  </a>
                                  <ul class="nav nav-sub">
                                <?php foreach ($menu_3 as $menu_3v) { ?>
                                    <li>
                                      <?php if ($menu_3v->id_menu2 == $menu_2v->id) { ?>
                                      <a md-ink-ripple href="<?php echo base_url().$menu_3v->url?>">
                                        <?php echo $menu_3v->menu_3;?>
                                      </a>
                                      <?php } ?>
                                    </li>
                                <?php } ?>
                                  </ul>
                                <?php } else { ?>
                                  <a md-ink-ripple href="<?php echo base_url().$menu_2v->url?>">
                                    <?php echo $menu_2v->menu_2;?>
                                  </a>
                                <?php } 
                                  } ?>
                                </li>
                              <?php } ?>
                              </ul>
                            <?php } ?>
                            </a>
                          <?php } else { ?>
                            <a md-ink-ripple href="<?php echo base_url().$menu_1v->url?>">
                              <i class="icon mdi-content-sort i-20"></i>
                              <?php echo $menu_1v->menu_1;?>
                            </a>
                          <?php } ?>
                          </li>
                        <?php } ?>
                      </ul>
                    </nav>
                  </div>
                  <div id="account" class="hide m-v-xs">
                    <nav>
                      <ul class="nav">
                        <li>
                          <a md-ink-ripple href="<?php echo base_url('login/salir')?>">
                            <i class="icon mdi-action-exit-to-app i-20"></i>
                            <span>Salir</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>
      <!-- / aside -->
      <!-- content -->
      <div id="content" class="app-content" role="main">
        <div class="box">
          <!-- Content Navbar -->
          <div class="navbar md-whiteframe-z1 no-radius blue">
            <!-- Open side - Naviation on mobile -->
            <a md-ink-ripple  data-toggle="modal" data-target="#aside" class="navbar-item pull-left visible-xs visible-sm"><i class="mdi-navigation-menu i-24"></i></a>
            <!-- / -->
            <!-- Page title - Bind to $state's title -->
            <div class="navbar-item pull-left h4">Pasaporte tequilero - <?php echo $rol; ?></div>
            <!-- / -->
            <!-- Common tools -->
            <ul class="nav navbar-tool pull-right">
              <li class="dropdown">
                <a md-ink-ripple data-toggle="dropdown">
                  <i class="mdi-navigation-more-vert i-24"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up text-color">
                  <li>
                    <a href="javascript:;"><?php echo $rol;?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="<?php echo base_url('login/salir')?>">Salir</a>
                  </li>
                </ul>
              </li>
            </ul>
            <div class="pull-right" ui-view="navbar@"></div>
            <!-- / -->
            <!-- Search form -->
            <div id="search" class="pos-abt w-full h-full indigo hide">
              <div class="box">
                <div class="box-col w-56 text-center">
                  <!-- hide search form -->
                  <a md-ink-ripple class="navbar-item inline"  ui-toggle-class="show" target="#search"><i class="mdi-navigation-arrow-back i-24"></i></a>
                </div>
                <div class="box-col v-m">
                  <!-- bind to app.search.content -->
                  <input class="form-control input-lg no-bg no-border" placeholder="Search" ng-model="app.search.content">
                </div>
                <div class="box-col w-56 text-center">
                  <a md-ink-ripple class="navbar-item inline"><i class="mdi-av-mic i-24"></i></a>
                </div>
              </div>
            </div>
            <!-- / -->
          </div>
          <!-- Content -->
          <div class="box-row">
            <div class="box-cell">
              <div id="contain-frm" class="box-inner padding">
                <?php echo validation_errors();?>
                <form id="frm-venta-a" action="" method="post">
                  <div class="card" ng-controller="MDInputCtrl">
                    <div class="card-heading">
                      <h2>Venta</h2>
                    </div>
                    <div class="card-body green">
                      <div class="row row-sm">
                        <div class="col-sm-4 gr">
                          <div class="md-form-group">
                            <input id="id_pasaporte" disabled="" class="md-input md-input">
                            <label>ID pasaporte</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="md-form-group">
                            <input id="vendedor" class="md-input md-input" disabled="" required value="<?php echo $n_vendedor?>">
                            <label id="n-vendedor"><?php echo $vendedor;?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row row-sm">
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input id="propietario" name="propietario" class="md-input md-input" type="text" required>
                            <label>Propietario</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input class="md-input md-input no-display" >
                            <label>Tipo de pago</label>
                            <select id="pago" name="pago" class="form-control select" required>
                              <option value="">Seleccionar...</option>
                              <option value="1">Efectivo</option>
                              <option value="2">Tarjeta de crédito</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input id="telefono" name="telefono" class="md-input md-input" type="text">
                            <label>Teléfono</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input id="correo" name="correo" class="md-input md-input" type="email">
                            <label>Correo</label>
                          </div>
                        </div>
                         <div class="col-sm-8">
                          <div class="md-form-group">
                            <input id="domicilio" name="domicilio" class="md-input md-input" type="text">
                            <label>Domicilio</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="dni" name="dni" class="md-input md-input" type="text">
                            <label>DNI</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="ciudad" name="ciudad" class="md-input md-input" type="text">
                            <label>Ciudad</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="estado" name="estado" class="md-input md-input" type="text">
                            <label>Estado</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="pais" name="pais" class="md-input md-input" type="text">
                            <label>País</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="cp" name="cp" class="md-input md-input" type="text">
                            <label>Código Postal</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="num-tarjeta" name="num_tarjeta" class="md-input md-input" type="text" pattern="^[0-9]{13,16}$">
                            <label>Número tarjeta</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="fecha_e" class="md-input md-input no-display" type="text">
                            <label>Fecha de expiración</label>
                            <div class='input-group date' id='f_expiracion'>
                                <input id="f-expiracion-i" name="fecha_e_i" type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input id="c-seguridad" name="c-seguridad"  class="md-input md-input" type="text" pattern="^[0-9]{3,4}$">
                            <label>Código de seguridad</label>
                          </div>
                        </div>
                        <div class="col-sm-4 no-display-tarjeta">
                          <div class="md-form-group">
                            <input class="md-input md-input no-display" >
                            <label>Tarjeta</label>
                            <select id="tarjeta" name="tarjeta" class="form-control select">
                              <option value="">Seleccionar...</option>
                              <option value="1">Visa</option>
                              <option value="2">MasterCard</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="md-form-group">
                            <button id="aceptar" type="submit" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar">Aceptar</button>  
                            <a href="<?php echo base_url('config_pasaportes/ventas')?>">
                              <button type="button" md-ink-ripple="" class="btn btn-fw btn-error waves-effect waves-effect">Cancelar</button>  
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
