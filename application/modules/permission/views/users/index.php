<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">USERS</h3>
					<div class="box-tools pull-right">
						<span onclick="tambah();" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Tambah Data</span>
					</div>
				</div>
				<div class="box-body">
					<form class="form-horizontal" name="filterform" id="filterform">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<div class="col-sm-3">
										<label class="control-label">STATUS</label>
									</div>
									<div class="col-sm-9">
										<?php echo form_dropdown( 'status', array('all'=>'Semua','yes'=>'Aktif', 'no'=>'Nonaktif'), 'all', 'id="status" class="form-control select2" onchange="get_items()"')?>
									</div>
								</div>
							</div>
							<div class="col-md-4">
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="col-sm-3">
										<label class="control-label">PENCARIAN</label>
									</div>
									<div class="col-sm-9">
										<div class="input-group input-group-sm">
											<input type="text" name="search" value="" id="search" class="form-control input-sm" placeholder="USER">
											<div class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat" onchange="get_items()" onclick="get_items()">CARI</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div id="content_items"></div>
		</div>
	</div>
</section>
<script type="text/javascript">
  	get_items();
  	$(".select2").select2();

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='ajax_loading'></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'permission/users/list', {
	        search_field: $('#search').val(),
	        status: $('#status').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function tambah(){
  		ajax_modal('permission/users/tambah');
	}
</script>