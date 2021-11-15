<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="col-lg-12 mx-auto">
	<form id="form_indikator">
		<div class="form-group row mb-2">
			<?php echo form_label('SKPD', 'f_skpd', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
			<?php 
				if (!$this->ion_auth->in_group(array(1,2))){
					echo form_dropdown('f_skpd', $this->portal->get_my_skpd(), '', 'id="f_skpd", class="form-control select2", onchange="get_urusan()"'); 
				}
				else {
					echo form_dropdown('f_skpd', $this->portal->get_list_skpd(), '', 'id="f_skpd", class="form-control select2", onchange="get_urusan()"'); 
				}
			?>
			</div>
		</div>
		<div class="form-group row mb-2">
			<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
				<div id="frmurusan">
					<?php echo form_dropdown('f_urusan', '', '', 'id="f_urusan", class="form-control select2"'); ?>
				</div>
			</div>
		</div>
		<div class="form-group row mb-2">
			<?php echo form_label('Indikator', 'f_indikator', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
				<?php echo form_input(['name' => 'f_indikator', 'id' => 'f_indikator', 'class' => 'form-control input', 'placeholder' => 'Indikator']); ?>
			</div>
		</div>
		<div class="form-group row mb-2">
			<?php echo form_label('Satuan', 'f_satuan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
				<?php echo form_input(['name' => 'f_satuan', 'id' => 'f_satuan', 'class' => 'form-control input', 'placeholder' => 'Satuan']); ?>
			</div>
		</div>
		<div class="form-group row mb-2">
			<?php echo form_label('Kategori Data', 'f_kategori', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
				<?php echo form_dropdown('f_kategori', $this->portal->filter_tipe(), 'Makro', 'id="f_kategori", class="form-control select2"'); ?>
			</div>
		</div>
		<div class="form-group row mb-2">
			<?php echo form_label('Klasifikasi Data', 'f_klasifikasi', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
			<div class="col-xl-9 col-lg-9 col-sm-9">
				<div class="row mb-1 my-1">
					<div class="col-md-3 col-3">
						<div class="n-chk">
						    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
						      <input type="checkbox" class="new-control-input" name="is_rpjmd" value="1">
						      <span class="new-control-indicator"></span>RPJMD
						    </label>
						</div>
					</div>
					<div class="col-md-3 col-3">
						<div class="n-chk">
						    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
						      <input type="checkbox" class="new-control-input" name="is_renstra" value="1">
						      <span class="new-control-indicator"></span>RENSTRA
						    </label>
						</div>
					</div>
					<div class="col-md-3 col-3">
						<div class="n-chk">
						    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
						      <input type="checkbox" class="new-control-input" name="is_sdgs" value="1">
						      <span class="new-control-indicator"></span>SDGS
						    </label>
						</div>
					</div>
					<div class="col-md-3 col-3">
						<div class="n-chk">
						    <label class="new-control new-checkbox checkbox-outline-secondary new-checkbox-text">
						      <input type="checkbox" class="new-control-input" name="is_spm" value="1">
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
				<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator()" >Simpan Data</button>
			</div>
		</div>
		
	</form>	
</div>


<script>
	$(".select2").select2({dropdownParent: $('#ajax-modal')});

	function get_urusan(){
		var skpdID = $('select[id="f_skpd"]').val();
		$("#frmurusan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('form_dropdown/dropdown/get_urusan/'+skpdID, '#frmurusan');
	}

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>data_dasar/indikator/simpan",
            data: $("#form_indikator").serializeArray(),
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
					        $('#ajax-modal').modal('hide');
					        get_items();             
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
					        $('#ajax-modal').modal('hide');
					        get_items();             
					    }
					});
                }
            }
        });
        return false;
	}
</script>