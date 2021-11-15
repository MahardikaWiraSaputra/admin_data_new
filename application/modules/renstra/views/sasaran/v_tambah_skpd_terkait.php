<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<h3>RENSTRA Sasaran SKPD</h>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_sasaran">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>
							<div class="form-group row mb-2">
								<?php echo form_label('Visi SKPD', 'f_visi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_visi', 'id' => 'f_visi', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->VISI, 'disabled'=>'true']); ?>
								</div>
							</div>
							<div class="form-group row mb-2">
								<?php echo form_label('Misi SKPD', 'f_misi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_misi', 'id' => 'f_misi', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->MISI, 'disabled'=>'true']); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Unit Kerja SKPD', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
								<?php 
									if (!$this->ion_auth->in_group(array(1,2))){
										echo form_dropdown('f_skpd', $this->portal->get_my_skpd(), $detail->SKPD_ID, 'id="f_skpd", class="form-control select2", onchange="get_urusan()",disabled="disabled"'); 
									}
									else {
										echo form_dropdown('f_skpd', $this->portal->get_list_skpd(), $detail->SKPD_ID, 'id="f_skpd", class="form-control select2", onchange="get_urusan()",disabled="disabled"'); 
									}
								?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="frmurusan">
									<?php echo form_dropdown('f_urusan', $detail->URUSAN, $detail->URUSAN_ID, 'id="f_urusan", class="form-control select2",disabled="disabled"'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan SKPD', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_tujuan', $tujuan_list, $detail->TUJUAN_ID, 'id="f_tujuan", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran Pemda', 'f_sasaran_pemda', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_sasaran_pemda', $rpjmd_sasaran, $detail->SASARAN_RPJMD_ID, 'id="f_sasaran_pemda", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran SKPD', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_sasaran', 'id' => 'f_sasaran', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->SASARAN, 'disabled'=>'true']); ?>
								</div>
							</div>
			                <div class="form-group row my-4">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<div id="buttons-container"></div>
								</div>
							</div>
						</form>
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
            	<form id="form_skpd_sasaran">
        		<input type="hidden" name="f_sasaran" value="<?php echo $detail->ID;?>">
				<div class="table-responsive">
		            <table class="table table-bordered table-hover table-condensed mb-4">
		                <thead>
		                    <tr>
		                        <th width="50">#</th>
		                        <th>Centang SKPD TERKAIT</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <?php $no='0' ; foreach($ceklist as $row): $no++; ?>
		                    <tr>
								<td class="checkbox-column">
                                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                        <input type="checkbox" class="new-control-input todochkbox" name="f_skpd[]" id="f_skpd[]" value="<?php echo $row['ID'];?>">
                                        <span class="new-control-indicator"></span>
                                    </label>
                                </td>
		                        <td class=""><?php echo $row['NAMA_SKPD']; ?></td>
		                    </tr>
		                    <?php endforeach;?>
		                </tbody>
		            </table>
		        </div>

		        <div class="form-group row my-4">
					<label class="col-xl-3 col-sm-3 col-sm-3 col-form-label"></label>
					<div class="col-xl-9 col-lg-9 col-sm-9">
						<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_skpd_sasaran()">Simpan Data</button>
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
            url  : "<?php echo base_url()?>renstra/sasaran/simpan_sasaran_indikator",
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
							load('renstra/program/index', '#contents');       
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
							load('renstra/program/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>