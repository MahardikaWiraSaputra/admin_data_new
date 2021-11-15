<div class="customtabs" style="overflow-x: hidden;">
   <input id="tab1" type="radio" name="tabs" checked>
   <label for="tab1">Trend</label>
   <input id="tab2" type="radio" name="tabs">
   <label for="tab2">Rasio</label>
   <input id="tab3" type="radio" name="tabs">
   <label for="tab3">Persentase</label>
   <input id="tab4" type="radio" name="tabs">
   <label for="tab4">Overlay</label>
   <section id="content1">
    <h3 class="text-center">Trend <b><?=$indikator[0];?></b></h3>
	<div class="row">
	   <div class="col-md-8">
	      <div class="d-flex justify-content-between">
	         <h4 class="kindbold">Data Series</h4>
	      </div>
	      <div id="chart-trend">
	      </div>
	      <div class="table-responsive">
	         <table class="table table-bordered mt-5 text-center" class="kindcenter">
	            <thead>
	               <tr class="kindtr">
	                  <th colspan="10" class="kindtable">
	                     Tabel Data 
	                  </th>
	               </tr>
	               <tr style="background: #a4d0f3;">
		               <th class="kindtrbold">2013</th>
		               <th class="kindtrbold">2014</th>
		               <th class="kindtrbold">2015</th>
		               <th class="kindtrbold">2016</th>
		               <th class="kindtrbold">2017</th>
		               <th class="kindtrbold">2018</th>
		               <th class="kindtrbold">2019</th>
		               <th class="td-bold kindtrbold">2020</th>
		           </tr>
	            </thead>
	            <tbody>
	               <tr>
	                  <td>75</td>
	                  <td>76</td>
	                  <td>84</td>
	                  <td>106</td>
	                  <td>106</td>
	                  <td>105</td>
	                  <td>109</td>
	                  <td><span class="badge badge-success">111</span></td>
	               </tr>
	            </tbody>
	         </table>
	      </div>
	   </div>
	   <div class="col-md-4">
	      <div id="general-info" class="">
	         <div class="info">
	            <div class="d-flex justify-content-between">
	               <div class="float-right">
	               </div>
	            </div>
	            <form>
	               <div class="row">
	               	<h4 class="kindbold">Profil Indikator</h4>
	                  <table class="table table-striped mt-3">
	                     <tr>
	                        <td class="td-bold">Indikator SKPD</td>
	                        <td>:</td>
	                        <td>-</td>
	                     </tr>
	                     <tr>
	                        <td class="td-bold">Bidang Urusan</td>
	                        <td>:</td>
	                        <td><?=$indikator[2]?></td>
	                     </tr>
	                     <tr>
	                        <td class="td-bold">Prediksi Nilai Pada Tahun 2020</td>
	                        <td>:</td>
	                        <td><span class="badge badge-success">111 <i data-feather="trending-up"></i></span></td>
	                     </tr>
	                  </table>
	               </div>
	            </form>
	         </div>
	      </div>
	   </div>
	</div>
   </section>
   <section id="content2">
    <h3 class="text-center">Rasio <b><?=$indikator[0];?></b></h3>
	<div class="row">
	   <div class="col-md-4">
	      <div id="general-info" class="">
	         <div class="info">
	            <div class="d-flex justify-content-between">
	               <div class="float-right">
	               </div>
	            </div>
	               <div class="row">
	               	<h4 class="kindbold">Rasiokan Dengan Indikator</h4>
	                  <select class="form-control select2">
	                  	<option>INDIKATOR X</option>
	                  	<option>INDIKATOR Y</option>
	                  </select>

	                <fieldset class="the-fieldset mt-5" style="width: 100% !important;">
	                	<legend class="the-legend">Perhitungan</legend>
	                	<div class="row">
				            <div id="result_rasio" class="col-md-8">
				             <p class="p-take">INDIKATOR X</p>
				             <div class="divide"></div>
				             <p class="p-take">INDIKATOR Y</p>
				            </div>
				            <div id="result_rasio" class="col-md-1">
				             <p></p>
				             <div class="isBold">X</div>
				             <p></p>
				            </div>
				            <div id="result_rasio" class="col-md-3">
				             <p></p>
				             <div class="isBold">Per 100.000 (Contoh)</div>
				             <p></p>
				            </div>
				        </div>
			        </fieldset>

	               </div>
	         </div>
	      </div>
	   </div>
	   <div class="col-md-8">
	      <div id="chart-rasio">
	      </div>
	   </div>
	</div>
   </section>
   <section id="content3">
    <h3 class="text-center">Persentase capaian <b><?=$indikator[0];?></b></h3>
	<div id="chart-persentase"></div>
	<div class="table-responsive">
	         <table class="table table-bordered mt-5 text-center" class="kindcenter">
	            <thead>
	               <tr class="kindtr">
	                  <th colspan="10" class="kindtable">
	                     Tabel Data 
	                     <p class="kindp">* Series tahun terakhir adalah prediksi nilai</p>
	                  </th>
	               </tr>
	               <tr style="background: #a4d0f3;">
		               <th class="kindtrbold">2013</th>
		               <th class="kindtrbold">2014</th>
		               <th class="kindtrbold">2015</th>
		               <th class="kindtrbold">2016</th>
		               <th class="kindtrbold">2017</th>
		               <th class="kindtrbold">2018</th>
		               <th class="kindtrbold">2019</th>
		               <th class="kindtrbold">2020</th>
	           	   </tr>
	            </thead>
	            <tbody class="text-left">
	               <tr>
	                  <td><b>Target</b> : 99 </td>
	                  <td><b>Target</b> : 99 </td>
	                  <td><b>Target</b> : 100</td>
	                  <td><b>Target</b> : 100 </td>
	                  <td><b>Target</b> : 100 </td>
	                  <td><b>Target</b> : 100 </td>
	                  <td><b>Target</b> : 100 </td>
	                  <td><b>Target</b> : 100 </td>
	               </tr>
	               <tr>
	                  <td><b>Realisasi</b> : 90</td>
	                  <td><b>Realisasi</b> : 95</td>
	                  <td><b>Realisasi</b> : 97</td>
	                  <td><b>Realisasi</b> : 97</td>
	                  <td><b>Realisasi</b> : 97</td>
	                  <td><b>Realisasi</b> : 97</td>
	                  <td><b>Realisasi</b> : 97</td>
	                  <td><b>Realisasi</b> : 97</td>
	               </tr>
	               <tr>
	                  <td><b>Capaian</b> : 90 %</td>
	                  <td><b>Capaian</b> : 95 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	                  <td><b>Capaian</b> : 97 %</td>
	               </tr>
	            </tbody>
	         </table>
	</div>
   </section>

   <section id="content4">
      <h3 class="text-center"><b>Analisa</b> Pengangguran dan Kemiskinan</h3>
      <div class="row">
       <div class="col-md-2">
	      <div id="general-info" class="">
	         <div class="info">
	            <div class="d-flex justify-content-between">
	               <div class="float-right">
	               </div>
	            </div>
	            <form>
	               <div class="row">
	               	<h4 class="kindbold">Indikator A</h4>
	                  <select class="form-control select2">
	                  	<option><?=$indikator[0];?></option>
	                  </select>
	                <h4 class="kindbold mt-2">Indikator B</h4>
	                  <select class="form-control select2">
	                  	<?php foreach($list_indikator as $data):?>
	                  		<option value="<?=$data['ID_INDIKATOR']?>"><?=$data['INDIKATOR']?></option>
	                  	<?php endforeach;?>
	                  </select>
	                <h4 class="kindbold mt-2">Indikator C</h4>
	                  <select class="form-control select2">
	                  	<?php foreach($list_indikator as $data):?>
	                  		<option value="<?=$data['ID_INDIKATOR']?>"><?=$data['INDIKATOR']?></option>
	                  	<?php endforeach;?>
	                  </select>
	                <h4 class="kindbold mt-2">Pilih Tahun</h4>
	                  <select class="form-control select2">
	                  	<?php for ($i=2011; $i < 2021; $i++) { ?>
	                  		<option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php } ?>
	                  </select>
	               </div>
	            </form>
	         </div>
	      </div>
	   </div>
	   <div class="col-md-10">
	      <!-- <div class="d-flex justify-content-between">
	         <h4 class="kindbold">Data Series</h4>
	      </div> -->
	      <div id="chart-overlay">
	      </div>
	      <!-- <div class="table-responsive">
	         <table class="table table-bordered mt-5 text-center" class="kindcenter">
	            <thead>
	               <tr class="kindtr">
	                  <th colspan="10" class="kindtable">
	                     Tabel Data 
	                  </th>
	               </tr>
	               <tr style="background: #a4d0f3;">
		               <th class="td-bold kindtrbold">2020</th>
		           </tr>
	            </thead>
	            <tbody>
	               <tr>
	                  <td><span class="badge badge-success">Persentase Pengangguran : 111</span></td>
	               </tr>
	            </tbody>
	         </table>
	      </div> -->
	   </div>
	</div>
   </section>
