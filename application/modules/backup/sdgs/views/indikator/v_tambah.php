<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-4 mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
            	<h6>INPUT SDGS INDIKATOR</h6>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_sdgs_indikator">
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
							<div class="form-group row mb-2">
								<?php echo form_label('Indikator', 'f_target', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div class="table-responsive">
							            <table class="table table-bordered table-hover table-condensed mb-4">
							                <thead>
							                    <tr>
							                        <th width="50">#</th>
							                        <th>INDIKATOR</th>
							                    </tr>
							                </thead>
							                <tbody>
							                    <?php $no='0' ; foreach($ceklist as $row): $no++; ?>
							                    <tr>
													<td class="checkbox-column">
					                                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
					                                        <input type="checkbox" class="new-control-input todochkbox" name="f_indikator[]" id="f_indikator[]" value="<?php echo $row['ID_INDIKATOR'];?>">
					                                        <span class="new-control-indicator"></span>
					                                    </label>
					                                </td>
							                        <td class=""><?php echo $row['INDIKATOR']; ?></td>
							                    </tr>
							                    <?php endforeach;?>
							                </tbody>
							            </table>
							        </div>
								</div>
							</div>

							<div class="form-group row my-4">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator()" >Simpan Data</button>
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
	form_tujuan();
    feather.replace();
    $(".select2").select2();

	function form_tujuan(){
		var pilarID = $('select[id="f_pilar"]').val();
		$("#tujuan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('sdgs/form_tujuan/'+pilarID, '#tujuan');
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