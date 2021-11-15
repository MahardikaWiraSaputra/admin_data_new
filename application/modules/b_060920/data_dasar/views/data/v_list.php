<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>

<div class="row">

    <div class="col-xl-12 col-lg-12 col-sm-12">

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

                    <?php $no='0' ; foreach($list_items as $row): $no++; ?>

                    <tr>

                        <td class="text-center"><?php echo ($limit*$page+$no)-$limit; ?></td>

                        <td class="mailbox-subject"><?php echo $row['INDIKATOR']; ?></td>

                        <td class="mailbox-subject"><?php echo $row['SATUAN']; ?></td>

                        <?php for ($i=2011; $i < 2021; $i++) { ?>

                            <?php if (isset( $row[$i])) {?>

                                <td><?php echo $row[$i];?></td>

                            <?php } else { ?>

                                <td class="text-center"> - </td>

                            <?php } ?>

                        <?php } ?>

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

    $('#show_paginator').bootpag({

        page : <?php echo $page?>,

        total: <?php echo $total_page ?>,

        maxVisible: 5

    }).on("page", function(event, num){

        var n = num;

        $(".page").html("Page " + num);

        get_items(n);

    });



    function tambah_indikator(id){

        // ajax_modal('data_dasar/indikator/tambah/'+id);

        alert('maaf saat ini belum tersedia');

    }



    function tambah_elemen(id){

        // ajax_modal('data_dasar/elemen/tambah/'+id);

        alert('maaf saat ini belum tersedia');

    }

</script>