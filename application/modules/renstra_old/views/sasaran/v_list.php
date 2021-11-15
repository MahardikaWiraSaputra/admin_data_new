<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <!-- <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button> -->
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <!-- <button onclick="tambah_sasaran();" class="btn btn-secondary mr-2"><span class="feather-sub"><i data-feather="plus"></i></span> Tambah Data</button> -->
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>URAIAN TUJUAN / SASARAN</th>
                        <th class="text-center" width="100">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i='0' ; foreach($list_tujuan as $key => $row): $i++; ?>
                    <tr>
                        <td align="right"></td>
                        <td class="" style="background: #f2f2f2;font-weight: bold;" colspan="2"><?php echo $row['TUJUAN']; ?></td>
                    </tr>
                    <?php if(isset($list_items[$row['ID']])) { ?>
                    <?php $s='0'; foreach ($list_items[$row['ID']] as $sub) : $s++; ?>
                        <tr>
                            <td align="right"><?php echo $s; ?></td>
                            <td class=""><a href="javascript:void(0)" onclick="detail_sasaran(<?php echo $sub['ID']; ?>)"><?php echo $sub['SASARAN']; ?></td>
                            <td class="text-center">
                                <ul class="table-controls">
                                    <li><a href="javascript:void(0);" onclick="edit_sasaran(<?php echo $sub['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="edit" class="text-primary"></i></a></li>
                                    <li><a href="javascript:void(0);" onclick="delete_sasaran(<?php echo $sub['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>
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

    function tambah_sasaran(){
        load('renstra/sasaran/tambah/', '#contents');
    }

    function detail_sasaran(id){
        if (id) {
            load('renstra/sasaran/detail/'+id, '#contents');
        }
    }

    function edit_sasaran(id){
        if (id) {
            load('renstra/sasaran/edit/'+id, '#contents');
        }
    }

    function delete_sasaran(id) {
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
                        url  : "<?php echo base_url()?>renstra/sasaran/delete/"+id,
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
                                        load('renstra/sasaran/index', '#contents');
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
                                        load('renstra/sasaran/index', '#contents');           
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