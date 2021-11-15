<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
	                <h6 class="">RENSTRA INDIKATOR PROGRAM SKPD</h6>
		            <div class="float-right"></div>
	            </div>
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
			            <div id="form_program">
							<div class="form-group row mb-2">
								<?php echo form_label('Visi Pemerintah Daerah', 'f_visi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_visi', 'id' => 'f_visi', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->VISI, 'disabled'=>'true']); ?>
								</div>
							</div>
							<div class="form-group row mb-2">
								<?php echo form_label('Misi Pemerintah Daerah', 'f_misi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_misi', 'id' => 'f_misi', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->MISI, 'disabled'=>'true']); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_tujuan', 'id' => 'f_tujuan', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->TUJUAN, 'disabled'=>'true']); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Unit Kerja SKPD', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
								<?php 
								echo form_dropdown('f_skpd', $filter_skpd, $detail->SKPD_ID, 'id="f_skpd", class="form-control select2", onchange="get_urusan()",, disabled="disabled"'); 
								?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Urusan', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_urusan', $filter_urusan, $detail->URUSAN_ID, 'id="f_urusan", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>
														
							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_sasaran', $sasaran_list, $detail->SASARAN_ID, 'id="f_sasaran", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Program', 'f_program', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
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

<div class="row mt-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
    	        <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-2">
                        <div class="row mb-3">
                            <div class="col-xl-9 col-lg-9 col-sm-9">
                            	<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_indikator()" >Simpan Data</button>
                            </div>
                            <div class="col-lg-3 text-right">
                                <div class="input-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" id="search" onkeyup="get_indikator()">
                                        <div class="input-group-append">
                                        	<input type="hidden" name="urusan_id" id="urusan_id" value="<?=$detail->URUSAN_ID;?>">
                                            <span class="input-group-text"><i data-feather="search" class="text-primary"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="content_items"></div> -->
                    </div>
                </div>
	            <form id="form_indikator">
	        		<input type="hidden" name="f_program" value="<?php echo $detail->ID;?>">
	        		<div id="indikator_items"></div>
			   	</form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    feather.replace();
    get_indikator()
    $(".select2").select2();

    function get_indikator(){
	    $.post(site+'renstra/program/ceklist_indikator', {
	        cari_indikator: $('#search').val(),
	        urusan_id: $('#urusan_id').val(),
	    }, function(data) {
	        $("#indikator_items").html(data);
	    });
	}

	function simpan_indikator(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>renstra/program/simpan_indikator",
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