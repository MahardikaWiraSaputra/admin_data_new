<footer role="contentinfo">
   <div class="clearfix">
      <ul class="list-unstyled list-inline pull-left">
         <li>
            <h6 style="margin: 0;">&copy; 2019 Banyuwangi</h6>
         </li>
      </ul>
      <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
   </div>
</footer>
</div>
</div>
</div>
<!-- Switcher -->
  <!-- Removed -->
<!-- /Switcher -->
<!-- Load site level scripts -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="<?= base_url('public/assets/js/jqueryui-1.10.3.min.js')?>"></script>                            <!-- Load jQueryUI -->
<script type="text/javascript" src="<?= base_url('public/assets/js/bootstrap.min.js')?>"></script>                              <!-- Load Bootstrap -->
<script type="text/javascript" src="<?= base_url('public/assets/js/enquire.min.js')?>"></script>                                    <!-- Load Enquire -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/velocityjs/velocity.min.js')?>"></script>                   <!-- Load Velocity for Animated Content -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/velocityjs/velocity.ui.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/wijets/wijets.js')?>"></script>                             <!-- Wijet -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/codeprettifier/prettify.js')?>"></script>               <!-- Code Prettifier  -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/bootstrap-switch/bootstrap-switch.js')?>"></script>         <!-- Swith/Toggle Button -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js')?>"></script>  <!-- Bootstrap Tabdrop -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/iCheck/icheck.min.js')?>"></script>                         <!-- iCheck -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js')?>"></script> <!-- nano scroller -->
<script type="text/javascript" src="<?= base_url('public/assets/js/application.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/demo/demo.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/demo/demo-switcher.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/js/app.js')?>"></script> 
<!-- End loading site level scripts -->
<!-- Load pages level scripts-->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/smartmenus/jquery.smartmenus.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js')?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/fullcalendar/moment.min.js')?>"></script>    <!-- Moment.js Dependency -->
<script type="text/javascript" src="<?= base_url('public/assets/plugins/switchery/switchery.js')?>"></script>

<script src="<?= base_url('public/assets/js/bootstrap-notify.js') ?>"></script>

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/demo/demo-datatables.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/form-stepy/jquery.stepy.js') ?>"></script>
<!-- Stepy Plugin -->
<script type="text/javascript" src="<?= base_url('public/assets/demo/demo-formwizard.js') ?>"></script>
<script src="<?= base_url('public/assets/js/login.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('public/assets/plugins/progress-skylo/skylo.js') ?>"></script>
<!-- Skylo -->
<script type="text/javascript" src="<?= base_url('public/assets/demo/demo-custom-skylo.js') ?>"></script>

<script src="<?php bs() ?>public/assets/js/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<!-- <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script> -->

</body>
</html>
<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-app.js"></script>

<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase-functions.js"></script>


<!-- <script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script> -->
<script>
  // Initialize Firebase
  // TODO: Replace with your project's customized code snippet
  var config = {
    apiKey: "AIzaSyBl7Z4Ga55UQA2ao4Df2J4tnGMH57a1deI",
    authDomain: "sikawanbanyuwangi.firebaseapp.com",
    databaseURL: "https://sikawanbanyuwangi.firebaseio.com",
    projectId: "sikawanbanyuwangi",
    storageBucket: "sikawanbanyuwangi.appspot.com",
    messagingSenderId: "217299145242",
    appId: "1:217299145242:web:52ee55c86b5c7b14"
  };
  firebase.initializeApp(config);
</script>
<script type="text/javascript">
  window.onload = function() {
    firebase.auth().onAuthStateChanged(function(user) {
      if (user) {
        // User is signed in.
        var uid = user.uid;
        var email = user.email;
        var photoURL = user.photoURL;
        var phoneNumber = user.phoneNumber;
        var isAnonymous = user.isAnonymous;
        var displayName = user.displayName;
        var providerData = user.providerData;
        var emailVerified = user.emailVerified;
        console.log(uid);
      }
    });
  };
</script>

<!-- Notification Script -->
<script>
   <?php
      $success = $this->session->flashdata('success');
      $error   = $this->session->flashdata('error');
      if (!empty($success))
       {
      ?>
    $.notify({

         icon: 'glyphicon glyphicon-info-sign',
         title: '<b><i class="fa fa-exclamation-circle"></i> Notification</b><br>',
         message: "<?php echo $success ?>",
     },
     {


         type: "success success-noty col-md-3",
         allow_dismiss: true,
         placement: {
             from: "top",
             align: "right"
         },
         offset: 20,
         spacing: 10,
         z_index: 1431,
         delay: 5000,
         timer: 1000,
         animate: {
             enter: 'animated bounceInDown',
             exit: 'animated bounceOutUp'
         }
     });
   <?php
      }
      if (!empty($error))
       {
      ?>
    $.notify({

             icon: 'glyphicon glyphicon-info-sign',
             title: '<b><i class="fa fa-info-circle"></i> Notification</b><br>',
             message: "<?php echo $error ?>",
         },{


             type: "danger error-noty col-md-3",
             allow_dismiss: true,
             placement: {
                 from: "top",
                 align: "right"
             },
             offset: 20,
             spacing: 10,
             z_index: 1431,
             delay: 5000,
             timer: 1000,
             animate: {
                 enter: 'animated fadeInDown',
                 exit: 'animated fadeOutUp'
             }
         });
    <?php
      }
      ?>


   <?php
      if (!empty($message))
        {
      ?>
    $.notify({

         icon: 'glyphicon glyphicon-info-sign',
         title: '<b><i class="ti ti-check"></i> Notification</b><br>',
         message: '<?php echo $message ?>',
     },
     {

         type: "success success-noty col-md-3 col-md-offset-2",
         allow_dismiss: true,
         placement: {
             from: "top",
             align: "right"
         },
         offset: 20,
         spacing: 10,
         z_index: 1431,
         delay: 5000,
         timer: 1000,
         animate: {
             enter: 'animated bounceInDown',
             exit: 'animated bounceOutUp'
         }
     });
   <?php
      }
      ?>

</script>
