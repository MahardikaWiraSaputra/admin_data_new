<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Edit Indikator</h6>
	                <div class="float-right">
	                	<!-- <button class="btn btn-sm btn-outline-primary btn-danger mb-2 mr-2" onclick="window.history.back();" data-placement="top" title="Kembali"><i data-feather="rotate-ccw"></i></button>
	                	<button class="btn btn-sm btn-primary mb-2 mr-2" onclick="location.reload(true);" data-placement="top" title="Refresh"><i data-feather="refresh-cw"></i></button> -->
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
							<?php echo form_input(['name' => 'f_satuan', 'id' => 'f_satuan', 'class' => 'form-control input', 'value' => $detail['SATUAN']]); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Kategori Data', 'f_kategori', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_kategori', $this->portal->filter_tipe(), $detail['TIPE_DATA'], 'id="f_kategori", class="form-control select2"'); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Klasifikasi Data', 'f_klasifikasi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="col-md-3 col-3">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_rpjmd" name="is_rpjmd" value="1" <?php if ($detail['RPJMD'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>RPJMD
									    </label>
									</div>
								</div>
								<div class="col-md-3 col-3">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_renstra" name="is_renstra" value="1" <?php if ($detail['RENSTRA'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>RENSTRA
									    </label>
									</div>
								</div>
								<div class="col-md-3 col-3">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_sdgs" name="is_sdgs" value="1" <?php if ($detail['SDGS'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>SDGS
									    </label>
									</div>
								</div>
								<div class="col-md-3 col-3">
									<div class="n-chk">
									    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
									      <input type="checkbox" class="new-control-input" id="is_spm" name="is_spm" value="1" <?php if ($detail['SPM'] == 1) { echo 'checked'; } ?>>
									      <span class="new-control-indicator"></span>SPM
									    </label>
									</div>
								</div>

							</div>

						</div>
					</div>

					<div class="form-group row my-4">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Capaian Indikator</label>
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