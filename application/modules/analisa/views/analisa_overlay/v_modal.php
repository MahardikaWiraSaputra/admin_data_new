<div class="customtabs" style="overflow-x: hidden;">
   <input id="tab4" type="radio" name="tabs" checked>
   <label for="tab4">Overlay</label>

   <section id="content4">
      <h3 class="text-center"><b><?=$title;?></b></h3>
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
	                <h4 class="kindbold mt-2">Pilih Tahun</h4>
	                <input type="hidden" name="analisa_id" value="<?=$id;?>" id="analisa_id">
	                  <select class="form-control" name="tahun_overlay" id="tahun_overlay">
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

	      <div id="chart-overlay">
	      </div>

	   </div>
	</div>
   </section>
</div>

<script type="text/javascript">

	$('#tahun_overlay').change(function () {
    	var val = this.value;
    	var analisa = $('#analisa_id').val();
    	console.log(val);

    	$.ajax({
            url: site+'analisa/analisa_overlay/filter_overlay',
            type: "POST",
            data: {tahun: val,analisa : analisa}, 
            dataType: "JSON",
            success: function(data) {

            const overlayy = {
			  chart: {
			        subcaption: "Tahun "+val,
			        xAxisMinValue: "0",
			        xAxisMaxValue: "100",
			        yAxisMinValue: "0",
			        yAxisMaxValue: "1000",
			        plotFillAlpha: "70",
			        plotFillHoverColor: "#6baa01",
			        xAxisName: data.indikator_x,
			        yAxisName: data.indikator_y,
			        numDivlines: "2",
			        showValues: "1",
			        plotTooltext: "$name : Jumlah Penduduk  $zvalue",
			        drawQuadrant: "1",
			        quadrantLineAlpha: "80",
			        quadrantLineThickness: "3",
			        quadrantXVal: "300",
			        quadrantLabelTL: ""+data.indikator_x+" Rendah / "+data.indikator_y+" Tinggi",
			        quadrantLabelTR: ""+data.indikator_y+" Tinggi / "+data.indikator_x+" Tinggi",
			        quadrantLabelBL: ""+data.indikator_y+" Rendah / "+data.indikator_x+" Rendah",
			        quadrantLabelBR: ""+data.indikator_x+" Tinggi / "+data.indikator_y+" Rendah",
			        use3dlighting: "0",
			        showAlternateHGridColor: "0",
			        showAlternateVGridColor: "0",
			        theme: "fusion"
			    },
			  categories: [
			    {
			      category: 
			        data.data_y
			      
			    }
			  ],
			  dataset: [
			    {
			      color: "#00aee4",
			      data: 
			        data.data_all
			      
			    }
			  ],
			  trendlines: [
			    {
			      line: [
			        {
			          startvalue: "50000",
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
			    dataSource: overlayy
			  }).render();
			});

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error');
            }
        });

 	});

	$( document ).ready(function(){

	feather.replace();
	$(".select2").select2();

	$('#exampleModalLabel').html(' ');

    // start chart overlay
    const overlay = {
	  chart: {
	        subcaption: "Tahun "+$('#tahun_overlay').val(),
	        xAxisMinValue: "0",
	        xAxisMaxValue: "100",
	        yAxisMinValue: "0",
	        yAxisMaxValue: "1000",
	        plotFillAlpha: "70",
	        plotFillHoverColor: "#6baa01",
	        xAxisName: "<?=$indikator_x;?>",
	        yAxisName: "<?=$indikator_y;?>",
	        numDivlines: "2",
	        showValues: "1",
	        plotTooltext: "$name : <?=$indikator_y;?> $zvalue",
	        drawQuadrant: "1",
	        quadrantLineAlpha: "80",
	        quadrantLineThickness: "3",
	        quadrantXVal: "300",
	        quadrantLabelTL: " <?=$indikator_x;?> Rendah / <?=$indikator_y;?> Tinggi",
	        quadrantLabelTR: " <?=$indikator_y;?> Tinggi / <?=$indikator_x;?> Tinggi",
	        quadrantLabelBL: " <?=$indikator_y;?> Rendah / <?=$indikator_x;?> Rendah",
	        quadrantLabelBR: " <?=$indikator_x;?> Tinggi / <?=$indikator_y;?> Rendah",
	        use3dlighting: "0",
	        showAlternateHGridColor: "0",
	        showAlternateVGridColor: "0",
	        theme: "fusion"
	    },
	  categories: [
	    {
	      category: 
	        <?=$data_y;?>
	      
	    }
	  ],
	  dataset: [
	    {
	      color: "#00aee4",
	      data: 
	        <?=$data_all;?>
	      
	    }
	  ],
	  trendlines: [
	    {
	      line: [
	        {
	          startvalue: "50000",
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