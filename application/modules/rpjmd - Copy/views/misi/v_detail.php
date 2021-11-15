<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-3 mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">RPJMD Misi</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_misi">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>
							<div class="form-group row mb-2">
								<?php echo form_label('Visi Pemerintah Daerah', 'f_visi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_visi', $visi_list, $detail->VISI_ID, 'id="f_visi", class="form-control select2"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Misi Pemerintah Daerah', 'f_misi', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_misi', 'id' => 'f_misi', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->MISI]); ?>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 mt-3" id="tujuan-terkait">
        <div id="general-info" class="section general-info">
            <div class="info">
                <h6 class="">Tujuan Visi Pemda</h6>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
						        <div class="table-responsive">
						            <table class="table table-bordered table-hover table-condensed mb-4">
						                <thead>
						                    <tr>
						                        <th width="50">NO</th>
						                        <th>URAIAN TUJUAN</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	<?php $no = 0; foreach ($sub_detail as $key => $row): $no++?>
						                	<tr>
						                        <td class="text-center"><?php echo $no; ?></td>
						                        <td class=""><?php echo $row['TUJUAN']; ?></td>
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
	$(".select2").select2();
	
	function edit_misi(id){
		$('#tujuan-terkait').remove();
		$('#f_visi').prop("disabled", false);
		$('#f_misi').prop("disabled", false);
		$("#buttons-container").append('<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_misi()" >Simpan </button>');
		$("#buttons-container").append('<button type="button" class="btn btn-dark my-2 mr-2" onclick="kembali()" >Kembali</button>');
	}

	function kembali(){
		load('rpjmd/misi/index', '#contents');
	}

	function update_misi(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/misi/update",
            data: $("#form_misi").serializeArray(),
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

	function delete_misi(id) {
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
             		url  : "<?php echo base_url()?>rpjmd/misi/delete/"+id,
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
									load('rpjmd/misi/index', '#contents');
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
									load('rpjmd/misi/index', '#contents');           
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