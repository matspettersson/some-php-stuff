<?php
$dbname = 'mats';
$username = 'root';
$password = 'root';
$dbhost = "localhost";

try {
	/* Establish the database connection */
	$conn = new PDO("mysql:host=$dbhost;charset=utf8;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$str = "select genus, species, count( * ) from varieties group by species";

	$result = $conn->query($str);
	$retstr = "";

/* Create the datatable string that is used for rendering the pie chart. */
	foreach($result as $r) {
		$genus	 	= $r[0];
		$species 	= $r[1];
		$count	 	= $r[2];
		
		$retstr .= "['" . $genus . " " . $species . "', " . $count . "],";
		}

	$dataTable  = rtrim($retstr, ",");	// Remove that last ',' from $retstr 
} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

?>


<html>
<head>
<meta charset="UTF-8" />
<title>Pie exmample</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

	var data = new google.visualization.DataTable();
      	data.addColumn('string', 'species');
	data.addColumn('number', '# of varieties');

	data.addRows([ <?php echo $dataTable; ?> ]);

        var options = {
          title: 'Distribution of my varieties between species',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 600px;"></div>
  </body>
</html>
