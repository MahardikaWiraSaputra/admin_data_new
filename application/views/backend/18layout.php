<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Aplikasi Manajemen Data dan Pelaporan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400&family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/css/styles.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend//plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>assets/backend/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/select2/select2.min.js"></script>
    <script type="text/javascript">var site = '<?php echo base_url(); ?>';</script>
</head>
<body class="sidebar-noneoverflow">
    
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            
            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="#">
                        <img src="<?php echo base_url();?>assets/backend/img/logo.png" class="navbar-logo" alt="logo">
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="index.html" class="nav-link"> SIMDP </a>
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><i data-feather="target"></i></a>
                </li>
            </ul>

            <ul class="navbar-item flex-row search-ul">
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="power"></i>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <img src="<?php echo base_url();?>assets/backend/img/profile-17.jpg" class="img-fluid mr-2" alt="avatar">
                                <div class="media-body">
                                    <h5><?php echo $this->ion_auth->user()->row()->full_name; ?></h5>
                                    <p><?php echo $this->ion_auth->user()->row()->company; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="#">
                                <i data-feather="user"></i> <span>My Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="<?php echo base_url();?>login/logout/">
                                <i data-feather="log-out"></i> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <div class="sidebar-wrapper sidebar-theme">
            <nav id="sidebar">
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="home menu" id="mn" onclick="load('main/dashboard','#contents'); switch_menu(this);">
                        <a href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" class="home dropdown-toggle">
                            <div class="active"><i data-feather="home"></i> <span>Dashboard</span></div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><i data-feather="minus"></i><span>MANAJEMEN DATA</span></div>
                    </li>
                    <li class="menu">
                        <a href="#data-dasar" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="layers"></i> <span>Data Dasar</span></div>
                            <div><i data-feather="chevron-right"></i></div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="data-dasar" data-parent="#accordionExample">
                            <li id="mn" onclick="load('data_dasar/indikator','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Setup Data Indikator </span> </a>
                            </li>
                            <li id="mn" onclick="load('data_dasar','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Capaian Indikator </span> </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="#data-rpjmd" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="layers"></i> <span>Indikator RPJMD</span></div>
                            <div><i data-feather="chevron-right"></i></div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="data-rpjmd" data-parent="#accordionExample">
                            <li id="mn" onclick="load('rpjmd/visi','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Visi </span> </a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/misi','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Misi </span> </a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/tujuan','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Indikator Tujuan </span> </a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/sasaran','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Indikator Sasaran </span> </a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/program','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Indikator Program </span> </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="#data-sdgs" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="layers"></i> <span>Indikator SDGS</span></div>
                            <div><i data-feather="chevron-right"></i></div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="data-sdgs" data-parent="#accordionExample">
                            <li id="mn" onclick="load('sdgs/tujuan','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Tujuan / Goals </span> </a>
                            </li>
                            <li id="mn" onclick="load('sdgs','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Indikator SDGS</span> </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="#data-spm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="layers"></i> <span>Indikator SPM</span></div>
                            <div><i data-feather="chevron-right"></i></div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="data-spm" data-parent="#accordionExample">
                            <li id="mn" onclick="load('spm','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="feather-sub" data-feather="layout"></i> <span class="sub-menu">Indikator Capaian</span> </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><i data-feather="minus"></i><span>ANALISIS</span></div>
                    </li>
                    <li class="menu" id="mn" onclick="alert('menu belum tersedia'); switch_menu(this);">
                        <a href="javascript:void(0)" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="shuffle"></i><span>Analisis Data</span></div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><i data-feather="minus"></i><span>LAPORAN</span></div>
                    </li>

                    <li class="menu" id="mn" onclick="alert('menu belum tersedia'); switch_menu(this);">
                        <a href="javascript:void(0)" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="printer"></i><span>Laporan LKJIP</span></div>
                        </a>
                    </li>
                    <li class="menu" id="mn" onclick="alert('menu belum tersedia'); switch_menu(this);">
                        <a href="javascript:void(0)" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="printer"></i><span>Laporan LKPJ</span></div>
                        </a>
                    </li>
                    <li class="menu" id="mn" onclick="alert('menu belum tersedia'); switch_menu(this);">
                        <a href="javascript:void(0)" aria-expanded="false" class="dropdown-toggle">
                            <div class=""> <i data-feather="printer"></i><span>Laporan LPPD</span></div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><i data-feather="minus"></i><span>MASTER</span></div>
                    </li>                    

                    <li class="menu" id="mn" onclick="alert('menu belum tersedia'); switch_menu(this);">
                        <a href="javascript:void(0)" aria-expanded="false" class="dropdown-toggle">
                            <div class=""><i data-feather="users"></i><span>Pengguna</span></div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <!-- <div id="contents"></div> -->
                <?php $this->load->view($page);?>
                <div class="modal hide fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
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
            </div>
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © 2020 <a target="_blank" href="#">LKP3</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Sistem Informasi Manajemen Data dan Pelaporan </p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url();?>assets/backend/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/jquery.bootpag.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/font-icons/feather/feather.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            feather.replace();
            $(".select2").select2();
            App.init();
        });
    </script>
    
</body>

</html>