<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50" rowspan="2" class="text-center">NO</th>
                        <th colspan="2" rowspan="2" class="text-center">INDIKATOR / KECAMATAN</th>
                        <th rowspan="2" class="text-center">SATUAN</th>
                        <th class="text-center" colspan="<?php echo $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL + 1; ?>" >TAHUN</th>
                        <th class="text-center" width="100" rowspan="2">AKSI</th>
                    </tr>
                    <tr>
                        <?php 
                            for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                            <th class="text-center"><?php echo $i; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no='0' ; foreach($list_items as $key => $row): $no++; ?>
                    <tr>
                        <td align="center"><strong><?php echo ($limit*$page+$no)-$limit; ?></strong></td>
                        <td class="" colspan="<?php echo (4 + $this->portal->selected_periode()->TAHUN_AKHIR - $this->portal->selected_periode()->TAHUN_AWAL); ?>"><strong><?php echo $row['INDIKATOR']; ?></strong></td>
                        <td class="text-center">
                            <ul class="table-controls">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-info" onclick="edit_indikator(<?php echo $row['ID_INDIKATOR']; ?>)">Edit</button>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_indikator(<?php echo $row['ID_INDIKATOR']; ?>)">Del</button>
                                </div>
                            </ul>
                        </td>
                    </tr>
                    <?php if(isset($list_indikator[$row['ID_INDIKATOR']])) { ?>
                    <?php $sub='0'; foreach ($list_indikator[$row['ID_INDIKATOR']] as $sub_items) : $sub++; ?>
                        <tr>
                            <td align="center" rowspan=""></td>
                            <td align="center" width="50"><?php echo $sub; ?></td>
                            <td class=""><?php echo $sub_items['NAMA_KEC']; ?></td>
                            <td class=""><?php echo $sub_items['SATUAN']; ?></td>
                            <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                                <?php if (isset( $sub_items[$i])) {?>
                                    <td><?php echo $sub_items[$i];?></td>
                                <?php } else { ?>
                                    <td class="text-center"> - </td>
                                <?php } ?>
                            <?php } ?>
                            <td class="text-center">
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
        <div class="paginating-container pagination-solid">
            <div id="show_paginator" align="center"></div>
        </div>
    </div>
</div>

<?php $total_page = ( $total_items / $limit)+1; if ($total_page < 1){ $total_page='1' ; } ?>      
<script type="text/javascript">
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

    function detail_indikator(id){
        load('kewilayahan/detail/'+id, '#contents');
    }

    function edit_indikator(id){
        load('kewilayahan/edit/'+id, '#contents');
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
                    url  : "<?php echo base_url()?>kewilayahan/delete/"+id,
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
                                    load('kewilayahan/index', '#contents');
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
                                    load('kewilayahan/index', '#contents');           
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