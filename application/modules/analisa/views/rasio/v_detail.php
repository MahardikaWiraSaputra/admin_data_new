<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>

<div class="statbox widget box box-shadow mb-4 mt-4">
	<div class="widget-header">
		<div class="row">
			<div class="col-xl-10 col-md-10 col-sm-10 col-10">
				<h5>DETAIL INDIKATOR</h5>
			</div>
			<div class="col-xl-2 col-md-2 col-sm-2 col-2 text-right">
				<ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm mb-2 mr-2 rounded-circle" onclick="edit_indikator(<?php echo $detail->ID ?>)">
                        	<i data-feather="edit"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm mb-2 mr-2 rounded-circle" onclick="delete_indikator(<?php echo $detail->ID ?>)">
                        	<i data-feather="trash"></i>
                        </a>
                    </li>
                </ul>
			</div>
		</div>
	</div>
	<div class="widget-content widget-content-area">
		<div class="col-lg-12 mx-auto">
			<form id="form_indikator">
				<?php echo form_hidden(['f_id' => $detail->ID]); ?>
				<div class="form-group row mb-2">
					<?php echo form_label('SKPD', 'f_skpd', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
					<?php 
						if (!$this->ion_auth->in_group(array(1,2))){
							echo form_dropdown('f_skpd', $this->portal->get_my_skpd(), $detail->SKPD_ID, 'id="f_skpd", class="form-control select2", disabled="disabled", onchange="get_urusan()"'); 
						}
						else {
							echo form_dropdown('f_skpd', $this->portal->get_list_skpd(), $detail->SKPD_ID, 'id="f_skpd", class="form-control select2", disabled="disabled", onchange="get_urusan()"'); 
						}
					?>
					</div>
				</div>
				<div class="form-group row mb-2">
					<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<div id="frmurusan">
							<?php echo form_dropdown('f_urusan', $detail->URUSAN, $detail->URUSAN_ID, 'id="f_urusan", class="form-control select2", disabled="disabled"'); ?>
						</div>
					</div>
				</div>
				<div class="form-group row mb-2">
					<?php echo form_label('Indikator', 'f_indikator', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<?php echo form_input(['name' => 'f_indikator', 'id' => 'f_indikator', 'class' => 'form-control input', 'value' => $detail->INDIKATOR, 'disabled'=>'true']); ?>
					</div>
				</div>
				<div class="form-group row mb-2">
					<?php echo form_label('Satuan', 'f_satuan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<?php echo form_input(['name' => 'f_satuan', 'id' => 'f_satuan', 'class' => 'form-control input', 'value' => $detail->SATUAN, 'disabled'=>'true']); ?>
					</div>
				</div>
				<div class="form-group row mb-2">
					<?php echo form_label('Kategori Data', 'f_kategori', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<?php echo form_dropdown('f_kategori', $this->portal->filter_tipe(), $detail->TIPE_DATA, 'id="f_kategori", class="form-control select2", disabled="disabled"'); ?>
					</div>
				</div>
				<div class="form-group row mb-2">
					<?php echo form_label('Klasifikasi Data', 'f_klasifikasi', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<div class="row mb-1 my-1">
							<div class="col-md-3 col-3">
								<div class="n-chk">
								    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
								      <input type="checkbox" class="new-control-input" id="is_rpjmd" name="is_rpjmd" value="1" <?php if ($detail->RPJMD == 1) { echo 'checked'; } ?> disabled="disabled">
								      <span class="new-control-indicator"></span>RPJMD
								    </label>
								</div>
							</div>
							<div class="col-md-3 col-3">
								<div class="n-chk">
								    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
								      <input type="checkbox" class="new-control-input" id="is_renstra" name="is_renstra" value="1" <?php if ($detail->RENSTRA == 1) { echo 'checked'; } ?> disabled="disabled">
								      <span class="new-control-indicator"></span>RENSTRA
								    </label>
								</div>
							</div>
							<div class="col-md-3 col-3">
								<div class="n-chk">
								    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
								      <input type="checkbox" class="new-control-input" id="is_sdgs" name="is_sdgs" value="1" <?php if ($detail->SDGS == 1) { echo 'checked'; } ?> disabled="disabled">
								      <span class="new-control-indicator"></span>SDGS
								    </label>
								</div>
							</div>
							<div class="col-md-3 col-3">
								<div class="n-chk">
								    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
								      <input type="checkbox" class="new-control-input" id="is_spm" name="is_spm" value="1" <?php if ($detail->SPM == 1) { echo 'checked'; } ?> disabled="disabled">
								      <span class="new-control-indicator"></span>SPM
								    </label>
								</div>
							</div>

						</div>

					</div>
				</div>
				<div class="form-group row my-4">
					<label class="col-xl-3 col-sm-3 col-sm-3 col-form-label"></label>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<div id="buttons-container"></div>
					</div>
				</div>
				
			</form>	
		</div>
	</div>	
</div>

<script>
	$(".select2").select2();
	feather.replace();

	function edit_indikator(id) {
		$('#f_skpd').prop("disabled", false);
		$('#f_urusan').prop("disabled", false);
		$('#f_indikator').prop("disabled", false);
		$('#f_satuan').prop("disabled", false);
		$('#f_kategori').prop("disabled", false);
		$('#is_rpjmd').prop("disabled", false);
		$('#is_renstra').prop("disabled", false);
		$('#is_sdgs').prop("disabled", false);
		$('#is_spm').prop("disabled", false);
		$("#buttons-container").append('<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_indikator()" >Simpan </button>');
		$("#buttons-container").append('<button type="button" class="btn btn-dark my-2 mr-2" onclick="kembali()" >Kembali</button>');
	}

	function kembali(){
		load('data_dasar/indikator/index', '#contents');
	}

	function delete_indikator(id) {
		// alert('delete');
		swal({
			title: 'Apakah anda yakin?',
			text: "Data tidak dapat dikembalikan lagi!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result){
        	if (confirm) {
          		$.ajax({
             		url  : "<?php echo base_url()?>data_dasar/indikator/delete/"+id,
                	dataType: "JSON",
                	type: "POST",
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
									load('data_dasar/indikator/index', '#contents');
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
									load('data_dasar/indikator/index', '#contents');           
							    }
							});
		                }
                	}
          		});
        	} 
        	else {
          		swal("Cancelled", "Your imaginary file is safe :)", "error");
        	}
      	})
	}

	function get_urusan(){
		var skpdID = $('select[id="f_skpd"]').val();
		$("#frmurusan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('form_dropdown/dropdown/get_urusan/'+skpdID, '#frmurusan');
	}

	function update_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>data_dasar/indikator/update",
            data: $("#form_indikator").serializeArray(),
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
							load('data_dasar/indikator/index', '#contents');
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
							load('data_dasar/indikator/index', '#contents');           
					    }
					});
                }
            }
        });
        return false;
	}
</script>