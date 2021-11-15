<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">SPM : SASARAN</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<form class="form-horizontal">
							<div class="col-md-5">
								<div class="form-group">
									<div class="col-sm-3">
										<label class="control-label">Urusan</label>
									</div>
									<div class="col-sm-9">
										<div id="bidang_urusan">
										<?php 
											if (!$this->ion_auth->in_group(array(1,2))){
												echo form_dropdown('urusan', $this->portal->get_my_urusan(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
											}
											else {
												echo form_dropdown('urusan', $this->portal->get_list_urusan(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
											}
											
										?>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="content_items"></div>
</section>
<script type="text/javascript">
	get_items();
	$(document).ready(function() {
	    $(".select2").select2();
	});	

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'spm/sasaran/list', {
	        search_field: $('#search').val(),
	        urusan:$('#urusan').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

</script>