<?php echo form_dropdown('f_sasaran', $form_sasaran, '', 'id="f_sasaran", class="form-control select2", style="width:100%", onchange="get_items()"'); ?>
<script type="text/javascript">
	$(".select2").select2();
</script>