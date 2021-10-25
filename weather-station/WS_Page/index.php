
<?php
$rows_temp = array();
$rows_temp_ext = array();
$rows_umd = array();
$rows_umd_ext = array();
$table_temp = array();
$table_temp_ext = array();
$table_umd = array();
$table_umd_ext = array();
$rows_bat = array();
$rows_tempo = array();

$table_temp['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperatura (°C)', 
  'type' => 'number'
 )
);

$table_temp_ext['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperatura (°C)', 
  'type' => 'number'
 )
);

$table_umd['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Umidade (%)', 
  'type' => 'number'
 )
);

$table_umd_ext['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Umidade (%)', 
  'type' => 'number'
 )
);


//--------------------------- Coletando informação dos sensores externos
$connect = mysqli_connect("localhost", <db>, <db_name>, <db_password>);
$query = 'SELECT temperatura, umidade, UNIX_TIMESTAMP(horario) AS datetime FROM <table_db> ORDER BY horario DESC';
$result = mysqli_query($connect, $query) or die('Errant query:  '.$query);

while($row = mysqli_fetch_array($result))
{
 $sub_array_temp_ext = array();
 $sub_array_umd_ext = array();
 
 $datetime_ext = explode(".", $row["datetime"]);

 $sub_array_temp_ext[] =  array(
      "v" => 'Date(' . $datetime_ext[0] . '000)'
     );
 $sub_array_temp_ext[] =  array(
      "v" => $row["temperatura"]
     );
     
 $sub_array_umd_ext[] =  array(
      "v" => 'Date(' . $datetime_ext[0] . '000)'
     );
 $sub_array_umd_ext[] =  array(
      "v" => $row["umidade"]
     );
     
 $rows_temp_ext[] =  array(
     "c" => $sub_array_temp_ext
    );
 $rows_umd_ext[] =  array(
     "c" => $sub_array_umd_ext
    );
}

mysqli_close($connect);

$table_temp_ext['rows'] = $rows_temp_ext;
$table_umd_ext['rows'] = $rows_umd_ext;
$jsonTable_temp_ext = json_encode($table_temp_ext);
$jsonTable_umd_ext = json_encode($table_umd_ext);

?>

