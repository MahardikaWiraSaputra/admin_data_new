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
    <title>Portal Data Login</title>
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
    <!-- page-wrapper Start-->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5"><img class="bg-img-cover bg-center" src="<?php echo base_url();?>assets/backend/images/login/1.jpg" alt="looginpage"></div>
                <div class="col-xl-7 p-0">
                    <div class="login-card">
                        <form class="theme-form login-form">
                            <h4>Login Portal SKPD</h4>
                            <h6>Silahkan Log in ke akun SKPD anda</h6>
                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control" type="text" id="username" name="username" required="" placeholder="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control" name="password" type="password" id="password" placeholder="*********">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Periode</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                    <select class="form-control selectpicker" id="periode" name="periode">
                                        <?php foreach ($this->portal->periode_tahun() as $key => $periode):?>
                                        <option value="<?php echo $periode['PERIODE_TAHUN']; ?>"><?php echo $periode['PERIODE_TAHUN']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><a id="submit-login" class="btn btn-primary btn-block" href="index.html" type="submit">Sign in</a></div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-wrapper end-->
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
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo base_url();?>assets/backend/js/script.js"></script>
    <script src="<?php echo base_url();?>assets/backend/js/app.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
    <script type="text/javascript">
        $(document).ready(function() {
            feather.replace();

            $('#submit-login').on('click',function(e){
                e.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();
                var periode = $('#periode').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo base_url('login/sign')?>",
                    dataType : "JSON",
                    data : {username: username, password: password, periode: periode},
                    cache : false,
                    success: function(data){
                        if(data.success == true) {
                            const toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                padding: '2em'
                            });
                            toast({
                                type: 'success',
                                title: data.message,
                                padding: '2em',
                            })

                            window.location = data.url;
                            setTimeout(function(){
                                window.location = data.url;
                            }, 3000);
                        }
                        else {
                            const toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                padding: '2em'
                            });
                            toast({
                                type: 'error',
                                title: data.message,
                                padding: '2em',
                            })
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>