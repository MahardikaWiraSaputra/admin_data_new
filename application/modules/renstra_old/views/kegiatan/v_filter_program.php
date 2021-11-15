<?php echo form_dropdown('program', $filter_program, '', 'id="program", class="form-control select2", style="width:100%", onchange="get_items()"'); ?>
<script type="text/javascript">
	$(document).ready(function() {
	    $(".select2").select2();
	});
</script>