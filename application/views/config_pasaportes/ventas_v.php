<?php echo $header; ?>
   <div class="app">  
      <aside id="aside" class="app-aside modal fade " role="menu">
        <div class="left">
          <div class="box bg-white">
            <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
                <a class="navbar-brand logo-blanco"></a>
            </div>
            <div class="box-row">
              <div class="box-cell scrollable hover">
                <div class="box-inner">
                  <div class="p hidden-folded <?php echo $color_2; ?>" 
                       style="background-image:url(<?php echo base_url('assets/images/bg.png'); ?>); background-size:cover">
                    <div class="rounded w-64 bg-white inline pos-rlt">
                      <img src="<?php echo base_url('assets/images')."/".$avatar?>" class="img-responsive rounded">
                    </div>
                    <a class="block m-t-sm" ui-toggle-class="hide, show" target="#nav, #account">
                      <span class="block font-bold">Usuario</span>
                      <span class="pull-right auto">
                        <i class="fa inline fa-caret-down"></i>
                        <i class="fa none fa-caret-up"></i>
                      </span>
                      <small><?php echo $correo; ?></small>
                    </a>
                  </div>
                  <div id="nav">
                    <nav ui-nav>
                      <ul class="nav">
                        <li>
                          <a md-ink-ripple href="<?php echo base_url('inicio/index'); ?>">
                            <i class="icon mdi-content-sort i-20"></i>
                            Inicio
                          </a>
                        </li>
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
            <nav>
              <ul class="nav b-t b">
                <li style="text-align: center">
                  Derechos Reservados 2015 <br> Sitio Desarrollado por bienTICS & Bridgestudio
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </aside>
      <div id="content" class="app-content" role="main">
        <div class="box">
          <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
            <a md-ink-ripple  data-toggle="modal" data-target="#aside" class="navbar-item pull-left visible-xs visible-sm"><i class="mdi-navigation-menu i-24"></i></a>
            <div class="navbar-item pull-left h4">Pasaporte tequilero - <?php echo $rol; ?></div>
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
            <div id="search" class="pos-abt w-full h-full indigo hide">
              <div class="box">
                <div class="box-col w-56 text-center">
                  <a md-ink-ripple class="navbar-item inline"  ui-toggle-class="show" target="#search"><i class="mdi-navigation-arrow-back i-24"></i></a>
                </div>
                <div class="box-col v-m">
                  <input class="form-control input-lg no-bg no-border" placeholder="Search" ng-model="app.search.content">
                </div>
                <div class="box-col w-56 text-center">
                  <a md-ink-ripple class="navbar-item inline"><i class="mdi-av-mic i-24"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="box-row">
            <div class="box-cell">
              <div id="contain-frm" class="box-inner padding">
                <form class="frm-venta-a" data-id="<?php echo $total_id; ?>" id="frm-<?php echo $total_id; ?>" action="" method="post">
                  <div id="frm_<?php echo $total_id; ?>" class="card" ng-controller="MDInputCtrl">
                    <div class="card-heading">
                      <h2 style="float: left">Venta</h2>
                      <div style="text-align: right">
                        <input id="cantidad" 
                          style="width: 108px; margin-right: 10px; text-align: center;" 
                          placeholder="Cantidad" 
                          class="md-input" 
                          type="text">
                        <button 
                          type="button"
                          id="nueva-cantidad"
                          md-ink-ripple="" 
                          class="btn btn-fw btn-success waves-effect waves-effect">
                          Aceptar
                        </button>
                      </div>
                    </div>
                    <div class="card-body green">
                      <div class="row row-sm">
                        <div class="col-sm-4 gr">
                          <div class="md-form-group">
                            <input value="<?php echo $total_id; ?>" name="id_pasaporte" disabled="" class="id_pasaporte md-input md-input">
                            <label>ID pasaporte</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="md-form-group">
                            <input class="md-input md-input vendedor" name="vendedor" disabled="" required value="<?php echo $n_vendedor?>">
                            <label class="n-vendedor" ><?php echo $vendedor;?></label>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <?php if ($vendedor == 'Hacienda') { ?>
                          <div class="md-form-group">
                            <label class="radio-inline">
                              <input data-id="<?php echo $total_id; ?>" type="radio" name="inlineRadioOptions" class="virtual" value="virtual"> Virtual
                            </label>
                            <label class="radio-inline">
                              <input data-id="<?php echo $total_id; ?>" type="radio" name="inlineRadioOptions" class="fisico" value="fisico"> Físico
                            </label>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row row-sm">
                        <div class="col-sm-8">
                          <div class="md-form-group">
                            <input name="propietario" class="propietario md-input md-input" type="text" required>
                            <label>Propietario</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input class="md-input md-input no-display" >
                            <label>Tipo de pago</label>
                            <select data-id="<?php echo $total_id; ?>" name="pago" class="form-control select pago" required>
                              <option value="">Seleccionar...</option>
                              <option value="1">Efectivo</option>
                              <option value="2">Tarjeta de crédito/debito</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row row-sm">
                        <?php if ($vendedor == 'Hacienda') { ?>
                          <div class="fisico_input col-sm-12 no-display">
                            <div class="md-form-group">
                              <input name="fisico" class="id_fisico md-input md-input" type="text">
                              <label>ID pasaporte físico</label>
                            </div>                           
                          </div>
                        <?php } ?>
                        <div class="c_referencia col-sm-12 no-display">
                          <div class="md-form-group">
                            <input name="referencia" class="num_referencia md-input md-input" type="text">
                            <label>Número de referencia</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input name="correo" class="correo md-input md-input" type="email" required>
                            <label>Correo electrónico</label>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="md-form-group">
                            <input name="telefono" class="telefono md-input md-input" type="text">
                            <label>Teléfono</label>
                          </div>
                        </div>
                         <div class="col-sm-12">
                          <div class="md-form-group">
                            <input name="domicilio" class="domicilio md-input md-input" type="text">
                            <label>Domicilio</label>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="md-form-group">
                            <button 
                              value="frm-<?php echo $total_id; ?>" 
                              type="submit" 
                              md-ink-ripple="" 
                              class="aceptar btn btn-fw btn-success waves-effect waves-effect btn-aceptar">
                              Guardar
                            </button>
                            <button type="button" md-ink-ripple="" class="btn btn-fw btn-error waves-effect waves-effect">Borrar</button>  
                            <a target="_blank" href="https://secure.payulatam.com/payment_tools/index2.zul#ITEM=82">
                              <button type="button"  md-ink-ripple="" class="green btn btn-fw btn-error waves-effect waves-effect">Terminal virtual</button>  
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <?php if (isset($_GET['cantidad']) and $_GET['action'] and !empty($_GET['cantidad'])) { 
                  $cantidad = (int)$_GET['cantidad']; ?>
                  <?php if (is_int($cantidad)) { 
                    for ($i=1; $i < $cantidad; $i++) { ?>
                      <form class="frm-venta-a" data-id="<?php echo $total_id+$i; ?>" id="frm-<?php echo $total_id+$i; ?>" action="" method="post">
                        <div id="frm_<?php echo $total_id+$i; ?>" class="card" ng-controller="MDInputCtrl">
                          <div class="card-heading">
                            <h2>Venta</h2>
                          </div>
                          <div class="card-body green">
                            <div class="row row-sm">
                              <div class="col-sm-4 gr">
                                <div class="md-form-group">
                                  <input value="<?php echo $total_id+$i; ?>" name="id_pasaporte" disabled="" class="id_pasaporte md-input md-input">
                                  <label>ID pasaporte</label>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="md-form-group">
                                  <input class="md-input md-input vendedor" name="vendedor" disabled="" required value="<?php echo $n_vendedor?>">
                                  <label class="n-vendedor" ><?php echo $vendedor;?></label>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <?php if ($vendedor == 'Hacienda') { ?>
                                <div class="md-form-group">
                                  <label class="radio-inline">
                                    <input data-id="<?php echo $total_id+$i; ?>" type="radio" name="inlineRadioOptions" class="virtual" value="virtual"> Virtual
                                  </label>
                                  <label class="radio-inline">
                                    <input data-id="<?php echo $total_id+$i; ?>" type="radio" name="inlineRadioOptions" class="fisico" value="fisico"> Físico
                                  </label>
                                </div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="row row-sm">
                              <div class="col-sm-8">
                                <div class="md-form-group">
                                  <input name="propietario" class="propietario md-input md-input" type="text" required>
                                  <label>Propietario</label>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="md-form-group">
                                  <input class="md-input md-input no-display" >
                                  <label>Tipo de pago</label>
                                  <select data-id="<?php echo $total_id+$i; ?>" name="pago" class="form-control select pago" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Tarjeta de crédito/debito</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row row-sm">
                              <?php if ($vendedor == 'Hacienda') { ?>
                                <div class="fisico_input col-sm-12 no-display">
                                  <div class="md-form-group">
                                    <input name="fisico" class="id_fisico md-input md-input" type="text">
                                    <label>ID pasaporte físico</label>
                                  </div>                           
                                </div>
                              <?php } ?>
                              <div class="c_referencia col-sm-12 no-display">
                                <div class="md-form-group">
                                  <input name="referencia" class="num_referencia md-input md-input" type="text">
                                  <label>Número de referencia</label>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="md-form-group">
                                  <input name="correo" class="correo md-input md-input" type="email" required>
                                  <label>Correo electrónico</label>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="md-form-group">
                                  <input name="telefono" class="telefono md-input md-input" type="text">
                                  <label>Teléfono</label>
                                </div>
                              </div>
                               <div class="col-sm-12">
                                <div class="md-form-group">
                                  <input name="domicilio" class="domicilio md-input md-input" type="text">
                                  <label>Domicilio</label>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="md-form-group">
                                  <button 
                                    value="frm-<?php echo $total_id+$i; ?>" 
                                    type="submit" 
                                    md-ink-ripple="" 
                                    class="aceptar btn btn-fw btn-success waves-effect waves-effect btn-aceptar">
                                    Guardar
                                  </button>
                                  <button type="button" md-ink-ripple="" class="btn btn-fw btn-error waves-effect waves-effect">Borrar</button>  
                                  <a target="_blank" href="https://secure.payulatam.com/payment_tools/index2.zul#ITEM=82">
                                    <button type="button"  md-ink-ripple="" class="green btn btn-fw btn-error waves-effect waves-effect">Terminal virtual</button>  
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="modal-load"></div>
  </body>
</html>