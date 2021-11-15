<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <span class="btn btn-sm bg-olive btn-flat margin"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></span>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group pull-right">
                            <span onclick="tambah_sasaran();" class="btn btn-info btn-sm margin"><i class="glyphicon glyphicon-plus"></i>&nbsp; Tambah Data</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="50">NO</th>
                                <th>URAIAN TUJUAN / SASARAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i='0' ; foreach($list_tujuan as $key => $row): $i++; ?>
                            <tr>
                                <td align="right"></td>
                                <td class="mailbox-subject" style="background: #f2f2f2;font-weight: bold;"><?php echo $row['TUJUAN']; ?></td>
                            </tr>
                            <?php if(isset($list_items[$row['ID']])) { ?>
                            <?php $s='0'; foreach ($list_items[$row['ID']] as $sub) : $s++; ?>
                                <tr>
                                    <td align="right"><?php echo $s; ?></td>
                                    <td class="mailbox-subject"><?php echo $sub['SASARAN']; ?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php } ?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="show_paginator" align="center"></div>
                    </div>
                </div>
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