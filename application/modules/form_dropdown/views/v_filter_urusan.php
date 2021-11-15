<?php echo form_dropdown('f_urusan', $filter_urusan, '', 'id="f_urusan", class="form-control select2", style="width:100%"'); ?>
<script type="text/javascript">
	$(document).ready(function() {
	    $(".select2").select2();
	});
</script>