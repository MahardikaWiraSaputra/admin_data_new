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
	        	<form id="form_skpd">
	        		<?php echo form_hidden(['f_skpd_id' => $detail['ID']]); ?>
					<div class="form-group row mb-3">
						<?php echo form_label('Kode SKPD', 'f_kode_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_kode_skpd', 'id' => 'f_kode_skpd', 'class' => 'form-control input', 'value' => $detail['KODE_SKPD']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Nama SKPD', 'f_nama_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_nama_skpd', 'id' => 'f_nama_skpd', 'class' => 'form-control input', 'value' => $detail['NAMA_SKPD']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Alamat SKPD', 'f_alamat_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_alamat_skpd', 'id' => 'f_alamat_skpd', 'class' => 'form-control input', 'value' => $detail['ALAMAT_SKPD']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Telp SKPD', 'f_telp_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_telp_skpd', 'id' => 'f_telp_skpd', 'class' => 'form-control input', 'value' => $detail['TELP']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Fax SKPD', 'f_fax_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_fax_skpd', 'id' => 'f_fax_skpd', 'class' => 'form-control input', 'value' => $detail['FAX']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Website SKPD', 'f_web_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_web_skpd', 'id' => 'f_web_skpd', 'class' => 'form-control input', 'value' => $detail['WEB']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Email SKPD', 'f_email_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_email_skpd', 'id' => 'f_email_skpd', 'class' => 'form-control input', 'value' => $detail['EMAIL']]); ?>
						</div>
					</div>
					
					<div class="form-group row my-3">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_skpd()" >Simpan Data</button>
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


	function update_skpd(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/skpd/update",
            data: $("#form_skpd").serializeArray(),
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
							load('master/skpd/index', '#contents');
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