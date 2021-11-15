<div class="form-group row my-4">
   <label class="col-xl-2 col-sm-2 col-sm-2 col-form-label">Capaian Indikator</label>
   <div class="col-xl-10 col-lg-10 col-sm-10">
      <div class="row mb-1 my-1">
         <div class="table-responsive mailbox-messages">
            <table class="table table-bordered table-condensed mb-4">
               <thead>
                  <tr>
                     <th class="text-center" width="50">NO</th>
                     <th class="text-center"> NAMA Desa</th>
                     <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                     <th class="text-center"><?php echo $i; ?></th>
                     <?php } ?>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = 0; foreach ($filter_desa as $key => $rows): $no++?>
                  <tr>
                     <td class="text-center"><?php echo $no; ?></td>
                     <td><?php echo $rows['NAMA_DESA']; ?></td>
                     <?php for ($i=$this->portal->selected_periode()->TAHUN_AWAL; $i <= $this->portal->selected_periode()->TAHUN_AKHIR; $i++) { ?>
                     <input type="hidden" class="form-control" name="f_desa[]" id="f_desa" value="<?php echo $rows['NAMA_DESA']; ?>">
                     <input type="hidden" class="form-control" name="f_tahun[]" id="f_tahun" value="<?php echo $i; ?>">
                     <td><input type="text" class="form-control" name="f_capaian_desa[]" id="f_capaian_desa" ></td>
                     <?php } ?>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $(".select2").select2();
	});
</script>