<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-2 mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between mb-4">
                	<h6 class="">Setup Data Indikator</h6>
	                <div class="float-right">
                        <button class="btn btn-primary mb-2 mr-2" onclick="tambah_indikator()"><i data-feather="plus-circle"></i> tambah</button>
	                </div>
                </div>
	            <form>
	                <div class="row">
	                    <div class="col-sm-5">
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">SKPD</label>
	                            <div class="col-xl-9 col-lg-9 col-sm-9">
									<div id="skpd">
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
	                        </div>
	                        <div class="form-group row mb-2">
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
	                        <div class="form-group row mb-2">
	                            <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Kategori</label>
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
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-2">
                                <div class="row mb-2">
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
	get_urusan();
	get_items();
    $(".select2").select2();
    feather.replace();

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

    function tambah_indikator(){
        load('data_dasar/indikator/tambah/', '#contents');
    }
</script>