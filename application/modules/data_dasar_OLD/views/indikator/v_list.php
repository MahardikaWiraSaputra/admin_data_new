<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <button onclick="tambah_indikator();" class="btn btn-secondary mr-2"><span class="feather-sub"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span> Tambah Data</button>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>INDIKATOR</th>
                        <th>KATEGORI</th>
                        <th>RPJMD</th>
                        <th>SDGS</th>
                        <th>SPM</th>
                        <th>RENSTRA</th>
                        <!-- <th>KLHS</th> -->
                        <th>SKPD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no='0' ; foreach($list_items as $row): $no++; ?>
                    <tr>
                        <td class="text-center"><?php echo $no; ?></td>
                        <td class=""><a href="javascript:void(0)" onclick="detail_indikator(<?php echo $row['ID'];?>);"><?php echo $row['INDIKATOR']; ?></a></td>
                        <td class=""><?php echo $row['TIPE_DATA']; ?></td>
                        <td class="text-center"><?php if ($row['RPJMD'] == 1) { echo '<span class="feather-sub text-success"><i data-feather="check-circle"></i></span>'; } else { echo '<span class="feather-sub text-warning"><i data-feather="x-circle"></i></span>'; } ; ?></td>
                         <td class="text-center"><?php if ($row['SDGS'] == 1) { echo '<span class="feather-sub text-success"><i data-feather="check-circle"></i></span>'; } else { echo '<span class="feather-sub text-warning"><i data-feather="x-circle"></i></span>'; } ; ?></td>
                         <td class="text-center"><?php if ($row['SPM'] == 1) { echo '<span class="feather-sub text-success"><i data-feather="check-circle"></i></span>'; } else { echo '<span class="feather-sub text-warning"><i data-feather="x-circle"></i></span>'; } ; ?></td>
                         <td class="text-center"><?php if ($row['RENSTRA'] == 1) { echo '<span class="feather-sub text-success"><i data-feather="check-circle"></i></span>'; } else { echo '<span class="feather-sub text-warning"><i data-feather="x-circle"></i></span>'; } ; ?></td>
                         <!-- <td class="text-center"><?php if ($row['KLHS'] == 1) { echo '<span class="feather-sub text-success"><i data-feather="check-circle"></i></span>'; } else { echo '<span class="feather-sub text-warning"><i data-feather="x-circle"></i></span>'; } ; ?></td> -->
                        <td class=""><?php echo $row['NAMA_SKPD']; ?></td>
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
        // ajax_modal('data_dasar/indikator/tambah/');
        load('data_dasar/indikator/tambah/', '#contents');
    }

    function detail_indikator(id){
        load('data_dasar/indikator/detail/'+id, '#contents');
    }
</script>