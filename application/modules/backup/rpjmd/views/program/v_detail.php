<?php if ( ! defined( 'BASEPATH')) exit( 'No direct script access allowed');?>
<div class="row mt-4">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <div class="section general-info">
            <div class="info">
                <div class="d-flex justify-content-between">
                	<h6 class="">RPJMD Program</h6>
	                <div class="float-right">
	                </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                    	<form id="form_program">
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
								<?php echo form_label('Tujuan Pemerintah Daerah', 'f_tujuan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_tujuan', 'id' => 'f_tujuan', 'class' => 'form-control', 'rows' =>'2', 'value' => $detail->TUJUAN, 'disabled'=>'true']); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Urusan Pemerintah Daerah', 'f_urusan', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_urusan', $urusan_list, $detail->URUSAN_ID, 'id="f_urusan", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>
														
							<div class="form-group row mb-2">
								<?php echo form_label('Sasaran Pemerintah Daerah', 'f_sasaran', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_dropdown('f_sasaran', $sasaran_list, $detail->SASARAN_ID, 'id="f_sasaran", class="form-control select2", , disabled="disabled"'); ?>
								</div>
							</div>

							<div class="form-group row mb-2">
								<?php echo form_label('Program Pemerintah Daerah', 'f_program', array('class' => 'col-xl-2 col-sm-2 col-sm-2 col-form-label')); ?>
								<div class="col-xl-10 col-lg-10 col-sm-10">
									<?php echo form_textarea(['name' => 'f_program', 'id' => 'f_program', 'class' => 'form-control', 'rows' =>'3', 'value' => $detail->PROGRAM, 'disabled'=>'true']); ?>
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
                	<h6 class="">Keterkaitan Dengan Capaian Indikator Pemda</h6>
                	<div class="float-right">
                		<a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-sm mb-2 mr-2 rounded-circle" onclick="tambah_indikator(<?php echo $detail->ID ?>)"><i data-feather="plus"></i></a>
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

	function kembali(){
		load('rpjmd/program/index', '#contents');
	}

	function tambah_indikator(id){
        load('rpjmd/tambah/'+id, '#contents');
    }

</script>