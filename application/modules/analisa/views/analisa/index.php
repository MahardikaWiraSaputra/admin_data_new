<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                    <h6>Analisa indikator</h6>
                    <div class="float-right">
                    </div>
                </div>
	            <form>
	                <div class="row" style="display: none">
	                    <div class="col-sm-5">
	                        <div class="form-group row">
	                            <label for="urusan" class="col-xl-5 col-sm-5 col-sm-5 col-form-label">Indikator Berdasarkan Urusan</label>
	                            <div class="col-xl-12 col-lg-12 col-sm-12">
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
	                </div>
	            </form>            	
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-2">
                                <div class="row mb-3">
                                    <div class="col-xl-9 col-lg-9 col-sm-9">
                                    </div>
                                    <div class="col-lg-3 text-right">
                                        <div class="input-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" id="search" onkeyup="get_items()">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i data-feather="search" class="text-primary"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
	$(".select2").select2();
	feather.replace();
	
	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'analisa/daftar', {
	        search_field: $('#search').val(),
	        urusan:$('#urusan').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

</script>
