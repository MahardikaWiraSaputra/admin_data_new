<?php echo form_dropdown('f_tujuan', $form_tujuan, '', 'id="f_tujuan", class="form-control select2", style="width:100%", onchange="form_target()"'); ?>
<script type="text/javascript">
	$(".select2").select2();
	form_target();
	function form_target(){
		var tujuanID = $('select[id="f_tujuan"]').val();
		$("#target").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/form_target/'+tujuanID, '#target');
	}
</script>