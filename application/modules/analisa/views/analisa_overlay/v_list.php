<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="table-responsive ps">
            <table class="table table-bordered table-hover table-condensed mb-4">
                <thead>
                    <tr>
                        <th class="text-center" width="50">NO</th>
                        <th>JUDUL</th>
                        <th>INDIKATOR</th>
                        <th class="text-center" width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no='0' ; foreach($list_items as $row): $no++; ?>
                    <tr>
                        <td class="text-center"><?php echo ($limit*$page+$no)-$limit; ?></td>
                        <td class=""><?php echo $row['JUDUL']; ?></td>
                        <td>
                            <ul>
                            <?php if(isset($list_indikator[$row['ID']])) { ?>
                                    <?php $sub='0'; foreach ($list_indikator[$row['ID']] as $sub_items) : $sub++; ?>
                                    
                                        <li><?=$sub_items['INDIKATOR']?> | Sebagai Indikator <?=$sub_items['TIPE']?></li>
                                    
                                <?php endforeach;?>
                            <?php } ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <ul class="table-controls">
                                <li><a onclick="modal(<?php echo $row['ID']; ?>)" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Edit"><i data-feather="bar-chart" class="text-primary"></i><span class="badge badge-primary">Detail</span></a></li>
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
        <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-info"><span class="btn-label"></span> <b>JUMLAH DATA <?php echo $total_items; ?> </b></button>
            <div class="paginating-container pagination-default">
                <div id="show_paginator" align="center"></div>
            </div>
        </div>
        
    </div>
</div>

<?php $total_page = ( $total_items / $limit)+1; if ($total_page < 1){ $total_page='1' ; } ?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" style="max-width: 1400px!important;">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Analisa Angka Partisipasi Kasar Paud Formal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="place_here"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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

    function modal(id){
        $('#exampleModal').modal('show');
        load('analisa/analisa_overlay/modal/'+id,'#place_here');
    }
</script>

