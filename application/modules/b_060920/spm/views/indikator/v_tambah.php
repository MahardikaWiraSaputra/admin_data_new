<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<form id="form_spm_indikator">
	<div class="row mt-3 mb-3">
	    <div class="col-xl-12 col-lg-12 col-md-12">
	        <div class="section general-info">
	            <div class="info">
	            	<h6>INPUT SPM INDIKATOR</h6>
	                <div class="row">
	                	<div class="col-lg-12 mx-auto">
							<div class="form-group row mb-2">
								<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-4 col-lg-4 col-sm-4">
									<?php echo form_dropdown('f_urusan', $form_urusan, '', 'id="f_urusan", class="form-control select2", onchange="form_sasaran()"'); ?>
								</div>
							</div>
							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="sasaran">
										<?php echo form_dropdown('f_sasaran', 'Pilih Sasaran', '', 'id="f_sasaran", class="form-control select2"'); ?>
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
	form_sasaran();
	ceklist_indikator();
    feather.replace();
    $(".select2").select2();

	function form_sasaran(){
		var urusanID = $('select[id="f_urusan"]').val();
		$("#sasaran").html('<i class="fa fa-refresh fa-spin"></i>');
		load('spm/form_sasaran/'+urusanID, '#sasaran');
	}

	function ceklist_indikator(){
	    $.post(site+'spm/ceklist_indikator', {
	        cari_indikator: $('#search').val(),
	    }, function(data) {
	        $("#indikator_items").html(data);
	    });
	}

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>spm/simpan",
            data: $("#form_spm_indikator").serializeArray(),
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
							load('spm/index', '#contents');
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
							load('spm/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>