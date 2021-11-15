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

                        <th class="text-center" width="50">NO</th>

                        <th>INDIKATOR</th>

                        <th width="200">Unit SKPD</th>

                        <th>KATEGORI</th>

                        <th class="text-center">RPJMD</th>

                        <th class="text-center">SDGS</th>

                        <th class="text-center">SPM</th>

                        <th class="text-center">RENSTRA</th>

                        <th class="text-center" width="100">AKSI</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no='0' ; foreach($list_items as $row): $no++; ?>

                    <tr>

                        <td class="text-center"><?php echo $no; ?></td>

                        <!-- <td class=""><a href="javascript:void(0)" onclick="detail_indikator(<?php echo $row['ID'];?>);"><?php echo $row['INDIKATOR']; ?></a></td> -->

                        <td class=""><?php echo $row['INDIKATOR']; ?></td>

                        <td class=""><?php echo $row['NAMA_SKPD']; ?></td>

                        <td class=""><?php echo $row['TIPE_DATA']; ?></td>

                        <td class="text-center">

                            <?php if ($row['RPJMD'] == 1) { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'rpjmd', '0')"><span class="feather-sub text-success"><i data-feather="check-circle"></i></span></a>

                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'rpjmd', '1')"><span class="feather-sub text-warning"><i data-feather="x-circle"></i></span></a>

                            <?php } ?>

                        </td>

                        <td class="text-center">

                            <?php if ($row['SDGS'] == 1) { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'sdgs', '0')"><span class="feather-sub text-success"><i data-feather="check-circle"></i></span></a>

                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'sdgs', '1')"><span class="feather-sub text-warning"><i data-feather="x-circle"></i></span></a>

                            <?php } ?>

                        </td>

                         <td class="text-center">

                            <?php if ($row['SPM'] == 1) { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'spm', '0')"><span class="feather-sub text-success"><i data-feather="check-circle"></i></span></a>

                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'spm', '1')"><span class="feather-sub text-warning"><i data-feather="x-circle"></i></span></a>

                            <?php } ?>

                        </td>

                        <td class="text-center">

                            <?php if ($row['RENSTRA'] == 1) { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'renstra', '0')"><span class="feather-sub text-success"><i data-feather="check-circle"></i></span></a>

                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="update_status(<?php echo $row['ID'];?>, 'renstra', '1')"><span class="feather-sub text-warning"><i data-feather="x-circle"></i></span></a>

                            <?php } ?>

                        </td>

                        

                        <td class="text-center">

                            <ul class="table-controls">

                                <li><a href="javascript:void(0);" onclick="edit_indikator(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="edit" class="text-primary"></i></a></li>

                                <li><a href="javascript:void(0);" onclick="delete_indikator(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>

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

        load('data_dasar/indikator/tambah/', '#contents');

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
            confirmButtonText: 'Hapus',
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

</script>