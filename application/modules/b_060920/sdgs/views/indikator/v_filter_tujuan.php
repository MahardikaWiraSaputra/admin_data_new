<?php echo form_dropdown('f_tujuan', $filter_tujuan, '', 'id="f_tujuan", class="form-control select2", style="width:100%", onchange="get_target(), get_items()"'); ?>
<script type="text/javascript">
    $(".select2").select2();
    get_target();
    
    function get_target(){
		var tujuanID = $('select[id="f_tujuan"]').val();
		$("#target_filter").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/filter_target/'+tujuanID, '#target_filter');
	}
</script>