<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?php echo base_url();?>assets/backend/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/backend/images/favicon.png" type="image/x-icon">
    <title>Banyuwangi Satu Data Banyuwangi</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/chartist.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/date-picker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/prism.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/vector-map.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/responsive.css">
    <!-- Template -->
    <script src="<?php echo base_url();?>assets/backend/js/base/loader.js"></script>
    <script src="<?php echo base_url();?>assets/backend/css/select2/select2.min.css"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/select2/select2.min.js"></script>
    <script type="text/javascript">var site = '<?php echo base_url(); ?>';</script>
    <script src="<?php echo base_url();?>assets/backend/libs/jquery/jquery.min.js"></script>
    
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start       -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <div class="main-header-right row m-0">
          <div class="main-header-left">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="<?php echo base_url();?>assets/backend/images/logo/logo.png" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="index.html"><img class="img-fluid" src="<?php echo base_url();?>assets/backend/images/logo/dark-logo.png" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
          </div>
          <div class="left-menu-header col">
            <ul>
              <li>
                <form class="form-inline search-form">
                  <div class="search-bg"><i class="fa fa-search"></i>
                    <input class="form-control-plaintext" placeholder="Search here.....">
                  </div>
                </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
              </li>
            </ul>
          </div>
          <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
              <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
              <li class="onhover-dropdown">
                <div class="bookmark-box"><i data-feather="star"></i></div>
                <div class="bookmark-dropdown onhover-show-div">
                  <div class="form-group mb-0">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                      <input class="form-control" type="text" placeholder="Search for bookmark...">
                    </div>
                  </div>
                  <ul class="m-t-5">
                    <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="inbox"></i>Email<span class="pull-right"><i data-feather="star"></i></span></li>
                    <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="message-square"></i>Chat<span class="pull-right"><i data-feather="star"></i></span></li>
                    <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="command"></i>Feather Icon<span class="pull-right"><i data-feather="star"></i></span></li>
                    <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="airplay"></i>Widgets<span class="pull-right"><i data-feather="star">   </i></span></li>
                  </ul>
                </div>
              </li>
              <li class="onhover-dropdown">
                <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span></div>
                <ul class="notification-dropdown onhover-show-div">
                  <li>
                    <p class="f-w-700 mb-0">You have 3 Notifications<span class="pull-right badge badge-primary badge-pill">4</span></p>
                  </li>
                  <li class="noti-primary">
                    <div class="media"><span class="notification-bg bg-light-primary"><i data-feather="activity"> </i></span>
                      <div class="media-body">
                        <p>Delivery processing </p><span>10 minutes ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-secondary">
                    <div class="media"><span class="notification-bg bg-light-secondary"><i data-feather="check-circle"> </i></span>
                      <div class="media-body">
                        <p>Order Complete</p><span>1 hour ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-success">
                    <div class="media"><span class="notification-bg bg-light-success"><i data-feather="file-text"> </i></span>
                      <div class="media-body">
                        <p>Tickets Generated</p><span>3 hour ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="noti-danger">
                    <div class="media"><span class="notification-bg bg-light-danger"><i data-feather="user-check"> </i></span>
                      <div class="media-body">
                        <p>Delivery Complete</p><span>6 hour ago</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
              <li>
                <div class="mode"><i class="fa fa-moon-o"></i></div>
              </li>
              <li class="onhover-dropdown"><i data-feather="message-square"></i>
                <ul class="chat-dropdown onhover-show-div">
                  <li>
                    <div class="media"><img class="img-fluid rounded-circle me-3" src="<?php echo base_url();?>assets/backend/images/user/4.jpg" alt="">
                      <div class="media-body"><span>Ain Chavez</span>
                        <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                      </div>
                      <p class="f-12">32 mins ago</p>
                    </div>
                  </li>
                  <li>
                    <div class="media"><img class="img-fluid rounded-circle me-3" src="<?php echo base_url();?>assets/backend/images/user/1.jpg" alt="">
                      <div class="media-body"><span>Erica Hughes</span>
                        <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                      </div>
                      <p class="f-12">58 mins ago</p>
                    </div>
                  </li>
                  <li>
                    <div class="media"><img class="img-fluid rounded-circle me-3" src="<?php echo base_url();?>assets/backend/images/user/2.jpg" alt="">
                      <div class="media-body"><span>Kori Thomas</span>
                        <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                      </div>
                      <p class="f-12">1 hr ago</p>
                    </div>
                  </li>
                  <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">See All     </a></li>
                </ul>
              </li>
              <li class="onhover-dropdown p-0">
                <button class="btn btn-primary-light" type="button"><a href="<?php echo base_url();?>login/logout/"><i data-feather="log-out"></i>Log out</a></button>
              </li>
            </ul>
          </div>
          <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
        </div>
      </div>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <header class="main-nav">
          <!-- <div class="sidebar-user text-center"><a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img class="img-90 rounded-circle" src="<?php echo base_url();?>assets/backend/images/dashboard/1.png" alt="">
    <div class="badge-bottom"><span class="badge badge-primary">New</span></div><a href="user-profile.html">
        <h6 class="mt-3 f-14 f-w-600">Emay Walter</h6>
    </a>
    <p class="mb-0 font-roboto">Human Resources Department</p>
    <ul>
        <li><span><span class="counter">19.8</span>k</span>
            <p>Follow</p>
        </li>
        <li><span>2 year</span>
            <p>Experince</p>
        </li>
        <li><span><span class="counter">95.2</span>k</span>
            <p>Follower </p>
        </li>
    </ul>
