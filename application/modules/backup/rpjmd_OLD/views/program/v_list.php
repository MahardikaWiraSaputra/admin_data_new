<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
    </div>
    <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <button onclick="tambah_program();" class="btn btn-secondary mr-2"><span class="feather-sub"><i data-feather="plus"></i></span> Tambah Data</button>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>NAMA PROGRAM</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i='0' ; foreach($list_items as $key => $row): $i++; ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class=""><a href="javascript:void(0)" onclick="detail_program(<?php echo $row['ID']; ?>)"><?php echo $row['PROGRAM']; ?></td>
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

    function tambah_program(){
        load('rpjmd/program/tambah/', '#contents');
    }

    function detail_program(id){
        if (id) {
            load('rpjmd/program/detail/'+id, '#contents');
        }
    }
</script>