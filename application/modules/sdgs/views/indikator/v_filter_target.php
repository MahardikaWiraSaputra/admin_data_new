<?php echo form_dropdown('f_target', $filter_target, '', 'id="f_target", class="form-control select2", style="width:100%", onchange="get_items()"'); ?>
<script type="text/javascript">
	$(".select2").select2();
	get_items();
</script>