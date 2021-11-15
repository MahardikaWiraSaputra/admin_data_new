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

							<div class="form-group row mb-2">
								<?php echo form_label('Kegiatan', 'f_kegiatan', array('class' => 'col-xl-3 col-sm-3 col-sm-3 col-form-label')); ?>
								<div class="col-xl-9 col-lg-9 col-sm-9">
									<?php echo form_textarea(['name' => 'f_kegiatan', 'id' => 'f_kegiatan', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->KEGIATAN]); ?>
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
	        		<input type="hidden" name="f_kegiatan" value="<?php echo $detail->KEGIATAN_ID;?>">
	        		<div id="indikator_items"></div>
			   	</form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    feather.replace();
    $(".select2").select2();

    get_indikator();

	function get_indikator(){
        var id = <?php echo $detail->KEGIATAN_ID;?>;
	    $.post(site+'rpjmd/rpjmd/ceklist_indikator/'+id, {
	        cari_indikator: $('#search').val(),
	    }, function(data) {
	        $("#indikator_items").html(data);
	    });
	}

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
							load('rpjmd/kegiatan/index', '#contents');       
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
							load('rpjmd/kegiatan/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>