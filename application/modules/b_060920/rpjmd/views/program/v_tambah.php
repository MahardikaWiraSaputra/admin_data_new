<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-3">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Input RPJMD Program</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_program">
							<div class="form-group row mb-2">
								<?php echo form_label('Urusan Pemerintah Daerah', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_urusan', $urusan_list, '', 'id="f_urusan", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran Pemerintah Daerah', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_sasaran', $sasaran_list, '', 'id="f_sasaran", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Program Pemerintah Daerah', 'f_program', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_program', 'id' => 'f_program', 'class' => 'form-control', 'rows' =>'3', 'placeholder' => 'Program Pemerintah Daerah']); ?>
								</div>
							</div>
							<div class="form-group row my-3">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_program()" >Simpan Data</button>
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

	function simpan_program(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/program/simpan",
            data: $("#form_program").serializeArray(),
            dataType: "JSON",
            success: function(response){
            	console.log(response.success);
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
							load('rpjmd/program/index', '#contents');       
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
							load('rpjmd/program/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>