<?php echo $header; ?>
<div class="app">  
  <!-- aside -->
  <aside id="aside" class="app-aside modal fade " role="menu">
    <div class="left">
      <div class="box bg-white">
  <div class="navbar md-whiteframe-z1 no-radius blue">
      <a class="navbar-brand logo-blanco" href="<?php echo base_url('inicio/index')?>"></a>
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
                <a md-ink-ripple href="<?php echo base_url('perfil')."?id=$id_usuario"?>">
                  <i class="icon mdi-action-perm-contact-cal i-20"></i>
                  <span>Perfil</span>
                </a>
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
        <div class="navbar-item pull-left h4">Pasaporte tequilero - <?php echo $rol;?></div>
        <!-- / -->
        <!-- Common tools -->
        <ul class="nav navbar-tool pull-right">
          <li class="dropdown">
            <a md-ink-ripple data-toggle="dropdown">
              <i class="mdi-navigation-more-vert i-24"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-scale pull-right pull-up text-color">
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
            <?php echo $rol; ?>

 <!--  <div class="row row-xs">
    <div class="col-sm-4">
      <div class="panel panel-card p m-b-sm">
        <h5 class="no-margin m-b">Tasks</h5>
        <div class="text-center">
          <div class="inline">
            <div ui-jp="easyPieChart" ui-options="{
                percent: 25,
                lineWidth: 12,
                trackColor: '#f1f2f3',
                barColor: '#4caf50',
                scaleColor: '#fff',
                size: 167,
                lineCap: 'butt',
                color: '',
                animate: 3000,
                rotate: 270
              }" ng-init="color = getColor(app.setting.theme.primary, 400)">
              <div class="font-bold text-warning">
                25%
              </div>
            </div>
          </div>
        </div>
        <div>
          <div><strong>5</strong> remainning</div>
          <small class="text-muted">Next task: 19:30 Thu</small>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-card p m-b-sm">
        <h5 class="no-margin m-b">Todos</h5>
        <div class="text-center">
          <div class="inline">
            <div ui-jp="easyPieChart" ui-options="{
                percent: 50,
                lineWidth: 70,
                trackColor: '#fff',
                barColor: '#f1f2f3',
                scaleColor: '#fff',
                size: 167,
                lineCap: 'butt',
                rotate: 90,
                animate: 5000
              }">
              <div class="font-bold h3 text-accent">
                50%
              </div>
            </div>
          </div>
        </div>
        <div>
          <div><strong>32</strong> not finished</div>
          <small class="text-muted">432 task finished</small>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-card p m-b-sm">
        <h5 class="no-margin m-b">Sells</h5>
        <div class="text-center" ng-controller="ChartCtrl">
            <div ui-jp="plot" ui-options="
              [{label:'Series 1', data: 45}, {label:'Series 2', data: 5}, {label:'Series 3', data: 30}, {label:'Series 4', data: 20}],
              {
                series: { pie: { show: true, innerRadius: 0.4, stroke: { width: 3 }, label: { show: true, threshold: 0.05 } } },
                colors: ['#2196f3','#ffc107','#4caf50','#7e57c2'],
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },   
                tooltip: true,
                tooltipOpts: { content: '%s: %p.0%' }
              }
            " style="height:168px"></div>
        </div>
        <div class="m-t-xs">
          <div class="font-bold">$432,000</div>
          <small class="text-muted">This month</small>
        </div>
      </div>
    </div>
  </div> 
  <div class="row row-xs" ng-controller="ChartCtrl">
    <div class="col-sm-4">
      <div class="panel panel-card">
        <div class="p">
          Members
        </div>
        <div class="panel-body text-center">
          <div class="m-v-lg">
            Total accounts
            <div class="h2 text-success font-bold">3,421,100</div>
          </div>
        </div>
        <div class="b-t b-light p">
          Composite
          <div class="progress progress-striped progress-sm r m-v-sm">
            <div class="progress-bar purple" style="width:30%">30%</div>
            <div class="progress-bar amber" style="width:20%">20%</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-card">
        <div class="p">
          <label class="md-switch pull-right" ng-init="showData=false">
            <input type="checkbox" ng-model="showData">
            <i class="purple"></i>
          </label>
          <span>Monitor</span> <i class="fa fa-caret-up text-success"></i><span class="text-xs text-muted m-l-xs">1.5%</span>
        </div>
        <div class="panel-body">
          <div ui-jp="plot" ui-refresh="showData" ui-options="
            [
              {
                data: [[1, 7.5], [2, 7.5], [3, 5.7], [4, 8.9], [5, 10], [6, 7], [7, 9], [8, 13], [9, 7], [10, 6]], 
                points: { show: true, radius: 4, lineWidth: 3, fillColor: '#7e57c2'}, 
                lines:  { show: true, lineWidth: 0, fill: 0.5, fillColor: '#7e57c2' }, 
                color:'#fff'
              }
            ],
            {
              series: { shadowSize: 0 },
              xaxis: { show: true, font: { color: '#ccc' }, position: 'bottom' },
              yaxis:{ show: true, font: { color: '#ccc' }},
              grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
              tooltip: true,
              tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
            }
          " style="height:198px">
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-card">
        <div class="p">
          Total revenue of this month
        </div>
        <div style="overflow-x: hidden">
          <div style="margin: 0 -4px;" >
            <div ui-jp="plot" ui-options="
              [
                { data: [[1, 9.5], [2, 9.4], [3, 9.5], [4, 9.5], [5, 9.7], [6, 9.6], [7, 9.3], [8, 9.5], [9, 9], [10, 9.9]], points: { show: true, radius: 0}, splines: { show: true, tension: 0.45, lineWidth: 1, fill: 0.2 } },
                { data: [[1, 4.5], [2, 4.2], [3, 4.5], [4, 4.3], [5, 4.5], [6, 4.7], [7, 4.6], [8, 4.8], [9, 4.6], [10, 4.5]], points: { show: true, radius: 0}, splines: { show: true, tension: 0.45, lineWidth: 1, fill: 1 } }
              ], 
              {
                colors: ['#cccccc', ''],
                series: { shadowSize: 3 },
                xaxis: { show: false, font: { color: '#ccc' }, position: 'bottom' },
                yaxis:{ show: false, font: { color: '#ccc' }},
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                tooltip: true,
                tooltipOpts: { content: '%x.0 is %y.4',  defaultTheme: false, shifts: { x: 0, y: -40 } }
              }
            " style="height:173px" >
          </div>
          </div>
        </div>
        <div class="panel-footer blue no-b-t">
          <div class="box">
            <div class="box-col">
              <span class="text-md">$30,343 <i class="fa fa-caret-up text-muted"></i></span>
            </div>
            <div class="box-col text-right w-xs">
              <div ng-init="data1=[60,40]" ui-jp="sparkline" ui-options=", {type:'pie', height:25, sliceColors:['#ffc107','#fff']}" class="sparkline inline"></div>
            </div>
          </div>
        </div>
      </div>
    </div>    
  </div>
  <div class="row row-xs" ng-controller="VectorMapCtrl">
    <div class="col-md-8">
      <div class="panel panel-card">
        <div class="panel-heading b-b b-light">World Market</div>
        <div class="panel-body">
          <p class="m-b-lg text-muted">World map, world regions, countries and cities.</p>
          <div class="m-b-lg" style="height:243px;" ui-jp="vectorMap" ui-options="{            
            map: 'world_mill_en',
            markers: [{latLng: [41.90, 12.45], name: 'Vatican City'}, {latLng: [43.93, 12.46], name: 'San Marino'}, {latLng: [47.14, 9.52], name: 'Liechtenstein'}, {latLng: [7.11, 171.06], name: 'Marshall Islands'}, {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'}, {latLng: [3.2, 73.22], name: 'Maldives'}, {latLng: [35.88, 14.5], name: 'Malta'}, {latLng: [12.05, -61.75], name: 'Grenada'}, {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'}, {latLng: [13.16, -59.55], name: 'Barbados'}, {latLng: [17.11, -61.85], name: 'Antigua and Barbuda'}, {latLng: [-4.61, 55.45], name: 'Seychelles'}, {latLng: [7.35, 134.46], name: 'Palau'}, {latLng: [42.5, 1.51], name: 'Andorra'} ],
            normalizeFunction: 'polynomial',
            backgroundColor: '#fff',
            regionsSelectable: true,
            markersSelectable: true,
            regionStyle: {
              initial: {
                fill: '#f1f2f3'
              },
              hover: {
                fill: '#2196f3',
                stroke: '#fff'
              },
            },
            markerStyle: {
              initial: {
                fill: '#2196f3',
                stroke: '#fff'
              },
              hover: {
                fill: '#3f51b5',
                stroke: '#fff'
              }
            },
            series: {
              markers: [{
                attribute: 'fill',
                scale: ['#3f51b5','#7e57c2', '#4caf50'],
                values: [605.16, 310.69, 405.17, 248.31, 207.35, 217.22, 137.70, 280.71, 210.32, 325.42]
              },{
                attribute: 'r',
                scale: [5, 20],
                values: [605.16, 310.69, 405.17, 248.31, 207.35, 217.22, 137.70, 280.71, 210.32, 325.42]
              }]
            }
          }" >
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-card">
        <div class="panel-heading b-b b-light">Infomation</div>
        <div class="list-group no-border no-radius">
          <div class="list-group-item">
            <span class="pull-right">293,200</span>
            <i class="fa fa-fw fa-circle m-r-sm text-info"></i>
            Vatican City
          </div>
          <div class="list-group-item">
            <span class="pull-right">203,000</span>
            <i class="fa fa-fw fa-circle m-r-sm text-success"></i>
            San Marino
          </div>
          <div class="list-group-item">
            <span class="pull-right">180,230</span>
            <i class="fa fa-fw fa-circle m-r-sm text-accent"></i>
            Marshall Islands
          </div>
          <div class="list-group-item">
            <span class="pull-right">130,100</span>
            <i class="fa fa-fw fa-circle m-r-sm text-accent-lt"></i>
            Maldives
          </div>
          <div class="list-group-item">
            <span class="pull-right">98,000</span>
            <i class="fa fa-fw fa-circle m-r-sm text-primary"></i>
            Palau
          </div>
          <div class="list-group-item">
            <span class="pull-right">130,100</span>
            <i class="fa fa-fw fa-circle m-r-sm text-muted-lt"></i>
            Maldives
          </div>
          <div class="list-group-item">
            <span class="pull-right">98,000</span>
            <i class="fa fa-fw fa-circle m-r-sm text-muted-lt"></i>
            Palau
          </div>
          <div class="list-group-item">
            <span class="pull-right">130,100</span>
            <i class="fa fa-fw fa-circle m-r-sm text-muted-lt"></i>
            Maldives
          </div>
        </div>
      </div>
    </div>
  </div> -->



          </div>
        </div>
      </div>
      <!-- / -->
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
