<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<?php
  $user = $this->ion_auth->user()->row();
  $users_permissions = group_priviliges();
  $new_arr = array();
  foreach ($users_permissions as $key => $value)
  {
    $new_arr[$value] = $value;
  }

$asn = $this->sikawan->asn();
$bolehtteapp = array('196910051989032005','199502042017101018','197911282006071003');
$suratkeluar = array('197911282006071003','199502042017101018');
$setup       = array('197911282006071003','199502042017101018');
$ttepbb      = array('197911282006071003','198502242015021001','197012121997031010');
$me   = array('197911282006071003');
?>





<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="active" id="mn" ><a href=""><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

      <?php if (in_array($asn->PNS_PNSNIP,$suratkeluar)): ?>
        <li  class="" id="mn" onclick="load('office/inbox','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-inbox"></i>
            <span>Inbox</span>
          </a>
        </li>
      <?php endif ?>

      <?php //if (in_array('Register Surat',$new_arr)): ?>
      <li class="" id="mn" onclick="load('office/register_surat','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <span>Reg. Surat Masuk</span>
        </a>
      </li>
      <?php //endif ?>

      <?php if (in_array($asn->PNS_PNSNIP,$suratkeluar)): ?>
        <li  class="" id="mn" onclick="load('office/surat_keluar','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-file-o"></i>
            <span>Reg. Surat Keluar</span>
          </a>
        </li>
      <?php endif ?>

      <?php //if (in_array($asn->PNS_PNSNIP,$pengaduan)): ?>
        <li  class="" id="mn" onclick="load('pengaduan','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-bullhorn"></i>
            <span>Pengaduan</span>
          </a>
        </li>
      <?php //endif ?>




      <li  class="" id="mn"  onclick="load('office/tugas_disposisi','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
        <i class="fa fa-address-card-o" aria-hidden="true"></i>
        <span>Tugas/Disposisi</span>
        </a>
      </li>



      <!-- <li class="" id="mn" onclick="load('office/surat_masuk','#contents');switch_menu(this);" >
        <a href="javascript:void(0)">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <span>Reg. Surat Masuk</span>
        </a>
      </li> -->



      <li  class="" id="mn" onclick="load('tte','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
      		<i class="fa fa-file-o"></i>
        	<span>TTE</span>
        </a>
      </li>
<?php if (in_array($asn->PNS_PNSNIP,$bolehtteapp)): ?>
      <li  class="" id="mn" onclick="load('tte/app','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
      		<i class="fa fa-file-o"></i>
        	<span>TTE APP</span>
        </a>
      </li>
<?php endif ?>


      <li  class="" id="mn" onclick="load('office/asn','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
      		<i class="fa fa-users"></i>
        	<span>Daftar Pegawai</span>
        </a>
      </li>


      <li  class="" id="mn" onclick="load('office/setup/org','#contents');switch_menu(this);">
        <a href="javascript:void(0)">
      		<i class="fa fa-file-o"></i>
        	<span>Struktur ORG.</span>
        </a>
      </li>


      <?php if (in_array($asn->PNS_PNSNIP,$setup)): ?>
        <li  class="" id="mn" onclick="load('office/setup/operator','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-file-o"></i>
            <span>Setup</span>
          </a>
        </li>
      <?php endif ?>


      <?php if (in_array($asn->PNS_PNSNIP,$ttepbb)): ?>
        <li  class="" id="mn" onclick="load('tte/pbb','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-file-o"></i>
            <span>TTE PBB</span>
          </a>
        </li>
      <?php endif ?>


      <?php if (in_array($asn->PNS_PNSNIP,$me)): ?>
        <li  class="" id="mn" onclick="load('fbs/get_users','#contents');switch_menu(this);">
          <a href="javascript:void(0)">
            <i class="fa fa-bullhorn"></i>
            <span>Pengaduan</span>
          </a>
        </li>
      <?php endif ?>



      <!-- <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span>Ref</span>
          <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

          </span>
        </a>
        <ul class="treeview-menu">
          <li  class="" id="mn" onclick="load('fbs/get_users','#contents');switch_menu(this);">
            <a href="javascript:void(0)">
          		<i class="fa fa-file-o"></i>
            	<span>Usr</span>
            </a>
          </li>
        </ul>
      </li> -->




    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<?php //echo json_encode($new_arr)?>
