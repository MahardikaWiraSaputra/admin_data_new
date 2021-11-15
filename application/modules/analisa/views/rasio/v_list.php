<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive ps">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th class="text-center" width="50">NO</th>
                        <th>JUDUL</th>
                        <th>INDIKATOR</th>
                        <th class="text-center" width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no='0' ; foreach($list_items as $row): $no++; ?>
                    <tr>
                        <td class="text-center"><?php echo ($limit*$page+$no)-$limit; ?></td>
                        <td class=""><?php echo $row['JUDUL']; ?></td>
                        <td>
                            <ul>
                            <?php if(isset($list_indikator[$row['ID']])) { ?>
                                    <?php $sub='0'; foreach ($list_indikator[$row['ID']] as $sub_items) : $sub++; ?>
                                    
                                        <li><?=$sub_items['INDIKATOR']?> | Sebagai Indikator <?=$sub_items['TIPE']?></li>
                                    
                                <?php endforeach;?>
                            <?php } ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <ul class="table-controls">
                                <li><a href="javascript:void(0);" onclick="edit_rasio(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="edit" class="text-primary"></i></a></li>
                                <li><a href="javascript:void(0);" onclick="delete_rasio(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>
                            </ul>
                        </td>
                    </tr>
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

    function detail_rasio(id){
        load('analisa/rasio/detail/'+id, '#contents');
    }

    function edit_rasio(id){
        load('analisa/rasio/edit/'+id, '#contents');
    }

    function delete_rasio(id) {
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
                    url  : "<?php echo base_url()?>analisa/rasio/delete/"+id,
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
                                    load('analisa/rasio/index', '#contents');
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
                                    load('analisa/rasio/index', '#contents');           
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