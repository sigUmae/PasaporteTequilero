<?php echo $header; ?>
    <div class="app">  
      <!-- aside -->
      <aside id="aside" class="app-aside modal fade " role="menu">
        <div class="left">
          <div class="box bg-white">
            <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
                <a class="navbar-brand logo-blanco" href="<?php echo base_url('inicio/index')?>"></a>
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
              <!-- <ul class="nav b-t b">
                <li>
                  <a href="http://themeforest.net/item/materil-responsive-admin-dashboard-template/11062969" target="_blank" md-ink-ripple>
                    <i class="icon mdi-action-help i-20"></i>
                    <span>Help &amp; Feedback</span>
                  </a>
                </li>
              </ul> -->
            </nav>
          </div>
        </div>
      </aside>
      <!-- / aside -->
      <!-- content -->
      <div id="content" class="app-content" role="main">
        <div class="box">
          <!-- Content Navbar -->
          <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
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
                  <li><a href="<?php echo base_url('login/salir')?>">Salir</a></li>
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
              <div class="box-inner padding">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    Visitas
                  </div>
                  <div class="panel-body b-b b-light" style="text-align: right">
                    Buscar: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
                  </div>
                  <div class="table-responsive">
                    <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="10">
                      <thead>
                        <tr>
                            <th data-toggle="true">
                                ID
                            </th>
                            <th>
                                Propietario
                            </th>
                            <th data-hide="phone,tablet">
                                Fecha de compra
                            </th>
                            <!-- <th data-hide="phone,tablet" data-name="Date Of Birth">
                                Estado
                            </th> -->
                            <th data-hide="phone">
                                Acción
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($pasaportes as $value_p) { ?>
                        <tr data-id="<php echo $value_p->id?>">
                          <td><?php echo $value_p->id?></td>
                          <td><?php echo $value_p->propietario?></td>
                          <td><?php echo $value_p->fecha?></td>
                          <!-- <td><?php echo $value_p->tipo_pago?></td> -->
                          <td>
                            <!-- <a href="<?php echo base_url('config_pasaportes/visitado').'?pasaporte='.$value_p->id_pasaporte?>"> -->
                            <span data-id-pasaporte="<?php echo $value_p->id_pasaporte?>" 
                                  class="label bg-success visita" title="Visita" 
                                  style="cursor: pointer">Visita</span>
                            <!-- </a> -->
                            <a href="<?php echo base_url('ver_mas').'?pasaporte='.$value_p->id_pasaporte?>">
                              <span class="label bg-success" title="Ver más">Ver más</span>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                      <tfoot class="hide-if-no-paging">
                        <tr>
                            <td colspan="5" class="text-center">
                                <ul class="pagination"></ul>
                            </td>
                        </tr>
                      </tfoot>
                    </table>
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
