<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="col-xl-12 col-sm-12 layout-top-spacing">
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 col-12">
					<h5>SETUP DATA INDIKATOR</h5>
				</div>
			</div>
		</div>
		<div class="widget-content widget-content-area">
            <form>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group row">
                            <label for="skpd" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">SKPD</label>
                            <div class="col-xl-9 col-lg-9 col-sm-9">
								<?php 
									if (!$this->ion_auth->in_group(array(1,2))){
										echo form_dropdown('skpd', $this->portal->get_my_skpd(), '', 'id="skpd", class="form-control select2", style="width:100%", onchange="get_urusan(), get_items()"'); 
									}
									else {
										echo form_dropdown('skpd', $this->portal->get_list_skpd(), '', 'id="skpd", class="form-control select2", style="width:100%", onchange="get_urusan(), get_items()"'); 
									}
								?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Urusan</label>
                            <div class="col-xl-9 col-lg-9 col-sm-9">
								<div id="bidang_urusan">
									<?php echo form_dropdown('urusan', '', '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); ?>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group row">
                            <label for="skpd" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Kategori</label>
                            <div class="col-xl-9 col-lg-9 col-sm-9">
								<?php echo form_dropdown('tipe', $this->portal->get_tipe_data(), '', 'id="tipe", class="form-control select2", style="width:100%", onchange="get_items()"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
<div class="col-xl-12 col-sm-12 layout-top-spacing">
	<div class="statbox widget box box-shadow">
		<div class="widget-content widget-content-area">
			<div id="content_items"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	get_urusan();
	get_items();
	$(document).ready(function() {
		$(".disabled-results").select2();
	});	

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'data_dasar/indikator/list', {
	        search_field: $('#search').val(),
	  		skpd:$('#skpd').val(),
	  		urusan:$('#urusan').val(),
	  		tipe:$('#tipe').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function get_urusan(){
		var skpdID = $('select[id="skpd"]').val();
		$("#bidang_urusan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('data_dasar/get_urusan/'+skpdID, '#bidang_urusan');
	}

</script>