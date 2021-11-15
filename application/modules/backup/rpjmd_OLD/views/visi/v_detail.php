<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<h3>RPJMD Visi Pemerintah Daerah</h>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">Visi Pemerintah Daerah</h6>
	                <div class="float-right">
	                	<a href="javascript:void(0)" class="btn btn-sm btn-warning btn-sm mb-2 mr-2 rounded-circle" onclick="edit_visi(<?php echo $detail->ID ?>)"><i data-feather="edit"></i></a>
	                	<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-sm mb-2 mr-2 rounded-circle" onclick="delete_visi(<?php echo $detail->ID ?>)"><i data-feather="trash"></i></a>
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
	                            	<?php echo form_textarea(['name' => 'f_visi', 'id' => 'f_visi', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->VISI, 'disabled'=>'true']); ?>
	                            </div>
	                        </div>
			                <div class="form-group row my-4">
								<label class="col-xl-3 col-sm-3 col-sm-3 col-form-label"></label>
								<div class="col-xl-9 col-lg-9 col-sm-9">
									<div id="buttons-container"></div>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" id="misi-terkait">
        <div id="general-info" class="section general-info">
            <div class="info">
                <h6 class="">Keterkaitan dengan Misi</h6>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
						        <div class="table-responsive">
						            <table class="table table-bordered table-hover table-condensed mb-4">
						                <thead>
						                    <tr>
						                        <th width="50">NO</th>
						                        <th>URAIAN MISI</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	<?php $no = 0; foreach ($sub_detail as $key => $row): $no++?>
						                	<tr>
						                        <td class="text-center"><?php echo $no; ?></td>
						                        <td class=""><?php echo $row['MISI']; ?></td>
						                    </tr>
							                <?php endforeach; ?>
						                </tbody>
						            </table>
						        </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	feather.replace();

	function edit_visi(id){
		$('#misi-terkait').remove();
		$('#f_visi').prop("disabled", false);
		$("#buttons-container").append('<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_visi()" >Simpan </button>');
		$("#buttons-container").append('<button type="button" class="btn btn-dark my-2 mr-2" onclick="kembali()" >Kembali</button>');
	}

	function kembali(){
		load('rpjmd/visi/index', '#contents');
	}


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

	function delete_visi(id) {
		swal({
			title: 'Apakah anda yakin?',
			text: "Data tidak dapat dikembalikan lagi!",
			type: 'warning',
			showCancelButton: true,
		    confirmButtonText: 'Hapus',
		    cancelButtonText: 'Batal',
		    reverseButtons: true,
			padding: '2em'
		}).then(function(result){
        	if (result.value) {
          		$.ajax({
             		url  : "<?php echo base_url()?>rpjmd/visi/delete/"+id,
                	dataType: "JSON",
                	type: "POST",
                	success: function(response){
		                if(response.success == true) {
		                    swal({
						      title: 'Sukses',
						      text: "Data berhasil dihapus",
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
						      text: "Data tidak dapat dihapus",
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
        	} 
        	else if ( result.dismiss === swal.DismissReason.cancel ) {
          		swal({
			      title: 'Hapus dibatalkan',
			      text: "Data tidak jadi dihapus",
			      type: 'error',
			      padding: '2em',
			      showConfirmButton: false, 
			      timer: 1500
			    }).then((result) => {
				    if (result.dismiss === Swal.DismissReason.timer) {
				    }
				});
        	}
      	})
	}

</script>