<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row mb-4">
    <div class="col-lg-6">
        <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
    </div>
    <!-- <div class="col-xl-6 col-lg-6 col-sm-6 text-right">
        <button onclick="tambah_misi();" class="btn btn-secondary mr-2"><span class="feather-sub"><i data-feather="plus"></i></span> Tambah Data</button>
    </div> -->
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>URAIAN MISI</th>
                        <!-- <th class="text-center" width="100">AKSI</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $i='0' ; foreach($list_items as $key => $row): $i++; ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class=""><a href="javascript:void(0)" onclick="detail_misi(<?php echo $row['ID']; ?>)"><?php echo $row['MISI']; ?></td>
                        <!-- <td class="text-center">
                            <ul class="table-controls">
                                <li><a href="javascript:void(0);" onclick="edit_misi(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="edit" class="text-primary"></i></a></li>
                                <li><a href="javascript:void(0);" onclick="hapus_misi(<?php echo $row['ID']; ?>)" data-toggle="tooltip" data-placement="top" title="Delete"><i data-feather="trash" class="text-danger"></i></a></li>
                            </ul>
                        </td> -->
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

    function tambah_misi(){
        load('renstra/misi/tambah/', '#contents');
       
    }

    function detail_misi(id){
        if (id) {
            load('renstra/misi/detail/'+id, '#contents');
        }
    }

</script>