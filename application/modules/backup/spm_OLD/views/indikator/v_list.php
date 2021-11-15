<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <button onclick="tambah_indikator('');" class="btn btn-secondary mr-2"><span class="feather-sub"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span> Tambah Data</button>
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
                    </tr>
                </thead>
                <tbody>
                    <?php $k='0' ; foreach($item_sasaran as $key => $row): $k++; ?>
                    <tr style="background: #f2f2f2; font-weight: 500">
                        <td align="center"><?php echo $k; ?></td>
                        <td class="mailbox-subject" colspan="<?php echo 2021-2010; ?>"><?php echo $row['SASARAN']; ?></td>
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
                                    <td class="text-center">
<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Tambah Data" class="feather-sub"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
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