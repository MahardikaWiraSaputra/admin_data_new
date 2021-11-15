<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<form id="form_sdgs_indikator">
<div class="row mt-3 mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
            	<h6>INPUT SDGS INDIKATOR</h6>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <div id="sdgs_indikator">
							<div class="form-group row mb-2">
								<?php echo form_label('Pilar Pembangunan', 'f_pilar', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-4 col-lg-4 col-sm-4">
									<?php echo form_dropdown('f_pilar', $form_pilar, '', 'id="f_pilar", class="form-control select2", onchange="form_tujuan()"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan / Goals', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="tujuan">
										<?php echo form_dropdown('f_tujuan', 'Pilih Tujuan', '', 'id="f_tujuan", class="form-control select2"'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Target Pembangunan', 'f_target', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="target">
										<?php echo form_dropdown('f_target', 'Pilih Target', '', 'id="f_target", class="form-control select2"'); ?>
									</div>
								</div>
							</div>
						</div>	
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
    	        <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-2">
                        <div class="row mb-3">
                            <div class="col-xl-9 col-lg-9 col-sm-9">
                            	<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator()" >Simpan Data</button>
                            </div>
                            <div class="col-lg-3 text-right">
                                <div class="input-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" id="search" onkeyup="get_indikator()">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i data-feather="search" class="text-primary"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        		<div id="indikator_items"></div>
            </div>
        </div>
    </div>
</div>
</form>

<script type="text/javascript">
	form_tujuan();
	ceklist_indikator();
    feather.replace();
    $(".select2").select2();

	function form_tujuan(){
		var pilarID = $('select[id="f_pilar"]').val();
		$("#tujuan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/form_tujuan/'+pilarID, '#tujuan');
	}

	function ceklist_indikator(){
	    $.post(site+'sdgs/ceklist_indikator', {
	        cari_indikator: $('#search').val(),
	    }, function(data) {
	        $("#indikator_items").html(data);
	    });
	}

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>sdgs/simpan",
            data: $("#form_sdgs_indikator").serializeArray(),
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
							load('sdgs/index', '#contents');       
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
							load('sdgs/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>