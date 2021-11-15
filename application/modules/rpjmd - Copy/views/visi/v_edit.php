<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">EDIT RPJMD VISI</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_visi">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>
	                        <div class="form-group row">
	                            <div class="col-xl-2 col-lg-2 col-md-2 mt-md-0 mt-4">
	                            	<p style="font-weight: 500">Uraian Visi Pemda</p>
	                            </div>
	                            <div class="col-xl-10 col-lg-10 col-md-10 mt-md-0 mt-4">
	                            	<?php echo form_textarea(['name' => 'f_visi', 'id' => 'f_visi', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->VISI]); ?>
	                            </div>
	                        </div>
							<div class="form-group row my-3">
								<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_visi()" >Simpan Data</button>
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

	function update_visi(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/visi/update",
            data: $("#form_visi").serializeArray(),
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
							load('rpjmd/visi/index', '#contents');
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
							load('rpjmd/visi/index', '#contents');           
					    }
					});
                }
            }
        });
        return false;
	}

</script>