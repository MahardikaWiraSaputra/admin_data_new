<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Edit SKPD</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_users">
	        		<?php echo form_hidden(['f_users_id' => $detail['id']]); ?>
					<div class="form-group row mb-3">
						<?php echo form_label('Username', 'f_username', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_username', 'id' => 'f_username', 'class' => 'form-control input', 'value' => $detail['username']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Nama Lengkap', 'f_fullname', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_fullname', 'id' => 'f_fullname', 'class' => 'form-control input', 'value' => $detail['full_name']]); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Unit', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_skpd', $filter_skpd, $detail['skpd_id'], 'id="f_skpd", class="form-control select2"'); ?>
						</div>
					</div>					
					<div class="form-group row mb-3">
						<?php echo form_label('Email', 'f_email', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_email', 'id' => 'f_email', 'class' => 'form-control input', 'value' => $detail['email']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Telp', 'f_telp', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_telp', 'id' => 'f_telp', 'class' => 'form-control input', 'value' => $detail['phone']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Password', 'f_password', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['type' => 'password', 'name' => 'f_password', 'id' => 'f_password', 'class' => 'form-control input']); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Groups', 'f_groups', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php foreach ($list_groups as $key => $row) : ?>
							<div class="n-chk">
							    <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
							      <input type="checkbox" class="new-control-input" name="f_groups[]" value="<?php echo $row['id'] ?>" <?php if (in_array($row['id'], explode(",", $detail['GROUPS']))) { echo 'checked'; } ?>>
							      <span class="new-control-indicator"></span><?php echo $row['description']; ?>
							    </label>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					
					<div class="form-group row my-3">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_users()" >Simpan Data</button>
						</div>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(".select2").select2();
	feather.replace();


	function update_users(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/users/update",
            data: $("#form_users").serializeArray(),
            dataType: "JSON",
            success: function(response){
                if(response.success == true) {
                    swal({
				      title: 'Sukses',
				      text: "Data berhasil disimpan",
				      type: 'success',
				      padding: '2em',
				      showConfirmButton: false, 
				      timer: 1500
				    }).then((result) => {
					    if (result.dismiss === Swal.DismissReason.timer) {
							load('master/users/index', '#contents');
					    }
					});
                }
                else {
                    swal({
				      title: 'Gagal',
				      text: "Data tidak dapat disimpan",
				      type: 'error',
				      padding: '2em',
				      showConfirmButton: false, 
				      timer: 1500
				    }).then((result) => {
					    if (result.dismiss === Swal.DismissReason.timer) {
							// load('master/skpd/index', '#contents');          
					    }
					});
                }
            }
        });
        return false;
	}
</script>