<?php
$this->load->view('adm/header');
$this->load->view('adm/sidebar_ajax');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php $this->load->view($page);?>
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('adm/footer');?>
