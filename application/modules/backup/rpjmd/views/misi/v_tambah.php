<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-4 mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
            	<h6>Input RPJMD Misi</h6>
                <div class="row">
                	<div class="col-lg-12 mx-auto">
			            <form id="form_misi">
							<div class="form-group row mb-2">
								<?php echo form_label('Visi Pemerintah Daerah', 'f_visi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_visi', $visi_list, '', 'id="f_visi", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Misi Pemerintah Daerah', 'f_misi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_misi', 'id' => 'f_misi', 'class' => 'form-control', 'rows' =>'3', 'placeholder' => 'Misi Pemerintah Daerah']); ?>
								</div>
							</div>
							
							<div class="form-group row my-4">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="simpan_misi()" >Simpan Data</button>
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
    feather.replace();
    $(".select2").select2();

	function simpan_misi(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/misi/simpan",
            data: $("#form_misi").serializeArray(),
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
							load('rpjmd/misi/index', '#contents');       
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
							load('rpjmd/misi/index', '#contents');
					    }
					});
                }
            }
        });
        return false;
	}
</script>