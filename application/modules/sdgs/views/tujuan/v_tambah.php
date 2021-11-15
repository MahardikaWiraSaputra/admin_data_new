<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-3 mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
            	<h6>INPUT SDGS TUJUAN</h6>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_sdgs_tujuan">
							<div class="form-group row mb-2">
								<?php echo form_label('Pilar Pembangunan', 'f_pilar', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-4 col-lg-4 col-sm-4">
									<?php echo form_dropdown('f_pilar', $list_pilar, '', 'id="f_pilar", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan / Goals', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_tujuan', 'id' => 'f_tujuan', 'class' => 'form-control', 'rows' =>'2', 'placeholder' => 'Tujuan Pembangunan']); ?>
								</div>
							</div>
							
							<div class="form-group row my-4">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_tujuan()" >Simpan Data</button>
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
    feather.replace();
    $(".select2").select2();

	function simpan_tujuan(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>sdgs/tujuan/simpan",
            data: $("#form_sdgs_tujuan").serializeArray(),
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
							load('sdgs/tujuan/index', '#contents');       
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
							load('sdgs/tujuan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>