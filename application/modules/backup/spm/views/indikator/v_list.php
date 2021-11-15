<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <button onclick="tambah_indikator();" class="btn btn-secondary mr-2"><span class="feather-sub"><i data-feather="plus"></i></span> Tambah Data</button>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50" class="text-center">NO</th>
                        <th class="text-center">SASARAN / INDIKATOR</th>
                        <?php for ($i=2011; $i < 2021; $i++) { ?>
                            <th class="text-center"><?php echo $i; ?></th>
                        <?php } ?>
                        <th width="50" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $k='0' ; foreach($item_sasaran as $key => $row): $k++; ?>
                    <tr style="background: #f2f2f2; font-weight: 500">
                        <td align="center"><?php echo $k; ?></td>
                        <td class="mailbox-subject" colspan="<?php echo 2021-2010; ?>"><?php echo $row['SASARAN']; ?></td>
                        <td></td>
                    </tr>
                    <?php if(isset($list_items[$row['ID']])) { ?>
                    <?php $s='0'; foreach ($list_items[$row['ID']] as $sub) : $s++; ?>
                        <tr>
                            <td align="center"><?php echo $k.'.'.$s; ?></td>
                            <td class="mailbox-subject"><?php echo $sub['INDIKATOR']; ?></td>
                            <?php for ($i=2011; $i < 2021; $i++) { ?>
                                <?php if (isset( $sub[$i])) {?>
                                    <td><?php echo $sub[$i];?></td>
                                <?php } else { ?>
                                    <td class="text-center"></td>
                                <?php } ?>
                            <?php } ?>
                            <td class="text-center"> <a href="javascript:void(0);" onclick="delete_indikator(<?php echo $sub['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></td> 
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

    function tambah_indikator(){
        load('spm/tambah/', '#contents');
    }

    function detail_indikator(id){
        load('spm/detail/'+id, '#contents');
    }

    function edit_indikator(id){
        load('spm/edit/'+id, '#contents');
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
                    url  : "<?php echo base_url()?>spm/delete/"+id,
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
                                    load('spm/index', '#contents');
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
                                    load('spm/index', '#contents');           
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