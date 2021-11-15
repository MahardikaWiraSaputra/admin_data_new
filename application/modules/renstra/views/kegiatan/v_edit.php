<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
	                <h6 class="">RENSTRA KEGIATAN SKPD</h6>
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
			            <form id="form_kegiatan">
			            	<?php echo form_hidden(['f_id' => $detail->ID]); ?>
			            	<div class="form-group row">
							   <label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">SKPD</label>
							   <div class="col-xl-10 col-lg-10 col-sm-10">
							      <?php
							             echo form_dropdown('skpd', $filter_skpd, $detail->SKPD_ID, 'id="skpd", class="form-control select2", style="width:100%", onchange="get_program()"');
							         ?>
							   </div>
							</div>
	                        <div class="form-group row">
	                            <label for="urusan" class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Program SKPD</label>
	                            <div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="bidang_program">
										<?php echo form_dropdown('f_program', $filter_program, $detail->PROGRAM_ID, 'id="f_program", class="form-control select2", style="width:100%"'); ?>
									</div>
	                            </div>
	                        </div>

							<div class="form-group row mb-2">
								<?php echo form_label('Kegiatan SKPD', 'f_kegiatan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_kegiatan', 'id' => 'f_kegiatan', 'class' => 'form-control', 'rows' =>'3','value' => $detail->KEGIATAN, 'placeholder' => 'Indikator Kegiatan SKPD']); ?>
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

    function get_program(){

        var skpdID = $('select[id="skpd"]').val();

        $("#bidang_program").html('<i class="fa fa-refresh fa-spin"></i>');

        load('renstra/kegiatan/get_program/'+skpdID, '#bidang_program');

    }

	function simpan_program(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>renstra/kegiatan/update",
            data: $("#form_kegiatan").serializeArray(),
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
							load('renstra/kegiatan/index', '#contents');       
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
							load('renstra/kegiatan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>