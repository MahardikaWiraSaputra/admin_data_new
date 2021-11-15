<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Edit Indikator</h6>
	                <div class="float-right">
	                </div>
                </div>
				<form id="form_indikator">
					<?php echo form_hidden(['f_id' => $detail['ID']]); ?>
					<div class="form-group row mb-2">
						<?php echo form_label('SKPD', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
						<?php 
							if (!$this->ion_auth->in_group(array(1,2))){
								echo form_dropdown('f_skpd', $this->portal->get_my_skpd(), $detail['SKPD_ID'], 'id="f_skpd", class="form-control select2", onchange="get_urusan()"'); 
							}
							else {
								echo form_dropdown('f_skpd', $this->portal->get_list_skpd(), $detail['SKPD_ID'], 'id="f_skpd", class="form-control select2",  onchange="get_urusan()"'); 
							}
						?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div id="frmurusan">
								<?php echo form_dropdown('f_urusan', $detail['URUSAN'], $detail['URUSAN_ID'], 'id="f_urusan", class="form-control select2"'); ?>
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
							<?php echo form_dropdown('f_satuan', $this->portal->filter_satuan(), $detail['SATUAN'], 'id="f_satuan", class="form-control select2"'); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Kategori', 'f_kategori', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_kategori[]', $filter_kategori,  explode(", ", $detail['KATEGORI']), 'id="f_kategori", class="form-control select2" multiple="multiple"'); ?>
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
								<div class="col-md-2 col-2">
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
					<div class="form-group row mb-2">
					<?php echo form_label('Input data realisasi', 'f_klasifikasi_laporan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
					<div class="col-xl-10 col-lg-10 col-sm-10">
						<div class="row mb-1 my-1">
							<div class="col-md-3 col-3">
								<div class="n-chk">
								    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
								      <input type="checkbox" class="new-control-input" name="capaian" value="1" id="capaian" onclick="cek_capaian()">
									  <input type="hidden" name="is_capaian" id="is_capaian">
								      <span class="new-control-indicator"></span>Ya
								    </label>
								</div>
							</div>
						</div>
					</div>
				</div>
					<div class="form-group row my-4" id="target_indikator">
						<input type="hidden" id="is_target" name="is_target" value="tidak">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Target Indikator</label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="table-responsive mailbox-messages">
									<table class="table table-bordered table-condensed mb-4">
										<thead>
											<tr>
												<?php for ($i=2011; $i < 2021; $i++) { ?>
													<th class="text-center"><?php echo $i; ?></th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<tr>
												<?php for ($i=2011; $i < 2021; $i++) { ?>
												<input type="hidden" class="form-control" name="f_tahun_target[]" id="f_tahun_target" value="<?php echo $i; ?>">
												<td><input type="text" class="form-control" name="f_target[]" id="f_target" value="<?php echo $detail['target'.$i]; ?>"></td>
												<?php } ?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row my-4" id="capaian_indikator">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">realisasi Indikator</label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="table-responsive mailbox-messages">
									<table class="table table-bordered table-condensed mb-4">
				                        <thead>
				                            <tr>
				                                <?php for ($i=2011; $i < 2021; $i++) { ?>
				                                    <th class="text-center"><?php echo $i; ?></th>
				                                <?php } ?>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        	<tr>
				                        		<?php for ($i=2011; $i < 2021; $i++) { ?>
				                        		<input type="hidden" class="form-control" name="f_tahun[]" id="f_capaian" value="<?php echo $i; ?>">
		                                        <td><input type="text" class="form-control" name="f_capaian[]" id="f_capaian" value="<?php echo $detail[$i]; ?>" ></td>
		                                    	<?php } ?>
				                        	</tr>
				                        </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row my-4">
						<label class="col-xl-3 col-sm-3 col-sm-3 col-form-label"></label>
						<div class="col-xl-9 col-lg-9 col-sm-9">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_indikator()" >Simpan </button>
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