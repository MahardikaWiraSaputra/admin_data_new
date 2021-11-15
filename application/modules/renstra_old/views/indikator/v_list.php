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
                            <span onclick="tambah_indikator();" class="btn btn-info btn-sm margin"><i class="glyphicon glyphicon-plus"></i>&nbsp; Tambah Data</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">NO</th>
                                <th class="text-center">PROGRAM / INDIKATOR</th>
                                <?php for ($i=2011; $i < 2021; $i++) { ?>
                                    <th class="text-center"><?php echo $i; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k='0' ; foreach($item_program as $key => $row): $k++; ?>
                            <tr style="background: #f2f2f2; font-weight: 500">
                                <td align="center"><?php echo $k; ?></td>
                                <td class="mailbox-subject" colspan="<?php echo 2021-2010; ?>"><?php echo $row['PROGRAM']; ?></td>
                            </tr>
                            <?php if(isset($list_items[$row['ID_PROGRAM']])) { ?>
                            <?php $s='0'; foreach ($list_items[$row['ID_PROGRAM']] as $sub) : $s++; ?>
                                <tr>
                                    <td align="center"><?php echo $k.'.'.$s; ?></td>
                                    <td class="mailbox-subject"><?php echo $sub['INDIKATOR']; ?></td>
                                    <?php for ($i=2011; $i < 2021; $i++) { ?>
                                        <?php if (isset( $sub[$i])) {?>
                                            <td><?php echo $sub[$i];?></td>
                                        <?php } else { ?>
                                            <td class="text-center">
                                                <a id="tambah_val" href="javascript:void(0)" onclick="tambah_value()" class="btn btn-xs"><i class=" fa fa-plus-square-o"></i></a>
                                            </td>
                                        <?php } ?>
                                        
                                    <?php } ?>
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

    function tambah_indikator(){
        // ajax_modal('data_dasar/indikator/tambah/'+id);
        alert('maaf saat ini belum tersedia');
    }

    function tambah_elemen(){
        // ajax_modal('data_dasar/elemen/tambah/'+id);
        alert('maaf saat ini belum tersedia');
    }
</script>