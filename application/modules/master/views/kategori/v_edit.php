<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Edit Kategori</h6>
	                <div class="float-right">
	                </div>
                </div>
	        	<form id="form_kategori">
	        		<?php echo form_hidden(['f_kategori_id' => $detail['ID']]); ?>
					<div class="form-group row mb-3">
						<?php echo form_label('Kategori', 'f_kategori', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
						<div class="col-xl-6 col-lg-6 col-sm-6">
							<?php echo form_input(['name' => 'f_kategori', 'id' => 'f_kategori', 'class' => 'form-control input', 'value' => $detail['KATEGORI']]); ?>
						</div>
					</div>
					<div class="form-group row my-3">
						<label class="col-xl-2 col-sm-2 col-sm-2 col-form-label"></label>
						<div class="col-xl-10 col-lg-10 col-sm-10">
							<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_kategori()" >Simpan Data</button>
						</div>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(".select2").select2();
	feather.replace();


	function update_kategori(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>master/kategori/update",
            data: $("#form_kategori").serializeArray(),
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
							load('master/kategori/index', '#contents');
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
							// load('master/skpd/index', '#contents');          
					    }
					});
                }
            }
        });
        return false;
	}
</script>