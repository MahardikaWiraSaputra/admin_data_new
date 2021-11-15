<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row">
	<div class="col-md-12">
		<form id="form_users" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Permission Key', 'perm_key', array('class' => 'col-md-6 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'perm_key', 'id' => 'perm_key', 'class' => 'form-control input-sm', 'placeholder' => 'Permission Key']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Permission Name', 'perm_name', array('class' => 'col-md-6 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'perm_name', 'id' => 'perm_name', 'class' => 'form-control input-sm', 'placeholder' => 'Permission Name']); ?>	
						</div>
					</div>	
				</div>	
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Groups', 'groups', array('class' => 'col-md-6 control-label-left')); ?>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-12">
									<?php foreach ($list_group as $key => $row) : ?>
									<div class="checkbox">
										<?php echo form_hidden('groups['.$row->id.']', $row->id); ?>
										<?php echo form_checkbox(array('name' => 'value['.$row->id.']','id' => 'value', 'value' => '1')); ?> <?php echo $row->description; ?>
									</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
			<div class="form-group btn-simpan">
				<?php echo form_label('', '', array('class' => 'col-md-2 control-label-left')); ?>
				<div class="col-md-2">
					<a class="btn btn-success btn-block" onclick="simpan();">Simpan</a>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	function simpan(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/group_permissions/simpan",
            data: $("#form_users").serializeArray(),
            dataType: "JSON",
            success: function(response){
                if(response.success == true) {
                    swal({
				      	title: 'Sukses',
				      	text: response.message,
				      	type: 'success',
				      	padding: '2em',
				      	showConfirmButton: false, 
				      	timer: 1500
				    }).then((result) => {
					    if (result.dismiss === Swal.DismissReason.timer) {
					       	$('#ajax-modal').modal('hide');
					       	get_items();          
					    }
					});
                }
                else {
                    swal({
				    	title: 'Gagal',
				    	text: response.message,
				    	type: 'error',
				    	padding: '2em',
				    	showConfirmButton: false, 
				    	timer: 1500
				    }).then((result) => {
					    if (result.dismiss === Swal.DismissReason.timer) {
					    	$('#ajax-modal').modal('hide');
					    }
					});
                }
            }
        });
        return false;
	}
</script>