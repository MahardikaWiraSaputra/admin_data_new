<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mt-2 mb-2">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">GROUP PERMISSIONS</h6>
	                <div class="float-right">
                        <span onclick="tambah();" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i>&nbsp; Tambah Data</span>
	                </div>
                </div>
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
  	get_items();
  	$(".select2").select2();

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='ajax_loading'></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'master/group_permissions/daftar', {
	        search_field: $('#search').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function tambah(){
  		ajax_modal('master/group_permissions/tambah');
	}
</script>