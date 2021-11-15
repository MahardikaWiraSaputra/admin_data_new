<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">SPM INDIKATOR</h6>
	                <div class="float-right">
	                </div>
                </div>
	            <form>
	                <div class="row">
	                    <div class="col-sm-7">
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Urusan Pemerintahan</label>
	                            <div class="col-xl-9 col-lg-9 col-sm-9">
									<?php 
										if (!$this->ion_auth->in_group(array(1,2))){
											echo form_dropdown('urusan', $filter_urusan, '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
										}
										else {
											echo form_dropdown('urusan', $filter_urusan, '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
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
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
	                <div class="float-right">
	                	
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                            	<div id="content_items"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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