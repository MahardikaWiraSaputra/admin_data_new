<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
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
         <?php $no='0' ; foreach($list_indikator as $row): $no++; ?>
         <tr>
            <td class="text-center"><?php echo $no; ?></td>
            <td class="mailbox-subject"><?php echo $row['INDIKATOR']; ?></td>
            <td class="mailbox-subject"><?php echo $row['SATUAN']; ?></td>
            <?php for ($i=2011; $i < 2021; $i++) { ?>
            <?php if (isset( $row[$i])) {?>
            <td><?php echo $row[$i];?></td>
            <?php } else { ?>
            <td class="text-center">
               <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Tambah Data" class="feather-sub"></a>
            </td>
            <?php } ?>
            <?php } ?>
            <td class="text-center">
               <a href="javascript:void()" onclick="remove_indikator(<?php echo $row['param_del']; ?>)"><i data-feather="trash-2"></i></a>
            </td>
         </tr>
         <?php endforeach;?>
      </tbody>
   </table>
</div>

<script type="text/javascript">
    feather.replace();
</script>