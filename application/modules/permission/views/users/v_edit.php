<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row">
	<div class="col-md-12">
		<form id="form_users" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_hidden('id',  $detail->id); ?>
						<?php echo form_label('Username', 'username', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'username', 'id' => 'username', 'class' => 'form-control input-sm', 'value' => $detail->username, 'readonly' => 'true']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Fullname', 'full_name', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'full_name', 'id' => 'full_name', 'class' => 'form-control input-sm', 'value' => $detail->full_name]); ?>	
						</div>
					</div>	
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Email', 'email', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'email', 'id' => 'email', 'class' => 'form-control input-sm', 'value' => $detail->email]); ?>
						</div>
					</div>	
				</div>	
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Password', 'password', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'password', 'id' => 'password', 'class' => 'form-control input-sm', 'placeholder' => 'xxx']); ?>
						</div>
					</div>	
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Status', 'status', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-4">
									<div class="radio">
										<?php echo form_radio(array('name' => 'status', 'value' => '1', 'checked' => ('1' == $detail->active) ? TRUE : FALSE )); ?> Aktif
									</div>
								</div>
								<div class="col-md-4">
									<div class="radio">
										<?php echo form_radio(array('name' => 'status', 'value' => '0', 'checked' => ('0' == $detail->active) ? TRUE : FALSE )); ?> Nonaktif
									</div>								
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Groups', 'groups', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-12">
									<?php foreach ($list_groups as $key => $row) : ?>
									<div class="checkbox">
										<?php echo form_checkbox(array('name' => 'groups[]', 'value' => $row->id, 'checked' => (in_array($row->name, explode(",", $detail->group_name))) ? TRUE : FALSE ));?> <?php echo  $row->description; ?>
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
					<a class="btn btn-success btn-block" onclick="update();">Simpan</a>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	function update(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>permission/users/update",
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