</div> -->
          <nav>
            <div class="main-navbar">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="mainnav">           
                <ul class="nav-menu custom-scrollbar">
                  <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span>
                      <i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="sidebar-main-title">
                    <div>
                      <h6>Dashboard</h6>
                    </div>
                  </li>
                  <li id="mn" onclick="load('main/dashboard','#contents'); switch_menu(this);"class="dropdown"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="home"></i><span>Beranda</span></a>
                  </li>
                  <?php if ($this->ion_auth_acl->has_permission('kelola_data_dasar')) { ?>
                  <li id="mn" onclick="load('data_dasar/indikator','#contents'); switch_menu(this);"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="hard-drive"></i><span>Data Indikator</span></a>
                  <?php } ?>
                  </li>
                  <li id="mn" onclick="load('data_dasar/dataraw','#contents'); switch_menu(this);"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="server"></i><span>Data Raw</span></a>
                  <li id="mn" onclick="load('data_dasar/indikator','#contents'); switch_menu(this);"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="server"></i><span>Data Aplikasi</span></a>
                  <li id="mn" onclick="load('data_dasar/indikator','#contents'); switch_menu(this);"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="server"></i><span>Data Desa</span></a>
                  
                  </li>
                  <li id="mn" onclick="load('data_dasar/indikator','#contents'); switch_menu(this);"class="dropdown"><a class="nav-link menu-title link-nav" href="javascript:void(0)"><i data-feather="server"></i><span>Data Aplikasi</span></a>

                  </li>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </header>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default-sec">
            <?php $this->load->view($page);?>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2021-22 © viho All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <!-- <div id="contents"></div> -->
                <?php $this->load->view($page);?>
                <div class="modal hide fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="modal_content"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal hide fade" id="ajax-modal-flagging" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Perbarui Flagging Indikator</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="modal_content_flagging"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2020 <a target="_blank" href="#">Banyuwangikab</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Sistem Informasi Manajemen Data dan Pelaporan </p>
                </div>
            </div> -->
    </div>
    <!-- latest jquery-->
    <script src="<?php echo base_url();?>assets/backend/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="<?php echo base_url();?>assets/backend/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?php echo base_url();?>assets/backend/js/sidebar-menu.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="<?php echo base_url();?>assets/backend/js/bootstrap/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <script src="<?php echo base_url();?>assets/backend/js/chart/chartist/chartist.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/chart/knob/knob.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/chart/knob/knob-chart.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/chart/apex-chart/apex-chart.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/chart/apex-chart/stock-prices.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/prism/prism.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/clipboard/clipboard.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/counter/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/counter/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/counter/counter-custom.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/custom-card/custom-card.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/notify/bootstrap-notify.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/dashboard/default.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/notify/index.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/datepicker/date-picker/datepicker.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/datepicker/date-picker/datepicker.custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo base_url();?>assets/backend/js/script.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/theme-customizer/customizer.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/app.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>

</html>