<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
	                <h6 class="">RPJMD KEGIATAN SKPD</h6>
		            <div class="float-right"></div>
	            </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_program">

			            	<div class="form-group row">
							   <label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Urusan</label>
							   <div class="col-xl-10 col-lg-10 col-sm-10">
							      <?php 
											if (!$this->ion_auth->in_group(array(1,2))){
												echo form_dropdown('urusan', $this->portal->get_my_urusan(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_program()"'); 
											}
											else {
												echo form_dropdown('urusan', $this->portal->get_list_urusan(), '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_program()"'); 
											}
										?>
							   </div>
							</div>
	                        <div class="form-group row">
	                            <label for="urusan" class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Program</label>
	                            <div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="bidang_program">
										<?php echo form_dropdown('f_program', $filter_program, '', 'id="f_program", class="form-control select2", style="width:100%"'); ?>
									</div>
	                            </div>
	                        </div>

							<!-- <div class="form-group row mb-2">
								<?php echo form_label('Program SKPD', 'f_program', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_program', $program_list, '', 'id="f_program", class="form-control select2"'); ?>
								</div>
							</div> -->

							<div class="form-group row mb-2">
								<?php echo form_label('Kegiatan SKPD', 'f_kegiatan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_kegiatan', 'id' => 'f_kegiatan', 'class' => 'form-control', 'rows' =>'3', 'placeholder' => 'Indikator Kinerja Program SKPD']); ?>
								</div>
							</div>
							
							<div class="form-group row my-4">
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

    function get_programX(){

        var skpdID = $('select[id="skpd"]').val();

        $("#bidang_program").html('<i class="fa fa-refresh fa-spin"></i>');

        load('rpjmd/kegiatan/get_program/'+skpdID, '#bidang_program');

    }

    function get_program(){

        var skpdID = $('select[id="urusan"]').val();

        $("#bidang_program").html('<i class="fa fa-refresh fa-spin"></i>');

        load('rpjmd/kegiatan/get_program/'+skpdID, '#bidang_program');

    }

	function simpan_program(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/kegiatan/simpan",
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
							load('rpjmd/kegiatan/index', '#contents');       
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
							load('rpjmd/kegiatan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>