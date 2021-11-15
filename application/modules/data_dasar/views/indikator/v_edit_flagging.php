<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
        <div id="general-info" class="section general-info">
            <div class="info">
				<form id="form_indikator">
					<?php echo form_hidden(['f_id' => $detail['ID']]); ?>
					<div class="form-group row mb-2">
						<?php echo form_label('SKPD', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
						<?php 
							if (!$this->ion_auth->in_group(array(1,2))){
								echo form_dropdown('f_skpd', $this->portal->get_my_skpd(), $detail['SKPD_ID'], 'id="f_skpd", class="form-control", onchange="get_urusan()"'); 
							}
							else {
								echo form_dropdown('f_skpd', $this->portal->get_list_skpd(), $detail['SKPD_ID'], 'id="f_skpd", class="form-control",onchange="get_urusan()"'); 
							}
						?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div id="frmurusan">
								<?php echo form_dropdown('f_urusan', $detail['URUSAN'], $detail['URUSAN_ID'], 'id="f_urusan", class="form-control"'); ?>
							</div>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Indikator', 'f_indikator', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_indikator', 'id' => 'f_indikator', 'class' => 'form-control input', 'value' => $detail['INDIKATOR']]); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Satuan', 'f_satuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_input(['name' => 'f_satuan', 'id' => 'f_satuan', 'class' => 'form-control input', 'value' => $detail['SATUAN'],'readonly'=>true]); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Kategori', 'f_kategori', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_kategori[]', $filter_kategori,  explode(", ", $detail['KATEGORI']), 'id="f_kategori", class="form-control" multiple="multiple",, disabled="disabled"'); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Klasifikasi Data', 'f_klasifikasi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_rpjmd" name="is_rpjmd" onclick="cek_target()" value="1" <?php if ($detail['RPJMD'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>RPJMD
									    </label>
									</div>
								</div>
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_renstra" name="is_renstra" onclick="cek_target()" value="1" <?php if ($detail['RENSTRA'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>RENSTRA
									    </label>
									</div>
								</div>
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_sdgs" name="is_sdgs" value="1" <?php if ($detail['SDGS'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>SDGS
									    </label>
									</div>
								</div>
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_spm" name="is_spm" value="1" <?php if ($detail['SPM'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>SPM
									    </label>
									</div>
								</div>
								<div class="col-md-3 col-3">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_tidak_terisi" name="is_tidak_terisi" value="1" <?php if ($detail['TIDAK_TERISI'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>TIDAK TERISI
									    </label>
									</div>
								</div>

							</div>

						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Klasifikasi Laporan', 'f_klasifikasi_laporan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="lkjip" name="lkjip" value="1" <?php if ($detail['LKJIP'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>LKJIP
									    </label>
									</div>
								</div>
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="lkpj" name="lkpj" value="1" <?php if ($detail['LKPJ'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>LKPJ
									    </label>
									</div>
								</div>
								<div class="col-md-2 col-2">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="lppd" name="lppd" value="1" <?php if ($detail['LPPD'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>LPPD
									    </label>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="form-group row my-4">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_indikator()" >Simpan</button>
						</div>
					</div>
				</form>	          	
            </div>
        </div>

<script type="text/javascript">
	$("#f_kategori").select2();
	$("#f_skpd").select2();
	$("#f_urusan").select2();
	feather.replace();
	cek_target()

	$( document ).ready(function() {
		
		$('#is_capaian').val('ya');
		if ($('#is_tidak_terisi').prop('checked')) {
			$('#is_capaian').val('tidak');
			$('#capaian_indikator').hide();
		} else {
			$('#capaian').prop('checked',true);
		}
	})

	function cek_capaian()
	{
		if ($('#capaian').prop('checked')) {
			$('#is_capaian').val('ya');
			$('#capaian_indikator').show();
		} else {
			$('#is_capaian').val('tidak');
			$('#capaian_indikator').hide();
		}
	}

	function cek_target()
	{
		if ($('#is_rpjmd').prop('checked')) {
			$('#target_indikator').show()
			$('#is_target').val('ya');
		} else if ($('#is_renstra').prop('checked')) {
			$('#target_indikator').show()
			$('#is_target').val('ya');
		} else {
			$('#target_indikator').hide()
			$('#is_target').val('tidak');
		}
	}

	$('#is_rpjmd').on('change', function(){
	    this.value = this.checked ? 1 : 0;
	});

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
							$("#ajax-modal-flagging").modal('hide');
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