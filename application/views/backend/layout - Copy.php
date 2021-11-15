<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Portal Data Kabupaten Banyuwangi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/Ionicons/css/ionicons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/loader.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/skin-light.css"> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/select2.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/toastr.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/bootstrap-datepicker.min.css">
    <script type="text/javascript">var site = '<?php echo base_url(); ?>';</script>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <header class="main-header">
            <a class="logo"> <span class="logo-mini"><img src="<?php echo base_url();?>assets/backend/img/logo.png" alt="materialize logo"></span>  <span class="logo-lg">Portal Data</span> </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> 
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url();?>assets/backend/img/user2-160x160.jpg" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo $this->ion_auth->user()->row()->full_name; ?></span> 
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo base_url();?>assets/backend/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                    <p><?php echo $this->ion_auth->user()->row()->full_name; ?><small><?php echo $this->ion_auth->user()->row()->email; ?></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left"> <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right"> <a href="<?php echo base_url(); ?>login/logout/" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active" id="mn"  onclick="load('main/dashboard','#contents'); switch_menu(this);"><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>Data Dasar</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('data_dasar','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Setup Data Indikator</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>RPJMD</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('rpjmd/visi','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Visi</span></a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/misi','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Misi</span></a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/tujuan','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Tujuan</span></a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/sasaran','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Sasaran</span></a>
                            </li>
                            <li id="mn" onclick="load('rpjmd/program','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Program</span></a>
                            </li>
                            <li id="mn" onclick="load('rpjmd','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Indikator</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>Indikator Kinerja Utama</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('iku/tujuan','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Tujuan</span></a>
                            </li>
                            <li id="mn" onclick="load('iku/indikator','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Indikator</span></a>
                            </li>
                            <li id="mn" onclick="load('iku','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Data IKU</span></a>
                            </li>                            
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>Indikator SDGS</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('sdgs/tujuan','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Tujuan / Goals</span></a>
                            </li>
                            <li id="mn" onclick="load('sdgs','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Indikator SDGS</span></a>
                            </li>     
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>SPM</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
<!--                             <li id="mn" onclick="load('spm/sasaran','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Sasaran </span></a>
                            </li> -->
                            <li id="mn" onclick="load('spm','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Indikator SPM</span></a>
                            </li>     
                        </ul>
                    </li>

                             
                    <li class="header">Extras</li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>Master</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('maintenance','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Satuan</span></a>
                            </li>
                            <li id="mn" onclick="load('master/urusan_skpd','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Urusan SKPD</span></a>
                            </li>      
                            <li id="mn" onclick="load('master/skpd','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>SKPD</span></a>
                            </li>                            
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"> <i class="fa fa-folder"></i> <span>Pengguna</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li id="mn" onclick="load('maintenance','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Satuan</span></a>
                            </li>
                            <li id="mn" onclick="load('master/urusan_skpd','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>Urusan SKPD</span></a>
                            </li>      
                            <li id="mn" onclick="load('master/skpd','#contents'); switch_menu(this);">
                                <a href="javascript:void(0)"> <i class="fa fa-files-o"></i>  <span>SKPD</span></a>
                            </li>                            
                        </ul>
                    </li>
                </ul>
            </section>
        </aside>
        <div class="content-wrapper">
            <div id="contents">
            </div>
        </div>
        <div class="modal fade" id="ajax-modal" role="dialog">
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
        

        <div id="ajax-delete" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center modal-hapus">
                        <!-- <img src="<?php echo base_url();?>assets/default/img/sent.png" alt="" width="50" height="46"> -->
                        <h3>Apakah anda yakin menghapus data?</h3>
                        <div id="modal_content"></div>
                        <div class="m-t-20"> 
                            <button type="button" data-dismiss="modal" class="btn btn-flat btn-info margin">Cancel</button>
                            <button type="button" id="btn-delete" class="btn btn-flat btn-danger margin">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">LKP3 Universitas Brawijaya</a>.</strong>
        </footer>
    </div>
    <script src="<?php echo base_url();?>assets/backend/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/fastclick/fastclick.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/adminlte.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/jquery.bootpag.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/bootstrap-datepicker.min.js"></script>    
    <script src="<?php echo base_url();?>assets/backend/js/select2.full.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/toastr.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/demo.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/custom.js"></script>
</body>

</html>