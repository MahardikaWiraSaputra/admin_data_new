<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>

<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">INPUT SATUAN</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_satuan">
					<div class="form-group row mb-3">
						<?php echo form_label('Kode Satuan', 'f_kode_satuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_kode_satuan', 'id' => 'f_kode_satuan', 'class' => 'form-control input', 'placeholder' => 'Kode Satuan']); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Satuan', 'f_nama_satuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_nama_satuan', 'id' => 'f_nama_satuan', 'class' => 'form-control input', 'placeholder' => 'Satuan']); ?>
						</div>
					</div>
					<div class="form-group row my-3">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_satuan()" >Simpan Data</button>
						</div>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<script>
	$(".select2").select2();

	function simpan_satuan(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/satuan/simpan",
            data: $("#form_satuan").serialize(),
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
					        load('master/satuan/index', '#contents');
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
					            
					    }
					});
                }
            }
        });
        return false;
	}
</script>