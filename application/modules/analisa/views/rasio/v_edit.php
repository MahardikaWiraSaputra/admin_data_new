<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>

<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">EDIT DATA</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_indikator">
				<?php echo form_hidden(['f_id' => $detail['ID']]); ?>
					<div class="form-group row mb-2">
						<?php echo form_label('Judul Rasio', 'f_judul', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<input type="text" class="form-control input" name="judul" id="judul" placeholder = "Judul analisa overlay" value="<?=$detail['JUDUL']?>">
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('INDIKATOR Y', 'f_indikator_y', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<select class="form-control select2" name="indikator_y" id="indikator_y">
								<?php foreach($list_indikator as $data):?>
									<?php if($detail['INDIKATOR_Y'] == $data['ID']):?>
										<option value="<?=$data['ID']?>" selected><?=$data['INDIKATOR']?></option>
									<?php else:?>
										<option value="<?=$data['ID']?>"><?=$data['INDIKATOR']?></option>
									<?php endif;?>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('INDIKATOR X', 'f_indikator_x', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<select class="form-control select2" name="indikator_x" id="indikator_x">
								<?php foreach($list_indikator as $data):?>
									<?php if($detail['INDIKATOR_X'] == $data['ID']):?>
										<option value="<?=$data['ID']?>" selected><?=$data['INDIKATOR']?></option>
									<?php else:?>
										<option value="<?=$data['ID']?>"><?=$data['INDIKATOR']?></option>
									<?php endif;?>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group row mb-2">
						<?php echo form_label('Per', 'f_per', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<input type="text" class="form-control input" name="f_per" id="f_per" value="<?=$detail['Per']?>" placeholder = "Contoh : 100.000">
						</div>
					</div>
					
					<div class="form-group row my-3">
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
<script>
	$(".select2").select2();

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>analisa/rasio/update",
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
					        load('analisa/rasio', '#contents');
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
					     //    
					    }
					});
                }
            }
        });
        return false;
	}
</script>