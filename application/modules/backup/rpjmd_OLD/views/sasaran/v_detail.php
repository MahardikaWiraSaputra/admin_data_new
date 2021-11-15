<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<h3>RPJMD Sasaran Pemerintah Daerah</h>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">Sasaran Pemerintah Daerah</h6>
	                <div class="float-right">
	                	<a href="javascript:void(0)" class="btn btn-sm btn-warning btn-sm mb-2 mr-2 rounded-circle" onclick="edit_sasaran(<?php echo $detail->ID ?>)"><i data-feather="edit"></i></a>
	                	<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-sm mb-2 mr-2 rounded-circle" onclick="delete_sasaran(<?php echo $detail->ID ?>)"><i data-feather="trash"></i></a>
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_sasaran">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>
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
								<?php echo form_label('Urusan Pemerintah Daerah', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_urusan', $urusan_list, $detail->URUSAN_ID, 'id="f_urusan", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Tujuan Pemerintah Daerah', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_tujuan', $tujuan_list, $detail->TUJUAN_ID, 'id="f_tujuan", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran Pemerintah Daerah', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
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

    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" id="sasaran-terkait">
        <div id="general-info" class="section general-info">
            <div class="info">
                <h6 class="">Keterkaitan Dengan Program Pemda</h6>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
						        <div class="table-responsive">
						            <table class="table table-bordered table-hover table-condensed mb-4">
						                <thead>
						                    <tr>
						                        <th width="50">NO</th>
						                        <th>URAIAN SASARAN</th>
						                    </tr>
						                </thead>
						                <tbody>
						                	<?php $no = 0; foreach ($sub_detail as $key => $row): $no++?>
						                	<tr>
						                        <td class="text-center"><?php echo $no; ?></td>
						                        <td class=""><?php echo $row['PROGRAM']; ?></td>
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

	function edit_sasaran(id){
		$('#sasaran-terkait').remove();
		$('#f_urusan').prop("disabled", false);
		$('#f_tujuan').prop("disabled", false);
		$('#f_sasaran').prop("disabled", false);
		$("#buttons-container").append('<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_sasaran()" >Simpan </button>');
		$("#buttons-container").append('<button type="button" class="btn btn-dark my-2 mr-2" onclick="kembali()" >Kembali</button>');
	}

	function kembali(){
		load('rpjmd/sasaran/index', '#contents');
	}


	function update_sasaran(){
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>rpjmd/sasaran/update",
            data: $("#form_sasaran").serializeArray(),
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
							load('rpjmd/sasaran/index', '#contents');
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
							load('rpjmd/sasaran/index', '#contents');           
					    }
					});
                }
            }
        });
        return false;
	}

	function delete_sasaran(id) {
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
             		url  : "<?php echo base_url()?>rpjmd/sasaran/delete/"+id,
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
									load('rpjmd/sasaran/index', '#contents');
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
									load('rpjmd/sasaran/index', '#contents');           
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