<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://pt.eltiempo.es/widget/widget_loader/ba9d95fef3ca4bfa28f8e0fe00e4d055"></script>
  
  <script type="text/javascript">
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart_temp);
   google.charts.setOnLoadCallback(drawChart_temp_ext);
   google.charts.setOnLoadCallback(drawChart_umd);
   google.charts.setOnLoadCallback(drawChart_umd_ext);

   //--------------------------- gera gráfico temperatura externa
   function drawChart_temp_ext()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable_temp_ext; ?>);

    var options = {
     title:'Temperatura (externa)',
     titleTextStyle: {color: '#fff'},
     legendTextStyle: {color: '#fff'},
     fontName: 'freemono',
     legend:{position:'bottom', color: '#fff'},
     chartArea:{width:'95%', height:'65%'},
     backgroundColor: '#373c3e',
     hAxis: {textStyle:{color: '#fff'}, gridlines: {color: '#454a4d'}},
     vAxis: {textStyle:{color: '#fff'}, gridlines: {color: '#454a4d'}}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart_temp_ext'));

    chart.draw(data, options);
   }
   
   //--------------------------- gera gráfico umidade externa
   function drawChart_umd_ext()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable_umd_ext; ?>);

    var options = {
     title:'Umidade (externa)',
     titleTextStyle: {color: '#fff'},
     legendTextStyle: {color: '#fff'},
     fontName: 'freemono',
     legend:{position:'bottom', color: '#fff'},
     chartArea:{width:'95%', height:'65%'},
     backgroundColor: '#373c3e',
     hAxis: {textStyle:{color: '#fff'}, gridlines: {color: '#454a4d'}},
     vAxis: {textStyle:{color: '#fff'}, gridlines: {color: '#454a4d'}}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart_umd_ext'));

    chart.draw(data, options);
   }
   
  </script>
  
  <script type="text/javascript">
	google.charts.load('current', {'packages':['table']});
	google.charts.setOnLoadCallback(drawTable);
	
    function drawTable() {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Horário');
        data.addColumn('string', 'Temperatura');
        data.addColumn('string', 'Umidade');
        data.addColumn('string', 'Tempo');
        data.addColumn('string', 'Bateria');
        data.addRows([
			<?php
				$connect = mysqli_connect("localhost", "nodeMCU", "nodeMCU", "nodeMCU");
				$query = 'SELECT tempo, bateria, temperatura, umidade, horario FROM esp8266_01 ORDER BY id DESC LIMIT 16';
				$result = mysqli_query($connect, $query) or die('Errant query:  '.$query);
				
				while($row = mysqli_fetch_array($result)){
					echo "['".$row["horario"]."', '".$row["temperatura"]."', '".$row["umidade"]."', '".$row["tempo"]."', '".$row["bateria"]."'],";
				}
				mysqli_close($connect);
			?>
        ]);
        
        var cssClassNames = {
			'headerRow': 'header-background',
			'oddTableRow': 'odd-background',
			'tableRow': 'table-background',
			'selectedTableRow': 'select-background',
			'hoverTableRow': 'hover-background',
			'rowNumberCell': 'underline-blue-font'
		};
        
        var options = {
			'cssClassNames': cssClassNames,
			'allowHtml': true,
			'showRowNumber': true, 
			'width': '100%',
			'height': '20%'
		};
        
        var table = new google.visualization.Table(document.getElementById('table_div'));
        
		table.draw(data, options);
	}
	</script>
	
	<script type="text/javascript">
		google.charts.load("current", {packages:["calendar"]});
		google.charts.setOnLoadCallback(drawChart);
		
		function drawChart() {
			var dataTable = new google.visualization.DataTable();
			dataTable.addColumn({ type: 'date', id: 'Date' });
			dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
			dataTable.addRows([
				[new Date(2021, 0, 1), 0],
				<?php
					$connect = mysqli_connect("localhost", "nodeMCU", "nodeMCU", "nodeMCU");
					$query = 'SELECT tempo, horario FROM esp8266_01 where tempo = "chovendo"';
					$result = mysqli_query($connect, $query) or die('Errant query:  '.$query);
					
					$linha_anterior = " ";
					
					while($row = mysqli_fetch_array($result)){
						$mes = (int)substr($row["horario"],5,2) - 1;
						$linha_atual = "[new Date(".substr($row["horario"],0,4).", ".$mes.", ".substr($row["horario"],8,2).")";
									
						if ($linha_atual == $linha_anterior){
							$number = $number + 15;
							echo "[new Date(".substr($row["horario"],0,4).", ".$mes.", ".substr($row["horario"],8,2)."), ".$number."], ";
						} else {
							echo "[new Date(".substr($row["horario"],0,4).", ".$mes.", ".substr($row["horario"],8,2)."), 15], ";
							$linha_anterior = $linha_atual;
							$number = 15;
						}
					}
					mysqli_close($connect);
				?>
			]);

			var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

			var options = {
			 title: "Histórico de Chuva",
			 calendar: { cellSize: 19, 
				 monthLabel: {
					fontName: 'freemono',
					color: '#fff',
					bold: true,
					},
				},
			 height: 350,
			};

       chart.draw(dataTable, options);
	}
	</script>
	
  <style>
	.page-wrapper
	{
		width:1100px;
		margin:0 auto;
	}

	body
	{
		background-color: #282c34;
	}

	h1, h2, h3{
		color: #fff;
		font-family: freemono;  
	}

	.header-background{
		background-color: #cecece;
		color: #000;
	}

	.hover-background {
		background-color: red;
		color: #000;
	}

	.odd-background {
		background-color: #181a1b;
		color: #fff;
	}
  
	.table-background{
		background-color: #373c3e;
		color: #fff;
	}
	
	.select-background{
		background-color: #b1b580;
		color: #000 !important;
	}
	
  </style>
 </head>  
 <body>
	<div class="page-wrapper">
	<br />
	<h1 align="center">Registros Climáticos</h1>
	<br/>
	<br/>
	<img src="https://www.tempo.com/wimages/foto2fec2276e49e2dad3b58979f397a0d06.png" style="display: block; margin-left: auto; margin-right: auto;">
	<br/>
	<br/>
	<h3>Dados Coletados do nodeMCU nas Últimas 4 Horas:</h3>
	<div id="table_div"></div>
	<br/>
	<br/>
	<div id="calendar_basic" style="width: 100%; height: 230px"></div>
	<h3>Sensor Interno:</h3>
	<div id="line_chart_temp" style="width: 100%; height: 500px"></div>
	<br/>
	<div id="line_chart_umd" style="width: 100%; height: 500px"></div>
	<br/>
	<br/>
	<h3>Sensor Externo:</h3>
	<div id="line_chart_temp_ext" style="width: 100%; height: 500px"></div>
	<br/>
	<div id="line_chart_umd_ext" style="width: 100%; height: 500px"></div>
	<br/>
  </div>
  </div>
 </body>
</html>
