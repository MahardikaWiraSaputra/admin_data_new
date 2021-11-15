<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                    <h6 class="">Laporan Renstra Program Kegiatan SKPD</h6>
                    <div class="float-right" style="display: none">
                       <button class="btn btn-primary mb-2 mr-2" onclick="tambah_program();"><i data-feather="plus-circle"></i> Cetak Laporan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3 mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="general-info" class="section general-info">
            <div class="info">
	            <form>
	                <div class="row">
	                    <div class="col-sm-5">
	                   	 <div class="form-group row">
							   <label class="col-xl-3 col-sm-3 col-sm-3 col-form-label">SKPD</label>
							   <div class="col-xl-9 col-lg-9 col-sm-9">
							      <?php
							             echo form_dropdown('skpd', $filter_skpd, '', 'id="skpd", class="form-control select2", style="width:100%", onchange="get_urusan(), get_items()"');
							         ?>
							   </div>
							</div>
	                        <div class="form-group row">
	                            <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Urusan</label>
	                            <div class="col-xl-9 col-lg-9 col-sm-9">
									<div id="bidang_urusan">
										<?php 
										echo form_dropdown('urusan', $filter_urusan, '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); 
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

	    $.post(site+'laporan/Laporan_renstra/daftar', {
	        search_field: $('#search').val(),
	        skpd: $('#skpd').val(),
	        urusan:$('#urusan').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function get_urusan(){

        var skpdID = $('select[id="skpd"]').val();

        $("#bidang_urusan").html('<i class="fa fa-refresh fa-spin"></i>');

        load('data_dasar/filter_urusan/'+skpdID, '#bidang_urusan');

    }

</script>