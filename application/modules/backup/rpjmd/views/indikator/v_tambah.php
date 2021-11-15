<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">RPJMD Indikator</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <div id="form_program">
							<div class="form-group row mb-2">
								<?php echo form_label('Urusan Pemerintah Daerah', 'f_urusan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
								<div class="col-xl-9 col-lg-9 col-sm-9">
									<?php echo form_input(['name' => 'f_urusan', 'id' => 'f_urusan', 'class' => 'form-control', 'value' => $detail->URUSAN]); ?>
								</div>
							</div>
							<div class="form-group row mb-2">
								<?php echo form_label('Program Pemerintah Daerah', 'f_program', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
								<div class="col-xl-9 col-lg-9 col-sm-9">
									<?php echo form_textarea(['name' => 'f_program', 'id' => 'f_program', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->PROGRAM]); ?>
								</div>
							</div>
						</div>	
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
            	<form id="form_indikator">
        		<input type="hidden" name="f_program" value="<?php echo $detail->ID;?>">
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

		        				<div class="form-group row my-4">
					<label class="col-xl-3 col-sm-3 col-sm-3 col-form-label"></label>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator()" >Simpan Data</button>
					</div>
				</div>
		   		</form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    feather.replace();
    $(".select2").select2();

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/simpan",
            data: $("#form_indikator").serialize(),
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
							load('rpjmd/program/index', '#contents');       
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
							load('rpjmd/program/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>