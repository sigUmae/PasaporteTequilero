<?php echo $header; ?>
<div class="app">  
  <!-- aside -->
  <aside id="aside" class="app-aside modal fade " role="menu">
    <div class="left">
      <div class="box bg-white">
  <div class="navbar md-whiteframe-z1 no-radius blue">
      <!-- brand -->
      <a class="navbar-brand logo-blanco" href="<?php echo base_url('inicio/index')?>"></a>
      <!-- / brand -->
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
              <!-- <li>
                <a md-ink-ripple href="<?php echo base_url('perfil')."?id=$id_usuario"?>">
                  <i class="icon mdi-action-perm-contact-cal i-20"></i>
                  <span>Perfil</span>
                </a>
              </li> -->
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
      <li>
        <a href="http://themeforest.net/item/materil-responsive-admin-dashboard-template/11062969" target="_blank" md-ink-ripple>
          <i class="icon mdi-action-help i-20"></i>
          <span>Help &amp; Feedback</span>
        </a>
      </li>
    </ul>
  </nav>
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
         <!--  <li>
            <a md-ink-ripple ui-toggle-class="show" target="#search">
              <i class="mdi-action-search i-24"></i>
            </a>
          </li>
          <li>
            <a md-ink-ripple data-toggle="modal" data-target="#user">
              <i class="mdi-social-people-outline i-24"></i>
            </a> -->
          </li>
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
                Reporte visitas
              </div>
              <div class="panel-body b-b b-light">
                <div class="col-sm-12" style="text-align: right">
                  <div class="md-form-group">
                    Buscar: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r m-l"/>
                  </div>
                </div>
                 <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Filtar:</label>
                    <div class="col-sm-10">
                      <select name="" id="rango" class="form-control">
                        <option value="">Seleccionar...</option>
                        <option value="hoy">Hoy</option>
                        <option value="ayer">Ayer</option>
                        <option value="mes">Al mes</option>
                        <option value="fecha">Fecha</option>
                        <option value="rango-fechas">Rango de fechas</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-8" id="contain-options" data-id="rango_visitas"></div>
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
                            Vendedor
                        </th>
                         <th>
                            Haciendas visitadas
                        </th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($pasaportes as $key => $value_v) { ?>
                    <tr>
                      <td ><?php echo $value_v->id?></td>
                      <td class="middle"><?php echo $value_v->propietario?></td>
                      <td class="middle"><?php echo $value_v->vendedor?></td>
                      <td class="middle">
                        <div class="col-sm-3 min-height">
                          <img data-id-hacienda="1" data-id-pasaporte="<?php echo $value_v->id_pasaporte?>" title=""
                               class="tooltip kit-width" src="<?php echo base_url($value_v->sauza)?>" alt="" width="50">
                        </div>
                        <div class="col-sm-3">
                          <img data-id-hacienda="2" data-id-pasaporte="<?php echo $value_v->id_pasaporte?>" title=""
                               class="tooltip" src="<?php echo base_url($value_v->herradura)?>" alt="" width="50">
                        </div>
                        <div class="col-sm-3">
                          <img data-id-hacienda="3" data-id-pasaporte="<?php echo $value_v->id_pasaporte?>" title=""
                               class="tooltip" src="<?php echo base_url($value_v->cofradia)?>" alt="" width="50">
                        </div>
                         <div class="col-sm-3">
                           <!-- <button type="button" md-ink-ripple="" class="btn-kit kit-width btn btn-fw btn-error waves-effect waves-effect waves-effect waves-effect">KIT</button> -->
                         </div>
                        <!-- <div class="col-sm-3"></div> -->
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
  <!-- / content -->

  <div class="modal fade" id="user" data-backdrop="false">
    <div class="right w-xl bg-white md-whiteframe-z2">
        <div class="box">
    <div class="p p-h-md">
      <a data-dismiss="modal" class="pull-right text-muted-lt text-2x m-t-n inline p-sm">&times;</a>
      <strong>Members</strong>
    </div>
    <div class="box-row">
      <div class="box-cell">
        <div class="box-inner">
          <div class="list-group no-radius no-borders">
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
              <img src="images/a1.jpg" class="pull-left w-40 m-r img-circle">
              <div class="clear">
                <span class="font-bold block">Jonathan Doe</span>
                <span class="clear text-ellipsis text-xs">"Hey, What's up"</span>
              </div>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
              <img src="images/a2.jpg" class="pull-left w-40 m-r img-circle">
              <div class="clear">
                <span class="font-bold block">James Pill</span>
                <span class="clear text-ellipsis text-xs">"Lorem ipsum dolor sit amet onsectetur adipiscing elit"</span>
              </div>
            </a>
            <div class="p-h-md m-t p-v-xs">Work</div>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                <span>Jonathan Morina</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                <span>Mason Yarnell</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-warning text-xs m-r-xs"></i>
                <span>Mike Mcalidek</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Cris Labiso</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Daniel Sandvid</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Helder Oliveira</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Jeff Broderik</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Daniel Sandvid</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Helder Oliveira</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Jeff Broderik</span>
            </a>
            <div class="p-h-md m-t p-v-xs">Partner</div>            
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-success text-xs m-r-xs"></i>
                <span>Mason Yarnell</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-warning text-xs m-r-xs"></i>
                <span>Mike Mcalidek</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Cris Labiso</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Jonathan Morina</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Daniel Sandvid</span>
            </a>
            <a data-toggle="modal" data-target="#chat" data-dismiss="modal"  class="list-group-item p-h-md">
                <i class="fa fa-circle text-muted-lt text-xs m-r-xs"></i>
                <span>Helder Oliveira</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="p-h-md p-v">
      <p>Invite People</p>
      <a href class="text-muted"><i class="fa fa-fw fa-twitter"></i> Twitter</a>
      <a href class="text-muted m-h"><i class="fa fa-fw fa-facebook"></i> Facebook</a>
    </div>
  </div>

    </div>
  </div>

  <div class="modal fade" id="chat" data-backdrop="false">
    <div class="right w-xxl bg-white md-whiteframe-z2">
        <div class="box">
    <div class="p p-h-md">
      <a data-dismiss="modal" class="pull-right text-muted-lt text-2x m-t-n inline p-sm">&times;</a>
      <strong>Chat</strong>
    </div>
    <div class="box-row bg-light lt">
      <div class="box-cell">
        <div class="box-inner">
          <div class="p-md">
            <div class="m-b">
              <a href class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..." class="w-full img-circle"></a>
              <div class="clear">
                <div class="p p-v-sm bg-warning inline r">
                  Hi John, What's up...
                </div>
                <div class="text-muted-lt text-xs m-t-xs"><i class="fa fa-ok text-success"></i> 2 minutes ago</div>
              </div>
            </div>
            <div class="m-b">
              <a href class="pull-right w-40 m-l-sm"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
              <div class="clear text-right">
                <div class="p p-v-sm bg-info inline text-left r">
                  Lorem ipsum dolor soe rooke..
                </div>
                <div class="text-muted-lt text-xs m-t-xs">1 minutes ago</div>
              </div>
            </div>
            <div class="m-b">
              <a href class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..." class="w-full img-circle"></a>
              <div class="clear">
                <div class="p p-v-sm bg-warning inline r">
                  Good!
                </div>
                <div class="text-muted-lt text-xs m-t-xs"><i class="fa fa-ok text-success"></i> 5 seconds ago</div>
              </div>
            </div>
            <div class="m-b">
              <a href class="pull-right w-40 m-l-sm"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
              <div class="clear text-right">
                <div class="p p-v-sm bg-info inline text-left r">
                  Dlor soe isep..
                </div>
                <div class="text-muted-lt text-xs m-t-xs">Just now</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-h-md p-v">
      <a class="pull-left w-32 m-r"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
      <form>
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Say something">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">SEND</button>
          </span>
        </div>
      </form>
    </div>
  </div>

    </div>
  </div>

</div>
</body>
</html>
