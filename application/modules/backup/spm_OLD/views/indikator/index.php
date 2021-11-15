<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="col-xl-12 col-sm-12 layout-top-spacing">
	<div class="statbox widget box box-shadow">
		<div class="widget-header">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 col-12">
					<h5>INDIKATOR SPM</h5>
				</div>
			</div>
		</div>
		<div class="widget-content widget-content-area">
            <form>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="urusan" class="col-xl-4 col-sm-4 col-sm-4 col-form-label">Urusan Pemerintahan</label>
                            <div class="col-xl-8 col-lg-8 col-sm-8">
								<?php 
									if (!$this->ion_auth->in_group(array(1,2))){
										echo form_dropdown('urusan', $this->portal->get_my_urusan(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
									}
									else {
										echo form_dropdown('urusan', $this->portal->get_urusan_spm(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
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
<div class="col-xl-12 col-sm-12 layout-top-spacing">
	<div class="statbox widget box box-shadow">
		<div class="widget-content widget-content-area">
			<div id="content_items"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	get_items();
	$(document).ready(function() {
		$(".select2").select2();
	});	

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'spm/list', {
	        search_field: $('#search').val(),
	  		urusan:$('#urusan').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

</script>