<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-2">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
	                <h6 class="">RENSTRA KEGIATAN SKPD</h6>
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
                <div class="d-flex justify-content-between">
                	<h6 class="">Kegiatan SKPD</h6>
	                <div class="float-right">
	                	<a href="javascript:void(0)" class="btn btn-sm btn-warning btn-sm mb-2 mr-2 rounded-circle" onclick="edit_kegiatan(<?php echo $detail->ID ?>)"><i data-feather="edit"></i></a>
	                	<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-sm mb-2 mr-2 rounded-circle" onclick="delete_kegiatan(<?php echo $detail->ID ?>)"><i data-feather="trash"></i></a>
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_kegiatan">
							<?php echo form_hidden(['f_id' => $detail->ID]); ?>

							<div class="form-group row mb-2">
								<?php echo form_label('Unit Kerja', 'f_skpd', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
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
								<?php echo form_label('Program SKPD', 'f_program', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_program', 'id' => 'f_program', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->PROGRAM, 'disabled'=>'true']); ?>
								</div>
							</div>
							<div class="form-group row mb-2">
								<?php echo form_label('Kegiatan', 'f_kegiatan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_kegiatan', 'id' => 'f_kegiatan', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->KEGIATAN, 'disabled'=>'true']); ?>
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

    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" id="indikator-terkait">
        <div id="general-info" class="section general-info">
            <div class="info">
            	<div class="d-flex justify-content-between">
                	<h6 class="">Indikator Kinerja Kegiatan</h6>
                	<div class="float-right">
                		<button class="btn btn-primary mb-2 mr-2" onclick="tambah_indikator(<?php echo $detail->ID ?>)"><i data-feather="plus-circle"></i> Tambah Indikator</button>
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
						        <div class="table-responsive">
						            <table class="table table-bordered table-hover table-condensed mb-4">
						                <thead>
						                    <tr>
						                        <th width="50">NO</th>
						                        <th>INDIKATOR</th>
						                        <th>SATUAN</th>
						                        <?php for ($i=2011; $i < 2021; $i++) { ?>
						                            <th><?php echo $i; ?></th>
						                        <?php } ?>
						                    </tr>
						                </thead>
						                <tbody>
						                    <?php $no='0' ; foreach($sub_detail as $row): $no++; ?>
						                    <tr>
						                        <td class="text-center"><?php echo $no; ?></td>
						                        <td class="mailbox-subject"><?php echo $row['INDIKATOR']; ?></td>
						                        <td class="mailbox-subject"><?php echo $row['SATUAN']; ?></td>
						                        <?php for ($i=2011; $i < 2021; $i++) { ?>
						                            <?php if (isset( $row[$i])) {?>
						                                <td><?php echo $row[$i];?></td>
						                            <?php } else { ?>
						                                <td class="text-center">
						                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Tambah Data" class="feather-sub"></a>
						                                    
						                                </td>
						                            <?php } ?>
						                        <?php } ?>
						                    </tr>
						                    <?php endforeach;?>
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

	function edit_kegiatan(id){
		$('#indikator-terkait').remove();
		$('#f_kegiatan').prop("disabled", false);
		$("#buttons-container").append('<button type="button" class="btn btn-primary my-2 mr-2" onclick="update_kegiatan()" >Simpan </button>');
		$("#buttons-container").append('<button type="button" class="btn btn-dark my-2 mr-2" onclick="kembali()" >Kembali</button>');
	}

	function kembali(){
		load('renstra/kegiatan/index', '#contents');
	}

	function get_urusan(){
		var skpdID = $('select[id="f_skpd"]').val();
		$("#frmurusan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('form_dropdown/dropdown/get_urusan/'+skpdID, '#frmurusan');
	}


	function update_kegiatan(){
		var f_id = $('[name="f_id"]').val()
        $.ajax({
            type: "POST",
            url  : "<?php echo base_url()?>renstra/kegiatan/update",
            data: $("#form_kegiatan").serializeArray(),
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
							load('renstra/kegiatan/detail/'+f_id, '#contents');
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
							load('renstra/kegiatan/detail/'+f_id, '#contents');           
					    }
					});
                }
            }
        });
        return false;
	}

	function delete_kegiatan(id) {
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
             		url  : "<?php echo base_url()?>renstra/kegiatan/delete/"+id,
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
									load('renstra/kegiatan/index', '#contents');
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
									load('renstra/kegiatan/index', '#contents');           
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

	function tambah_indikator(id){
        load('renstra/tambah/'+id, '#contents');
    }

</script>