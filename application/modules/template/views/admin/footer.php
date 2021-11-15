<div class="modal fade"  id="ajax-modal"  tabindex="-1" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">

      <div id="ajax-modalin"></div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade"  id="ajax-modal-pdf"  tabindex="-1" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">

      <div id="ajax-modalin-pdf"></div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Copyright &copy; 2019 <a href="">Banyuwangi</a>.</strong>
</footer>


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

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url()?>template/adm/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url()?>template/adm/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>template/adm/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url()?>template/adm/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url()?>template/adm/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>template/adm/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()?>template/adm/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()?>template/adm/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url()?>template/adm/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url()?>template/adm/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url()?>template/adm/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url()?>template/adm/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>template/adm/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>template/adm/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url()?>template/adm/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>template/adm/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url()?>template/adm/ajaxfileupload.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.bootpag.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.expander.js"></script>
<script src="<?php echo base_url()?>template/adm/bower_components/PACE/pace.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url()?>template/adm/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url()?>template/adm/dist/js/demo.js"></script> -->
<script type="text/javascript">

  // To make Pace works on Ajax calls
  $(document).ajaxStart(function () {
   // Pace.restart()
  })


function onSignOutClick() {

  firebase.auth().signOut().then(function() {
    console.log('Signed Out');
    window.location.href = '<?php echo base_url()?>users/auth/logout';
  }, function(error) {
    console.error('Sign Out Error', error);
  });

  // firebase.auth().signOut();
  // window.location.href = '<?php echo base_url()?>users/auth/logout';
}
//////
function switch_menu(obj)
{
    // $("#mn > div").attr("class", "");
    // $(obj).attr("class", "active");
    $(obj).toggleClass("active");
    $(obj).siblings().removeClass("active");
}
function switch_tab(obj)
{
    $(".tabs > div").attr("class", "tab");
    $(obj).attr("class", "current_tab");
}
function formatNumber(input)
{
    var num = input.value.replace(/\,/g,'');
    if(!isNaN(num)){
    if(num.indexOf('.') > -1){
    num = num.split('.');
    num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
    if(num[1].length > 2){
    alert('You may only enter two decimals!');
    num[1] = num[1].substring(0,num[1].length-1);
    } input.value = num[0]+'.'+num[1];
    } else{ input.value = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'') };
    }
    else{ alert('Anda hanya diperbolehkan memasukkan angka!');
    input.value = input.value.substring(0,input.value.length-1);
    }
}
function send_form(formObj,action,responseDIV)
{
    $.ajax({
        url: site+"/"+action,
        data: $(formObj.elements).serialize(),
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post",
        dataType: "html"
    });
    return false;
}
function send_form_loading(formObj,action,responseDIV)
{
    var image_load = "<i class='fa fa-refresh fa-spin'></i>";
    $.ajax({
        url: site+"/"+action,
        data: $(formObj.elements).serialize(),
        beforeSend: function(){
            $(responseDIV).html(image_load);
        },
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post",
        dataType: "html"
    });
    return false;
}
function load_no_loading(page,div){
    $.ajax({
        url: site+"/"+page,
        success: function(response){
            $(div).html(response);
        },
        dataType:"html"
    });
    return false;
}
function load(page,div){
   var image_load = "<div align='center'><i class='fa fa-refresh fa-spin'></i></div>";
    $.ajax({
        url: site+page,
        beforeSend: function(){
            $(div).html(image_load);
        },

        success: function(response){
            $(div).html(response);
        },

      	error: function (xhr, ajaxOptions, thrownError) {
        	alert(xhr.status);
        	alert(thrownError);
      	},
        dataType:"html"
    });
    return false;
}



function ajaxmodal(urlnya){
    $('#ajax-modalin').html('');
		$('#ajax-modalin').load(urlnya, '', function(){
		$('#ajax-modal').modal();
		});
}
function ajaxmodalpdf(urlnya){
    $('#ajax-modalin-pdf').html('');
		$('#ajax-modalin-pdf').load(urlnya, '', function(){
		$('#ajax-modal-pdf').modal();
		});
}

function view_pdf(url){

  var options = {
    pdfOpenParams: { view: 'FitH' }
  };
  if(PDFObject.supportsPDFs){
    PDFObject.embed(url, "#ajax-modalin-pdf",options);
  	$('#ajax-modal-pdf').modal();
  } else {
  //alert("Boo, inline PDFs are not supported by this browser");
  window.open(url, '_blank');
  }

}
</script>
</body>
</html>
