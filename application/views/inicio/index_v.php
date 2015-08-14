<?php 
  // if ( !isset($_SERVER['HTTPS'])) {
  //   header('Location: https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']);
  // }
?>
<?php echo $header; ?>
    <div class="app">  
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
              <?php if ($admin == '1') { ?>
                <div class="row row-xs">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Hoy
                          <div class="h2 text-success font-bold"><?php echo $total_vendidos; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-card p m-b-sm">
                      <div class="text-center" ng-controller="ChartCtrl">
                        <div ui-jp="plot" ui-options='
                            <?php echo $ventas; ?>,
                            {
                              series: 
                              { 
                                pie: 
                                { 
                                  show: true, 
                                  innerRadius: 0.4, 
                                  stroke: 
                                  { 
                                    width: 3
                                  }, 
                                  label: 
                                  { 
                                    show: true, 
                                    threshold: 0.05 
                                  } 
                                } 
                              },
                              colors: 
                              [
                                "#2196f3",
                                "#ffc107",
                                "#4caf50",
                                "#7e57c2"
                              ],
                              grid: 
                              { 
                                hoverable: true, 
                                clickable: true, 
                                borderWidth: 0, 
                                color: "#ccc" 
                              },   
                              tooltip: true,
                              tooltipOpts: 
                              { 
                                content: "%s: %p.0%" 
                              }
                            }
                          ' style="height:200px">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row row-xs">
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                        <div class="panel-heading">
                          <span class="font-bold">Ventas</span>
                        </div>
                        <div class="panel-body">
                          <div ui-jp="plot" ui-options="
                            [
                              { 
                                data: 
                                  <?php echo $ventas_semana; ?>, 
                                  points: 
                                    { 
                                      show: true, 
                                      radius: 3
                                    }, 
                                  lines: 
                                    { 
                                      show: true, 
                                      lineWidth: 1
                                    } 
                              }
                            ], 
                            {
                              colors: ['#3f51b5', '#2196f3'],
                              series: { shadowSize: 3 },
                              xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                              yaxis:{ show: true, font: { color: '#ccc' }},
                              grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                              tooltip: true,
                              tooltipOpts: { content: '%x es %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                            }
                          " style="height:240px" >
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">Visitas</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options="
                          [
                            { data: <?php echo $semena_visita; ?> }
                          ], 
                          {
                            bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] } },
                            colors: ['#2196f3','#4caf50'],
                            series: { shadowSize: 3 },
                            xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                            yaxis:{ show: true, font: { color: '#ccc' }},
                            grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                            tooltip: true,
                            tooltipOpts: { content: '%x es %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                          }
                        " style="height:240px" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">KIT</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options="
                            [
                              { 
                                data: <?php echo $semena_kit; ?>, 
                                  points: 
                                    { 
                                      show: true, 
                                      radius: 3
                                    }, 
                                  lines: 
                                    { 
                                      show: true, 
                                      lineWidth: 1
                                    } 
                              }
                            ], 
                            {
                              colors: ['#3f51b5', '#2196f3'],
                              series: { shadowSize: 3 },
                              xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                              yaxis:{ show: true, font: { color: '#ccc' }},
                              grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                              tooltip: true,
                              tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                            }
                          " style="height:240px" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">Comisiones</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options='
                          <?php echo $semena_comision; ?>,
                          {
                            series: { pie: { show: true, innerRadius: 0.6, stroke: { width: 3 }, label: { show: true, threshold: 0.05 } } },
                            colors: ["#3f51b5","#2196f3"],
                            grid: { hoverable: true, clickable: true, borderWidth: 0, color: "#ccc" },   
                            tooltip: true,
                            tooltipOpts: { content: "%s: %p.0%" }
                          }
                        ' style="height:240px"></div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else if ($admin == '2') { ?>
                <div class="row row-xs">
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Hoy
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_dia']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p" style="color: transparent">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Semana
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_semana']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p" style="color: transparent">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Mes
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_mes']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row row-xs">
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                        <div class="panel-heading">
                          <span class="font-bold">Ventas</span>
                        </div>
                        <div class="panel-body">
                          <div ui-jp="plot" ui-options="
                            [
                              { 
                                data: 
                                  <?php echo $ventas_semana; ?>, 
                                  points: 
                                    { 
                                      show: true, 
                                      radius: 3
                                    }, 
                                  lines: 
                                    { 
                                      show: true, 
                                      lineWidth: 1
                                    } 
                              }
                            ], 
                            {
                              colors: ['#3f51b5', '#2196f3'],
                              series: { shadowSize: 3 },
                              xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                              yaxis:{ show: true, font: { color: '#ccc' }},
                              grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                              tooltip: true,
                              tooltipOpts: { content: '%x es %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                            }
                          " style="height:240px" >
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">Visitas</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options="
                          [
                            { data: <?php echo $semana_visitas; ?> }
                          ], 
                          {
                            bars: { show: true, fill: true,  barWidth: 0.3, lineWidth: 1, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] } },
                            colors: ['#2196f3','#4caf50'],
                            series: { shadowSize: 3 },
                            xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                            yaxis:{ show: true, font: { color: '#ccc' }},
                            grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                            tooltip: true,
                            tooltipOpts: { content: '%x es %y',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                          }
                        " style="height:240px" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">KIT</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options="
                            [
                              { 
                                data: <?php echo $semena_kit; ?>, 
                                  points: 
                                    { 
                                      show: true, 
                                      radius: 3
                                    }, 
                                  lines: 
                                    { 
                                      show: true, 
                                      lineWidth: 1
                                    } 
                              }
                            ], 
                            {
                              colors: ['#3f51b5', '#2196f3'],
                              series: { shadowSize: 3 },
                              xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
                              yaxis:{ show: true, font: { color: '#ccc' }},
                              grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                              tooltip: true,
                              tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
                            }
                          " style="height:240px" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="panel panel-card p m-b-sm">
                      <div class="panel-heading">
                        <span class="font-bold">Comisiones</span>
                      </div>
                      <div class="panel-body">
                        <div ui-jp="plot" ui-options='
                          <?php echo $semana_comision; ?>,
                          {
                            series: { pie: { show: true, innerRadius: 0.6, stroke: { width: 3 }, label: { show: true, threshold: 0.05 } } },
                            colors: ["#3f51b5","#2196f3"],
                            grid: { hoverable: true, clickable: true, borderWidth: 0, color: "#ccc" },   
                            tooltip: true,
                            tooltipOpts: { content: "%s: %p.0%" }
                          }
                        ' style="height:240px"></div>
                      </div>
                    </div>
                  </div>
              <?php } else if ($admin == '3' and $activador == '0') { ?>
                <div class="row row-xs">
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Hoy
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_dia']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p" style="color: transparent">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Semana
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_semana']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="panel panel-card">
                      <div class="p" style="color: transparent">
                        Pasaportes vendidos
                      </div>
                      <div class="panel-body text-center" style="height: 180px;">
                        <div class="m-v-lg">
                          Mes
                          <div class="h2 text-success font-bold"><?php echo $count['total_v_mes']; ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>