<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-3">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Input Data Indikator</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_data_wilayah">
					<div class="form-group row mb-2">
						<?php echo form_label('Indikator', 'f_indikator', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_indikator', $form_indikator, '', 'id="f_indikator", class="form-control select2"'); ?>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Tipe Wilayah', 'f_tipe_wilayah', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_tipe_wilayah', $tipe_wilayah, '', 'id="f_tipe_wilayah", class="form-control select2"'); ?>
						</div>
					</div>
					<div class="form-group row my-4" id="kecamatan">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Capaian Indikator</label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<div class="row mb-1 my-1">
								<div class="table-responsive mailbox-messages">
									<table class="table table-bordered table-condensed mb-4">
				                        <thead>
				                            <tr>
				                            	<th class="text-center" width="50">NO</th>
				                            	<th class="text-center"> NAMA KECAMATAN</th>
				                               	<?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
				                                    <th class="text-center"><?php echo $i; ?></th>
				                                <?php } ?>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        	<?php $no = 0; foreach ($list_kecamatan as $key => $rows): $no++?>
				                        	<tr>
				                        		<td class="text-center"><?php echo $no; ?></td>
				                        		<td><?php echo $rows['NAMA_KEC']; ?></td>
				                        		
				                        		<?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
			                        			<input type="hidden" class="form-control" name="f_kecamatan[]" id="f_kecamatan" value="<?php echo $rows['NO_KEC']; ?>">
				                        		<input type="hidden" class="form-control" name="f_tahun[]" id="f_tahun" value="<?php echo $i; ?>">
		                                        <td><input type="text" class="form-control" name="f_capaian[]" id="f_capaian" ></td>
		                                    	<?php } ?>
				                        	</tr>
					                        <?php endforeach; ?>
				                        </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="desa">
						<div class="form-group row mb-2">
							<?php echo form_label('Nama Kecamatan', 'f_nama_kecamatan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
							<div class="col-xl-10 col-lg-10 col-sm-10">
							<?php echo form_dropdown('f_nama_kecamatan', $drop_kecamatan, '', 'id="f_nama_kecamatan", class="form-control select2", style="width:100%", onchange="get_desa()"'); ?>
							</div>
						</div>
						<div id="filter_desa"></div>
					</div>
					<div class="form-group row my-2">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" id="simpan_kecamatan" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator_kecamatan()" >Simpan Data</button>
							<button type="button" id="simpan_desa" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator_desa()" >Simpan Data</button>
						</div>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>	
<script type="text/javascript">
	$( document ).ready(function() {
		$('#kecamatan').hide();
		$('#desa').hide();
		$('#simpan_kecamatan').hide();
		$('#simpan_desa').hide();
	});

	$('#f_tipe_wilayah').change(function() {
		var id = this.value;
		if(id == 1){
			$('#kecamatan').show();
			$('#desa').hide();
			$('#simpan_kecamatan').show();
			$('#simpan_desa').hide();
		} else {
			$('#desa').show();
			$('#kecamatan').hide();
			$('#simpan_kecamatan').hide();
			$('#simpan_desa').show();
		}
		console.log();
	});

	function get_desa(){
		var kecamatanID = $('select[id="f_nama_kecamatan"]').val();
		$("#filter_desa").html('<i class="fa fa-refresh fa-spin"></i>');
		load('kewilayahan/filter_desa/'+kecamatanID, '#filter_desa');
		console.log(kecamatanID);
	}

    feather.replace();
    $(".select2").select2();
											
	function simpan_indikator_kecamatan(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>kewilayahan/simpan",
            data: $("#form_data_wilayah").serializeArray(),
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
							load('kewilayahan/index', '#contents');
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
							load('kewilayahan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}

	function simpan_indikator_desa(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>kewilayahan/simpan_indikator_desa",
            data: $("#form_data_wilayah").serializeArray(),
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
							load('kewilayahan/index', '#contents');
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
							load('kewilayahan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>