</div>

<script type="text/javascript">
	$( document ).ready(function(){
	feather.replace();
	$(".select2").select2();

	$('#exampleModalLabel').html("<?=$indikator[0];?>");
	// start chart trend
	const trend = {
        chart: {
                caption: "<?=$indikator[0];?>",
                yaxisname: "<?=$indikator[1];?>",
                subcaption: "Rentang Tahun [2011-2020]",
                numbersuffix: " ",
                rotatelabels: "0",
                setadaptiveymin: "1",
                exportEnabled: "1",
                exportFormats: "PNG=Export as High Quality Image|PDF=Export as Printable|XLSX=Export Chart Data",
                exportTargetWindow: "_self",
                exportFileName: "Indikator",
                theme: "fusion"
              },
              data: <?=$data_tahun;?>
            };

        FusionCharts.ready(function() {
              var myChart = new FusionCharts({
                type: "line",
                renderAt: "chart-trend",
                width: "100%",
                height: "300",
                dataFormat: "json",
                dataSource: trend
              }).render();
        });
    // end chart trend

    // start chart rasio
    const rasio = {
	  chart: {
	    subcaption: "2013-2020",
	    xaxisname: "<?=$indikator[1];?>",
	    yaxisname: "<?=$indikator[1];?>",
	    numbersuffix: "K",
	    plottooltext: "<b>$value</b> <?=$indikator[0];?> <b>Tahun $label</b>",
	    theme: "fusion"
	  },
	  data: <?=$data_tahun;?>
	};

	FusionCharts.ready(function() {
	  var myChart = new FusionCharts({
	    type: "column2d",
	    renderAt: "chart-rasio",
	    width: "100%",
	    height: "300",
	    dataFormat: "json",
	    dataSource: rasio
	  }).render();
	});

    // end chart rasio

    // start chart persentase
    const dataSource = {
	  chart: {
	    subcaption: "Tahun (2013-2019)",
	    yaxisname: "Persentase",
	    syaxisname: "Persentase Capaian",
	    snumbersuffix: "%",
	    drawcustomlegendicon: "0",
	    showvalues: "0",
	    rotatelabels: "0",
	    theme: "fusion"
	  },
	  categories: [
	    {
	      category: <?=$data_tahun_rasio;?>
	    }
	  ],
	  dataset: [
	    {
	      seriesname: "Target",
	      data: <?=$data_target_rasio;?>
	    },
	    {
	      seriesname: "Realisasi",
	      data: <?=$data_target_rasio;?>
	    },
	    {
	      seriesname: "Persentase Capaian",
	      renderas: "line",
	      parentyaxis: "S",
	      data: <?=$data_target_rasio;?>
	    }
	  ]
	};

	FusionCharts.ready(function() {
	  var myChart = new FusionCharts({
	    type: "mscolumn3dlinedy",
	    renderAt: "chart-persentase",
	    width: "100%",
	    height: "300",
	    dataFormat: "json",
	    dataSource
	  }).render();
	});

    // end chart persentase

    // start chart overlay
    const overlay = {
	  chart: {
	        subcaption: "Tahun 2019",
	        xAxisMinValue: "0",
	        xAxisMaxValue: "100",
	        yAxisMinValue: "0",
	        yAxisMaxValue: "30000",
	        plotFillAlpha: "70",
	        plotFillHoverColor: "#6baa01",
	        xAxisName: "Persentase Kemiskinan",
	        yAxisName: "Persentase Pengangguran",
	        numDivlines: "2",
	        showValues: "1",
	        plotTooltext: "$name : Jumlah Penduduk  $zvalue",
	        drawQuadrant: "1",
	        quadrantLineAlpha: "80",
	        quadrantLineThickness: "3",
	        quadrantXVal: "50",
	        quadrantYVal: "15000",
	        quadrantLabelTL: "Persentase Kemiskinan Rendah / Persentase Pengangguran Tinggi",
	        quadrantLabelTR: "Persentase Pengangguran Tinggi / Persentase Kemiskinan Tinggi",
	        quadrantLabelBL: "Persentase Pengangguran Rendah / Persentase Kemiskinan Rendah",
	        quadrantLabelBR: "Persentase Kemiskinan Tinggi / Persentase Pengangguran Rendah",
	        use3dlighting: "0",
	        showAlternateHGridColor: "0",
	        showAlternateVGridColor: "0",
	        theme: "fusion"
	    },
	  categories: [
	    {
	      category: [
	        {
	          label: "10%",
	          x: "10",
	          showverticalline: "1"
	        },
	        {
	          label: "20%",
	          x: "20",
	          showverticalline: "1"
	        },
	        {
	          label: "40%",
	          x: "40",
	          showverticalline: "1"
	        },
	        {
	          label: "60%",
	          x: "60",
	          showverticalline: "1"
	        },
	        {
	          label: "80%",
	          x: "80",
	          showverticalline: "1"
	        },
	        {
	          label: "100%",
	          x: "100",
	          showverticalline: "1"
	        }
	      ]
	    }
	  ],
	  dataset: [
	    {
	      color: "#00aee4",
	      data: [
	        {
	          x: "80",
	          y: "15000",
	          z: "2400",
	          name: "Banyuwangi"
	        },
	        {
	          x: "60",
	          y: "18500",
	          z: "2600",
	          name: "Rogojampi"
	        },
	        {
	          x: "50",
	          y: "19450",
	          z: "1900",
	          name: "Ketapang"
	        },
	        {
	          x: "65",
	          y: "10500",
	          z: "800",
	          name: "Kalipuro"
	        },
	        {
	          x: "43",
	          y: "8750",
	          z: "500",
	          name: "Giri"
	        },
	        {
	          x: "32",
	          y: "22000",
	          z: "1000",
	          name: "Glagah"
	        },
	        {
	          x: "44",
	          y: "13000",
	          z: "900",
	          name: "Cluring"
	        }
	      ]
	    }
	  ],
	  trendlines: [
	    {
	      line: [
	        {
	          startvalue: "20000",
	          endvalue: "30000",
	          istrendzone: "1",
	          color: "#aaaaaa",
	          alpha: "14"
	        },
	        {
	          startvalue: "10000",
	          endvalue: "20000",
	          istrendzone: "1",
	          color: "#aaaaaa",
	          alpha: "7"
	        }
	      ]
	    }
	  ]
	};

	FusionCharts.ready(function() {
	  var myChart = new FusionCharts({
	    type: "bubble",
	    renderAt: "chart-overlay",
	    width: "100%",
	    height: "500",
	    dataFormat: "json",
	    dataSource: overlay
	  }).render();
	});

    // end chart overlay
 	})        
</script>