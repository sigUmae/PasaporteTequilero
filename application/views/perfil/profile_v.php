<?php echo $header; ?>
<div class="app">
  <!-- aside -->
  <aside id="aside" class="app-aside modal fade " role="menu">
    <div class="left">
      <div class="box bg-white">
        <div class="navbar md-whiteframe-z1 no-radius <?php echo $color_1; ?>">
          <!-- brand -->
          <a class="navbar-brand logo-blanco" href="<?php echo base_url('inicio/index')?>"></a>
          <!-- / brand -->
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
        
        <div class="row row-sm">
          <div class="col-sm-4">
            <div class="panel panel-card">
              <div class="r-t pos-rlt" md-ink-ripple style="background:url(images/a0.jpg) center center; background-size:cover">
                <div class="p-lg bg-white-overlay text-center r-t">
                  <a href class="w-xs inline">
                    <img src="<?php echo base_url('assets/images')."/".$avatar?>" class="img-responsive rounded">
                  </a>
                  <div class="m-b m-t-sm h2">
                    <span class="">David M.</span>
                  </div>
                  <a id="avatar-perfil" class="btn btn-sm btn-success m-b p-h no-border">
                    Editar
                  </a>
                  <?php echo form_open_multipart('perfil/subir'); ?>
                  <!-- <form id="upload-form" method="post" enctype="multipart/form-data"> -->
                  <input type="file" name="userfile" id="upload-a" class="upload-btn"></input>
                  <input type="submit" name="submit-a" id="submit-a" class="upload-btn"></input>
                </form>
              </div>
            </div>
            <div class="list-group no-radius no-border">
              <a class="list-group-item">
                <span class="pull-right badge">12</span> Messages
              </a>
              <a class="list-group-item">
                <span class="pull-right badge">23</span> Photos
              </a>
              <a class="list-group-item">
                <span class="pull-right badge">564</span> Posts
              </a>
            </div>
            <div class="text-center b-b b-light">
              <a href class="inline m text-color">
                <span class="h3 block font-bold">221</span>
                <em class="text-xs">Followers</em>
              </a>
              <a href class="inline m text-color">
                <span class="h3 block font-bold">250</span>
                <em class="text-xs">Following</em>
              </a>
            </div>
            <div class="p">
              <p>About</p>
              <p>Lorem ipsum dolor sit amet, consecteter adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. </p>
              <div class="m-v">
                <a class="text-muted">
                  <i class="fa ui-icon fa-facebook"></i>
                </a>
                <a class="text-muted">
                  <i class="fa ui-icon fa-twitter"></i>
                </a>
                <a class="text-muted">
                  <i class="fa ui-icon fa-linkedin"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="panel panel-card">
            <form>
              <textarea class="form-control no-border" rows="3" placeholder="Write something..."></textarea>
            </form>
            <div class="lt p">
              <button class="btn btn-info pull-right btn-sm p-h font-bold">Post</button>
              <ul class="nav nav-pills nav-sm">
                <li><a href><i class="fa fa-camera"></i></a></li>
                <li><a href><i class="fa fa-video-camera"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="panel panel-card clearfix">
            <div class="p-h b-b b-light">
              <ul class="nav nav-lines nav-md b-info">
                <li class="active"><a href>Stream</a></li>
                <li><a href>Photos <span class="badge">3</span></a></li>
                <li><a href>Posts <span class="badge">9</span></a></li>
              </ul>
            </div>
            <div class="p-h-lg m-b-lg">
              <div class="streamline b-l p-v m-l-xs">
                <div>
                  <a class="pull-left w-32 m-l-n m-t-xs m-r">
                    <img src="images/a2.jpg" class="img-responsive rounded" alt="...">
                  </a>
                  <div class="clear">
                    <div class="m-b-xs">
                      <a href>James</a> said
                      <span class="text-muted block text-xs">
                        Just now
                      </span>
                    </div>
                    <div class="m-b">
                      <div>Lorem ipsum dolor sit amet, consecteter adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. ullamcorper sodales nisi nec adipiscing elit. Morbi id neque quam. Aliquam sollicitudin </div>
                      <div class="m-t-sm">
                        <a href class="text-muted m-xs">Like</a>
                        <a href class="text-muted m-xs">Comment</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <a class="pull-left w-32 m-l-n m-t-xs m-r">
                    <img src="images/a3.jpg" class="img-responsive rounded" alt="...">
                  </a>
                  <div class="clear">
                    <div class="m-b-xs">
                      <a href>Oscar</a> upload a file
                      <span class="text-muted block text-xs">
                        3 minutes ago
                      </span>
                    </div>
                    <div class="m-b">
                      <div class="w-xl w-auto-xs">
                        <div class="box bg-light">
                          <div class="box-col w-xs text-center dk p-md v-m">
                            <i class="fa fa-file-text-o text-3x text-muted-lt"></i>
                          </div>
                          <div class="box-col p">
                            <a href>Geuismod tincidunt</a>
                            <div>Diam nonummy nibh euismod tincidunt ut laoreet. </div>
                          </div>
                        </div>
                      </div>
                      <div class="m-t-sm">
                        <a href class="text-muted m-xs">Like</a>
                        <a href class="text-muted m-xs">Comment</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <a class="pull-left w-32 m-l-n m-t-xs m-r">
                    <img src="images/a4.jpg" class="img-responsive rounded" alt="...">
                  </a>
                  <div class="clear">
                    <div class="m-b-xs">
                      <a href>Anny</a> post a photo
                      <span class="text-muted block text-xs">
                        6 minutes ago
                      </span>
                    </div>
                    <div class="m-b">
                      <div><img src="images/a10.jpg" class="b p-xs"></div>
                      <div class="m-t-sm">
                        <a href class="text-muted m-xs">Like</a>
                        <a href class="text-muted m-xs">Comment</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <a class="pull-left w-32 m-l-n m-t-xs m-r">
                    <img src="images/a5.jpg" class="img-responsive rounded" alt="...">
                  </a>
                  <div class="clear">
                    <div class="m-b-xs">
                      <a href>Michel</a> post a comment
                      <span class="text-muted block text-xs">
                        10 minutes ago
                      </span>
                    </div>
                    <div class="m-b bg-light">
                      <div class="p-sm b-b b-white">
                        <img src="images/a4.jpg" class="rounded w-20 pull-left m-r-sm" alt="...">
                        <a href>Tony</a> liked it
                      </div>
                      <div class="p-sm">
                        <img src="images/a6.jpg" class="rounded w-20 pull-left m-r-sm" alt="...">
                        <a href>Anney</a> Commented it
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a md-ink-ripple class="md-btn md-fab md-fab-bottom-right pos-fix green"><i class="mdi-editor-mode-edit i-24"></i></a>
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