<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="table-responsive table-fixed">
    <table class="table table-bordered table-hover table-condensed mb-4">
        <thead>
            <tr>
                <th width="50">#</th>
                <th>INDIKATOR</th>
            </tr>
        </thead>
        <tbody>
            <?php $no='0' ; foreach($list_items as $row): $no++; ?>
            <tr>
                <td class="checkbox-column">
                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                        <input type="checkbox" class="new-control-input todochkbox" name="f_indikator[]" id="f_indikator_<?php echo $row['ID_INDIKATOR'];?>" value="<?php echo $row['ID_INDIKATOR'];?>">
                        <span class="new-control-indicator"></span>
                    </label>
                </td>
                <td class=""><?php echo $row['INDIKATOR']; ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    feather.replace();
</script>