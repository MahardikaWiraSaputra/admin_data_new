<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row">
	<form id="ind-form" class="form-horizontal">
		<div class="col-md-12">
			<div class="form-group">
				<?php echo form_label('Urusan', 'urusan', array('class' => 'col-md-3 control-label')); ?>
				<div class="col-md-6">
					<?php echo form_input(['name' => 'urusan', 'id' => 'urusan', 'class' => 'form-control input', 'value' => $bidang_urusan->URUSAN, 'readonly'=>'true'] ); ?> 
					<?php echo form_hidden(['urusan_id' => $bidang_urusan->ID_URUSAN]); ?>
				</div>
			</div>	
			<div class="form-group">
				<?php echo form_label('Bidang', 'bidang', array('class' => 'col-md-3 control-label')); ?>
				<div class="col-md-6">
					<?php echo form_input(['name' => 'bidang', 'id' => 'bidang', 'class' => 'form-control input', 'value' => $bidang_urusan->BIDANG_URUSAN, 'readonly'=>'true'] ); ?> 
					<?php echo form_hidden(['bidang_id' => $bidang_urusan->ID]); ?>
				</div>
			</div>			
			<div class="form-group">
				<?php echo form_label('Indikator Data', 'telp', array('class' => 'col-md-3 control-label')); ?>
				<div class="col-md-6">
					<?php echo form_input(['name' => 'indikator', 'id' => 'indikator', 'class' => 'form-control input', 'placeholder' => 'Indikator Data']); ?>
				</div>
			</div>		

			<div class="form-group">
				<?php echo form_label('', '', array('class' => 'col-md-3 control-label-left')); ?>
				<div class="col-md-2">
					<a class="btn btn-success btn-block" onclick="simpanreg();">Simpan</a>
				</div>
			</div>
		</div>
	</form>
</div>


<script>
	function simpanreg(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>data_dasar/indikator/simpan",
            data: $("#ind-form").serializeArray(),
            dataType: "JSON",
            success: function(response){
            	console.log(response.success);
                if(response.success == true) {
                	$('#ajax-modal').modal('hide');
                	get_items();
                    toastr.remove();
                    toastr['success'](response.message, '', {
                        positionClass: 'toast-bottom-right'
                    });
                }
                else {
                    toastr.remove();
                    toastr['error'](response.message, '', {
                        positionClass: 'toast-bottom-right'
                    });
                }
            }
        });
        return false;
	}
</script>