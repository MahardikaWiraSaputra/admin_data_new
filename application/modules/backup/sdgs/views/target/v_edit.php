<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">EDIT SDGS TARGET</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_sdgs_target">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>
							<div class="form-group row mb-2">
								<?php echo form_label('Pilar Pembangunan', 'f_pilar', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-4 col-lg-4 col-sm-4">
									<?php echo form_dropdown('f_pilar', $list_pilar, $detail->PILAR_ID, 'id="f_pilar", class="form-control select2", onchange="get_tujuan()"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan / Goals', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="tujuan">
										<?php echo form_dropdown('f_tujuan', 'Pilih Tujuan', $detail->TUJUAN_ID, 'id="f_pilar", class="form-control select2"'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Target Pembangunan', 'f_target', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_target', 'id' => 'f_target', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->TARGET]); ?>
								</div>
							</div>
							<div class="form-group row my-4">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_target()" >Simpan Data</button>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	get_tujuan();
    feather.replace();
    $(".select2").select2();


	function get_tujuan(){
		var skpdID = $('select[id="f_pilar"]').val();
		$("#tujuan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/target/get_tujuan/'+skpdID, '#tujuan');
	}

	function update_target(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>sdgs/target/update",
            data: $("#form_sdgs_target").serializeArray(),
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
							load('sdgs/target/index', '#contents');
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
							load('sdgs/target/index', '#contents');           
					    }
					});
                }
            }
        });
        return false;
	}

</script>