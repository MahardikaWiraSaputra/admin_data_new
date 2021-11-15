<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
           <table class="table table-bordered table-hover table-condensed mb-4">
              <thead>
                 <tr>
                    <th width="50" rowspan="2">NO</th>
                    <th colspan="2" rowspan="2">URAIAN TUJUAN / INDIKATOR TUJUAN</th>
                    <th rowspan="2">SATUAN</th>
                    <th class="text-center" colspan="<?php echo $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL + 1; ?>" > Target Indikator </th>
                    <th class="text-center" colspan="<?php echo $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL + 1; ?>" > Realisasi Indikator </th>
                    <th class="text-center" width="100" rowspan="2">AKSI</th>
                 </tr>
                 <tr>
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
                 <?php $no = 0;foreach($list_items as $tujuan => $rows): $no++?>
                 <tr>
                    <td align="center"><strong><?php echo ($limit*$page+$no)-$limit; ?></strong></td>
                    <td colspan="<?php echo (10 + $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL); ?>"><strong><a href="javascript:void(0)" onclick="detail_tujuan(<?php echo $rows['ID']; ?>)"><?php echo $rows['TUJUAN']; ?></a></strong></td>
                    <td class="text-center">
                       <ul class="table-controls">
                          <div class="btn-group">
                             <button type="button" class="btn btn-xs btn-primary" onclick="tambah_indikator(<?php echo $rows['ID']; ?>)">Add</button>
                             <button type="button" class="btn btn-xs btn-info" onclick="edit_tujuan(<?php echo $rows['ID']; ?>)">Edit</button>
                             <button type="button" class="btn btn-xs btn-danger" onclick="delete_tujuan(<?php echo $rows['ID']; ?>)">Del</button>
                          </div>
                       </ul>
                    </td>
                 </tr>
                 <?php if(isset($list_indikator[$rows['ID']])) { ?>
                 <?php $sub='0'; foreach ($list_indikator[$rows['ID']] as $sub_items) : $sub++; ?>
                 <tr>
                    <td align="center"></td>
                    <td align="center" width="50"><?php echo $sub; ?></td>
                    <td class=""><?php echo $sub_items['INDIKATOR']; ?></td>
                    <td class=""><?php echo $sub_items['SATUAN']; ?></td>
                    <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                    <?php if (isset( $sub_items['target'.$i])) {?>
                    <td><?php echo $sub_items['target'.$i];?></td>
                    <?php } else { ?>
                    <td class="text-center"> - </td>
                    <?php } ?>
                    <?php } ?>
                    <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                    <?php if (isset( $sub_items[$i])) {?>
                    <td><?php echo $sub_items[$i];?></td>
                    <?php } else { ?>
                    <td class="text-center"> - </td>
                    <?php } ?>
                    <?php } ?>                            
                    <td class="text-center">
                       <ul class="table-controls">
                          <li><a href="javascript:void(0);" onclick="remove_indikator(<?php echo $sub_items['ID_INDIKATOR']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>
                       </ul>
                    </td>
                 </tr>
                 <?php endforeach;?>
                 <?php } ?>
                 <?php endforeach;?>
              </tbody>
           </table>
        </div>
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
    feather.replace();
    $(".select2").select2();

    $('#show_paginator').bootpag({
        page : <?php echo $page?>,
        total: <?php echo $total_page ?>,
        maxVisible: 5
    }).on("page", function(event, num){
        var n = num;
        $(".page").html("Page " + num);
        get_items(n);
    });

    function detail_tujuan(id){
        if (id) {
            load('rpjmd/tujuan/detail/'+id, '#contents');
        }
    }

    function edit_tujuan(id){
        if (id) {
            load('rpjmd/tujuan/edit/'+id, '#contents');
        }
    }

    function delete_tujuan(id) {
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
                    url  : "<?php echo base_url()?>rpjmd/tujuan/delete/"+id,
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
                                    load('rpjmd/tujuan/index', '#contents');
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
                                    load('rpjmd/tujuan/index', '#contents');           
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
        load('rpjmd/tujuan/indikator/'+id, '#contents');
    }

    function remove_indikator(id) {
        if (id) {
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
                        url  : "<?php echo base_url()?>rpjmd/tujuan/remove_indikator/"+id,
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
                                        load('rpjmd/tujuan/index', '#contents');
                                        // list_indikator();
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
                                        // load('rpjmd/sasaran/index', '#contents');
                                        // get_indikator();
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
    }  
</script>