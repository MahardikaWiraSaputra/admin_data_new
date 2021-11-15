<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed');?>
<div class="container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-sm-6">
            <h3>Data Indikator</h3>
            <!-- <ol class="breadcrumb">
               <li class="breadcrumb-item">
                 <a href="index.html">Home</a>
               </li>
               <li class="breadcrumb-item">Others </li>
               <li class="breadcrumb-item">Search Pages</li>
               <li class="breadcrumb-item active">Search Website</li>
               </ol> -->
         </div>
         <div class="col-sm-6">
            <!-- Bookmark Start-->
            <div class="bookmark">
               <ul>
                  <li>
                     <button onclick="tambah_indikator()" class="btn btn-primary" href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables">
                        Tambah Data
                        <!-- <i data-feather="plus-circle"></i> -->
                     </button>
                  </li>
               </ul>
            </div>
            <!-- Bookmark Ends-->
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-sm-12">
      <div class="card">
         <div class="card-body">
            <form>
               <div class="row">
                  <div class="col-sm-5">
                     <div class="form-group row mb-2">
                        <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">SKPD</label>
                        <div class="col-xl-9 col-lg-9 col-sm-9">
                           <div id="skpd"> <?php echo form_dropdown('skpd', $filter_skpd, 'all', 'id="skpd", class="form-control select2", style="width:100%", onchange="get_urusan(), get_items()"'); ?> </div>
                        </div>
                     </div>
                     <div class="form-group row mb-2">
                        <label for="urusan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Urusan</label>
                        <div class="col-xl-9 col-lg-9 col-sm-9">
                           <div id="bidang_urusan"> <?php echo form_dropdown('urusan', '', '', 'id="urusan", class="form-control select2", style="width:100%", onchange="get_items()"'); ?> </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-2"></div>
                  <div class="col-sm-5">
                     <div class="form-group row mb-2">
                        <label for="kategori" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Kategori</label>
                        <div class="col-xl-9 col-lg-9 col-sm-9"> <?php echo form_dropdown('kategori', $this->portal->filter_kategori(), '', 'id="kategori", class="form-control select2", style="width:100%", onchange="get_items()"'); ?> </div>
                     </div>
                     <div class="form-group row mb-2">
                        <label for="pelaporan" class="col-xl-3 col-sm-3 col-sm-3 col-form-label">Jenis Laporan</label>
                        <div class="col-xl-9 col-lg-9 col-sm-9"> <?php echo form_dropdown('pelaporan', array('all'=>'Semua Pelaporan','RPJMD'=>'RPJMD','RENSTRA'=>'RENSTRA','SDGS'=>'SDGS','SPM'=>'SPM','LKJIP'=>'LKJIP','LKPJ'=>'LKPJ','LPPD'=>'LPPD','TIDAK_TERISI'=>'TIDAK_TERISI'), '', 'id="pelaporan", class="form-control select2", style="width:100%", onchange="get_items()"'); ?> </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-sm-12">
      <div class="card">
         <div class="card-header pb-0">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-2">
                  <div class="row mb-2">
                     <div class="col-xl-9 col-lg-9 col-sm-9">
                        <div class="float-right">
                           <button class="btn btn-primary mb-2 mr-2" onclick="cetak_laporan()">
                              <!-- <i data-feather="printer"></i> --> Cetak Laporan 
                           </button>
                        </div>
                     </div>
                     <div class="col-lg-3 text-right">
                        <div class="input-group">
                           <div class="input-group">
                              <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" id="search" onkeyup="get_items()">
                              <div class="input-group-append">
                                 <span class="input-group-text">
                                 <i data-feather="search" class="text-primary"></i>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div id="content_items"></div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
	$( document ).ready(function() {
   	 feather.replace();
  	});
	get_urusan();
	get_items();
    $(".select2").select2();
    feather.replace();

	var page = '1';
	function get_items(page){
	    var image_load = "<div class='loader3'><span></span><span></span></div>";
	    $("#content_items").html(image_load);

	    $.post(site+'data_dasar/indikator/daftar', {
	        search_field: $('#search').val(),
	  		skpd:$('select[name="skpd"]').val(),
	  		urusan:$('#urusan').val(),
	  		kategori:$('#kategori').val(),
	  		pelaporan:$('#pelaporan').val(),
	        limit: $('#limit').val(),
	        page: page
	        }, function(data) {
	        $("#content_items").html(data);
	    });
	}

	function get_urusan(){
		var skpdID = $('select[id="skpd"]').val();
		$("#bidang_urusan").html('<i class="fa fa-refresh fa-spin"></i>');
		load('data_dasar/filter_urusan/'+skpdID, '#bidang_urusan');
	}

	function cetak_laporanx(){
		$.post(site+'data_dasar/indikator/cetak_laporan', {
	  		skpd:$('select[name="skpd"]').val(),
	  		urusan:$('#urusan').val(),
	  		kategori:$('#kategori').val(),
	  		pelaporan:$('#pelaporan').val(),
	        }, function(data) {
	        // window.open(site,'_blank' );
	    });
	}

	function cetak_laporan(){
		var skpd,urusan,kategori,pelaporan;
		
		skpd = $('select[name="skpd"]').val();
	  	urusan = $('#urusan').val();
	  	kategori = $('#kategori').val();
	  	pelaporan = $('#pelaporan').val();

	  	url = site+'data_dasar/indikator/cetak_laporan?skpd='+skpd+'&urusan='+urusan+'&kategori='+kategori+'&pelaporan='+pelaporan;
	  	window.open(url,'_blank' );


		// $.ajax({
	 //            url: site+'data_dasar/indikator/cetak_laporan',
	 //            type: "POST",
	 //            cache: false,
	 //            data: { skpd:skpd,urusan:urusan,kategori:kategori,pelaporan:pelaporan},
	 //            contentType: 'application/json; charset=utf-8',
	 //            success: function(data) {
	 //            	window.location = site;//
	 //            },
	 //            error: function(jqXHR, textStatus, errorThrown) {
	 //                alert('Error');
	 //            }
	 //    });
	}

    function tambah_indikator(){
        load('data_dasar/indikator/tambah/', '#contents');
    }
</script>