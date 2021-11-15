<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">MASTER URUSAN SKPD</h3>
					<div class="box-tools pull-right">
					</div>
				</div>
				<div class="box-body">
					<div class="row">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="content_items"></div>
</section>
<script type="text/javascript">

	$(document).ready(function() {
		get_items();
	    $(".select2").select2();
	});	

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'master/urusan_skpd/daftar', {
	        search_field: $('#search').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

</script>