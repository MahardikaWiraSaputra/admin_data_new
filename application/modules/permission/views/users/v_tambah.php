<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row">
	<div class="col-md-12">
		<form id="form_users" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Username', 'username', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'username', 'id' => 'username', 'class' => 'form-control input-sm', 'placeholder' => 'Username']); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Fullname', 'full_name', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'full_name', 'id' => 'full_name', 'class' => 'form-control input-sm', 'placeholder' => 'Fullname']); ?>	
						</div>
					</div>	
				</div>	
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Email', 'email', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'email', 'id' => 'email', 'class' => 'form-control input-sm', 'placeholder' => 'Email']); ?>
						</div>
					</div>	
				</div>	
				<div class="col-md-6">
					<div class="form-group">
						<?php echo form_label('Password', 'password', array('class' => 'col-md-4 control-label-left')); ?>
						<div class="col-md-8">
							<?php echo form_input(['name' => 'password', 'id' => 'password', 'class' => 'form-control input-sm', 'placeholder' => 'Password']); ?>
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
										<?php echo form_radio('status', '1', TRUE); ?> Aktif
									</div>
								</div>
								<div class="col-md-4">
									<div class="radio">
										<?php echo form_radio('status', '0', FALSE); ?> Nonaktif
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
										<?php echo form_checkbox('groups[]', $row->id); ?> <?php echo  $row->description; ?>
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
            url  : "<?php echo base_url()?>permission/users/simpan",
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