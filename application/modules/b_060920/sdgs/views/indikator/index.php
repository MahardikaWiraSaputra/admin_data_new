<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-3 mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">SDGS INDIKATOR</h6>
	                <div class="float-right">
	                	<button class="btn btn-primary mb-3 mr-2" onclick="tambah_indikator()"><i data-feather="plus-circle"></i> tambah</button>
	                </div>
                </div>
	            <form>
	                <div class="row">
	                    <div class="col-sm-12">
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Pilar Pembangunan</label>
	                            <div class="col-xl-4 col-lg-4 col-sm-4">
									<?php echo form_dropdown('f_pilar', $filter_pilar, '', 'id="f_pilar", class="form-control select2", style="width:100%", onchange="get_tujuan(), get_items()"'); ?>
	                            </div>
	                        </div>
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Tujuan</label>
	                            <div class="col-xl-6 col-lg-6 col-sm-6">
									<div id="tujuan_pilar">
										<?php echo form_dropdown('f_tujuan', '', '', 'id="f_tujuan", class="form-control select2", style="width:100%"'); ?>
									</div>
	                            </div>
	                        </div>
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Target</label>
	                            <div class="col-xl-6 col-lg-6 col-sm-6">
									<div id="target_filter">
										<?php echo form_dropdown('f_target', '', '', 'id="f_target", class="form-control select2", style="width:100%"'); ?>
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
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
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
	get_tujuan();
	
	$(".select2").select2();

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'sdgs/list', {
	        search_field: $('#search').val(),
	  		pilar:$('#f_pilar').val(),
	  		tujuan:$('#f_tujuan').val(),
	  		target:$('#f_target').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function get_tujuan(){
		var pilarID = $('select[id="f_pilar"]').val();
		$("#tujuan_pilar").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/filter_tujuan/'+pilarID, '#tujuan_pilar');
	}

    function tambah_indikator(){
        load('sdgs/tambah/', '#contents');
    }
</script>