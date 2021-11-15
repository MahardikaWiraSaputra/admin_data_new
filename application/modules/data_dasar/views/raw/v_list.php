<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div id="table-scroll" class="table-scroll mb-4">
            <div class="table-responsive">
                <!-- <div class="table-responsive"> -->
                    <!-- <table id="main-table" class="table table-bordered table-hover table-condensed mb-4"> -->
                        <table id="main-table" class="table table-bordered table-hover table-condensed mb-4">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center fixed-side" width="50">NO</th>
                                <th rowspan="2" class="fixed-side cell">INDIKATOR</th>
                                <th rowspan="2" class="text-center fixed-side">Unit SKPD</th>
                                <th rowspan="2">KATEGORI</th>
                                <th rowspan="2">SATUAN</th>
                                <th class="text-center" colspan="8">Flagging Data</th>
                                <th class="text-center" colspan="<?php echo $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL + 1; ?>" >TARGET INDIKATOR</th>
                                <th class="text-center" colspan="<?php echo $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL + 1; ?>" >REALISASI INDIKATOR</th>
                                <th class="text-center" width="100">AKSI</th>
                            </tr>
                            <tr>
                                <th class="text-center">RPJMD</th>
                                <th class="text-center">SDGS</th>
                                <th class="text-center">SPM</th>
                                <th class="text-center">RENSTRA</th>
                                <th class="text-center">LKJIP</th>
                                <th class="text-center">LKPJ</th>
                                <th class="text-center">LPPD</th>
                                <th class="text-center">TIDAK TERISI</th>
                                 <?php 
                                    for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                                 <th><?php echo $i; ?></th>
                                 <?php } ?>
                                 <?php 
                                    for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                                 <th><?php echo $i; ?></th>
                                 <?php } ?>
                            </tr>
                           
                        </thead>
                        <tbody>
                            <?php $no='0' ; foreach($list_items as $row): $no++; ?>
                            <tr>
                                <td class="text-center fixed-side"><?php echo ($limit*$page+$no)-$limit; ?></td>
                                <!-- <td class=""><a href="javascript:void(0)" onclick="detail_indikator(<?php echo $row['ID'];?>);"><?php echo $row['INDIKATOR']; ?></a></td> -->
                                <td class="fixed-side cell"><?php echo $row['INDIKATOR']; ?></td>
                                <td class="fixed-side"><?php echo $row['NAMA_SKPD']; ?></td>
                                <td class=""><?php echo $row['KATEGORI']; ?></td>
                                <td class=""><?php echo $row['SATUAN']; ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['RPJMD'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['SDGS'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['SPM'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['RENSTRA'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['LKJIP'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['LKPJ'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['LPPD'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                <td class="text-center" style="font-weight: bold"><?php if ($row['TIDAK_TERISI'] == 1){ echo 'Ya'; } else { echo 'TIDAK'; } ?></td>
                                
                                <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                                 <?php if (isset( $row['target'.$i])) {?>
                                 <td><?php echo $row['target'.$i];?></td>
                                 <?php } else { ?>
                                 <td class="text-center"> - </td>
                                 <?php } ?>
                                 <?php } ?>
                                <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                                 <?php if (isset( $row[$i])) {?>
                                 <td><?php echo $row[$i];?></td>
                                 <?php } else { ?>
                                 <td class="text-center"> - </td>
                                 <?php } ?>
                                 <?php } ?>
                                 <td class="text-center">
                                    <ul class="table-controls">
                                        <li><a href="javascript:void(0);" onclick="edit_indikator(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="edit" class="text-primary"></i></a></li>
                                        <li><a href="javascript:void(0);" onclick="update_flagging(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Ubah Flagging Data"><i data-feather="flag" class="text-primary"></i></a></li>
                                        <li><a href="javascript:void(0);" onclick="delete_indikator(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- </div> -->
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
            <div class="paginating-container pagination-default">
                <div id="show_paginator" align="center"></div>
            </div>
        </div>
    </div>
</div>

<?php $total_page = ( $total_items / $limit)+1; if ($total_page < 1){ $total_page='1' ; } ?>

<script type="text/javascript">

    // jQuery(document).ready(function() {
    //     jQuery("#main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
    // });

    $(".select2").select2();
    feather.replace();

    $('#show_paginator').bootpag({
        page : <?php echo $page?>,
        total: <?php echo $total_page ?>,
        maxVisible: 5
    }).on("page", function(event, num){
        var n = num;
        $(".page").html("Page " + num);
        get_items(n);
    });

    function update_flagging(id){
        ajax_modal_flagging('data_dasar/indikator/update_flagging/'+id);
    }

    function detail_indikator(id){
        load('data_dasar/indikator/detail/'+id, '#contents');
    }

    function edit_indikator(id){
        load('data_dasar/indikator/edit/'+id, '#contents');
    }

    function delete_indikator(id) {
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
                    url  : "<?php echo base_url()?>data_dasar/indikator/delete/"+id,
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
                                    load('data_dasar/indikator/index', '#contents');
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
                                    load('data_dasar/indikator/index', '#contents');           
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

    function update_status(id, tipe, value) {
        swal({
            title: 'Apakah anda yakin?',
            text: "merubah kodefikasi indikator",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            padding: '2em'
        }).then(function(result){
            if (result.value) {
                $.ajax({
                    url  : "<?php echo base_url()?>data_dasar/indikator/update_status/"+id+'/'+tipe+'/'+value,
                    dataType: "JSON",
                    type: "POST",
                    success: function(response){
                        if(response.success == true) {
                            swal({
                              title: 'Sukses',
                              text: "Data berhasil diupdate",
                              type: 'success',
                              padding: '2em',
                              showConfirmButton: false, 
                              timer: 1500
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    load('data_dasar/indikator/index', '#contents');
                                }
                            });
                        }
                        else {
                            swal({
                              title: 'Gagal',
                              text: "Data tidak dapat diupdate",
                              type: 'error',
                              padding: '2em',
                              showConfirmButton: false, 
                              timer: 1500
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    load('data_dasar/indikator/index', '#contents');
                                }
                            });
                        }
                    }
                });
            } 
            else if ( result.dismiss === swal.DismissReason.cancel ) {
                swal({
                  title: 'Update dibatalkan',
                  text: "Data tidak jadi diupdate",
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