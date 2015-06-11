<?php echo $header; ?>
    <div class="app">
      <aside id="aside" class="app-aside modal fade " role="menu">
        <div class="left">
          <div class="box bg-white">
            <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
                <a class="navbar-brand logo-blanco"  href="<?php echo base_url('inicio/index')?>"></a>
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
                      <small>pasaportetequilero1@gmail.com</small>
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
                          <a md-ink-ripple href="<?php echo base_url('perfil')."?id=$id_usuario"?>">
                            <i class="icon mdi-action-perm-contact-cal i-20"></i>
                            <span>Perfil</span>
                          </a>
                        </li>
                        </li>
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
      <div id="content" class="app-content" role="main">
        <div class="box">
          <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
            <a md-ink-ripple  data-toggle="modal" data-target="#aside" class="navbar-item pull-left visible-xs visible-sm">
              <i class="mdi-navigation-menu i-24"></i>
            </a>
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
                  <li><a href="<?php echo base_url('login/salir')?>">Salir</a></li>
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
              <div class="box-inner padding">
                <div class="row">
                    <div class="col-md-4">
                      <div class="panel p">
                        <div class="item">
                          <img src="<?php echo base_url('pasaporte.png')?>" class="w-full r-t" alt="Washed Out">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="panel p">
                      <div class="md-list-item inset">
                        <div class="md-list-item-content">
                          <h3 class="text-md">Nombre del propietario:</h3>
                          <small class="font-thin"><?php echo $info_pasaporte->propietario;?></small>
                        </div>
                        <div class="md-list-item-content">
                          <h3 class="text-md">Vendedor:</h3>
                          <small class="font-thin"><?php echo $info_pasaporte->vendedor;?></small>
                        </div>
                        <div class="md-list-item-content">
                          <h3 class="text-md">Fecha de venta:</h3>
                          <small class="font-thin"><?php echo $info_pasaporte->fecha;?></small>
                        </div>
                        <div class="md-list-item-content">
                          <h3 class="text-md">Estado:</h3>
                          <small class="font-thin"><?php echo $info_pasaporte->tipo_pago;?></small>
                        </div>
                        <div class="md-list-item-content">
                          <h3 class="text-md">Correo electrónico:</h3>
                          <form id="frm-cambiar-correo" action="" method="post">
                            <input id="correo" name="correo" type="email" required value="<?php echo $info_pasaporte->correo; ?>">
                            <span id="mod_correo" 
                                  data-id-pasaporte="<?php echo (isset($_GET['pasaporte']) and !empty($_GET['pasaporte'])) ? $_GET['pasaporte'] : '0' ; ?>" 
                                  style="cursor: pointer" 
                                  class="label green" 
                                  title="Modificar">Modificar
                            </span>
                            <button style="display: none" id="submit-btn" type="submit"></button>
                          </form>
                        </div>
                        <div class="md-list-item-content" style="text-align: center">
                          <a href="<?php echo base_url('pasaporte_virtual/acceso?id=').$id?>" target="_blank">
                            <button type="button" md-ink-ripple="" class="btn-kit kit-width btn btn-fw btn-success waves-effect waves-effect m-t">Pasaporte virtual</button>
                          </a>
                           <button id="enviar_pt" data-id-pasaporte="<?php echo $id; ?>" type="button" md-ink-ripple="" class="btn-kit kit-width btn btn-fw btn-success waves-effect waves-effect m-t">Enviar pasaporte por correo</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel p">
                      <div class="row">
                      <?php if ($visita != 0) {
                        foreach ($visita as $key => $value_v) { ?>
                      <?php if ($value_v == 1) { ?>
                        <div class="col-md-4">
                          <div class="item">
                            <img src="<?php echo base_url('haciendas-sauza.jpg')?>" class="w-full r-t tooltip" 
                                title="" data-id-hacienda="1" alt="Washed Out">
                          </div>
                        </div>  
                      <?php } else if ($value_v == 2) { ?>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-herradura.jpg')?>" class="w-full r-t tooltip" 
                                  title="" data-id-hacienda="2" alt="Washed Out">
                          </div>
                        </div>    
                      <?php } else if ($value_v == 3) { ?>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-cofradia.jpg')?>" class="w-full r-t tooltip" 
                                  title="" data-id-hacienda="3" alt="Washed Out">
                          </div>
                        </div>
                      <?php } else if ($key == 0) { ?>
                        <div class="col-md-4">
                          <div class="item">
                            <img src="<?php echo base_url('haciendas-sauza-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>      
                      <?php } else if ($key == 1) { ?>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-herradura-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>
                      <?php } else if ($key == 2) { ?>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-cofradia-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>
                      <?php }
                        }    
                      } else { ?>
                        <div class="col-md-4">
                          <div class="item">
                            <img src="<?php echo base_url('haciendas-sauza-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-herradura-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="item">
                             <img src="<?php echo base_url('haciendas-cofradia-gris.jpg')?>" class="w-full r-t" alt="Washed Out">
                          </div>
                        </div>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>