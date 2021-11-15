<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Edit Urusan</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_skpd">
	        		<?php echo form_hidden(['f_urusan_id' => $detail['ID']]); ?>
					<div class="form-group row mb-3">
						<?php echo form_label('Kode Urusan', 'f_kode_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_kode_urusan', 'id' => 'f_kode_urusan', 'class' => 'form-control input', 'value' => $detail['KODE_URUSAN']]); ?>
						</div>
					</div>
					<div class="form-group row mb-3">
						<?php echo form_label('Urusan', 'f_nama_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_nama_urusan', 'id' => 'f_nama_urusan', 'class' => 'form-control input', 'value' => $detail['URUSAN']]); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Unit SKPD', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_skpd[]', $filter_skpd,  explode(",", $detail['SKPD_PENGAMPU']), 'id="f_skpd", class="form-control select2" multiple="multiple"'); ?>
						</div>
					</div>
					<div class="form-group row my-3">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_urusan()" >Simpan Data</button>
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


	function update_urusan(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/urusan/update",
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
							load('master/urusan/index', '#contents');
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