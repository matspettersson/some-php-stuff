<?php

/* Set up the 2 datatables according to the different criterias. */
$dataTable1 = calldb("I");
$dataTable2 = calldb("E");


function calldb($action) {
	$dbname = 'mats';
	$username = 'root';
	$password = 'mats';
	$dbhost = "192.168.1.8";

	try {
		/* Establish the database connection */
		$conn = new PDO("mysql:host=$dbhost;charset=utf8;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$str = "select shortname, project, description, category, start, stop, percentdone, dependency from pipeline where category like \"%" . $action ."%\" order by start asc";

		$result = $conn->query($str);
		$retstr = "";

		foreach($result as $r) {
			$shortname 	= $r[0];
			$project 	= $r[1];
			$desc	 	= $r[2];
			$category 	= $r[3];
			$start 		= $r[4];
			$stop 	 	= $r[5];
			$percentdone	= $r[6]; 
			$dependency 	= $r[7];
			if(strlen($dependency)  > 0)		// In order to make the dependencies
				$dependency .= "_taskid";
			else
				$dependency = null;
			$retstr .= "['" . $shortname . "_taskid','" .$project . "','" . $shortname . "_resid'," . createvaliddate($start) . "," . createvaliddate($stop) . ", null, " . $percentdone .", '" . $dependency . "'],";
			}

		$dataTable  = rtrim($retstr, ",");	// Remove that last ',' from $retstr 
	} catch(PDOException $e) {
        	echo 'ERROR: ' . $e->getMessage();
	}

return $dataTable;
}

/*
	Create date string for constructing the tight date format in the datatable.
	Required format for Google visualization => new Date(yyyy, mm, dd);
*/
function createvaliddate($dt) {
	$y = date('Y', strtotime($dt));
	$m = date('m', strtotime($dt));
	$d = date('d', strtotime($dt));
	$mm = (int)$m - 1;

	$retstr = "new Date(" . $y . "," . $mm . "," . $d . ")";

return $retstr;
} 

?>


<html>
<head>
<meta charset="UTF-8" />
<title>Pipeline</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	google.charts.load('current', {'packages':['gantt']});
	google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

	var data1 = new google.visualization.DataTable();
      		data1.addColumn('string', 'Task ID');
		data1.addColumn('string', 'Task Name');
		data1.addColumn('string', 'Resource');
		data1.addColumn('date',   'Start Date');
		data1.addColumn('date',   'End Date');
		data1.addColumn('number', 'Duration');
		data1.addColumn('number', 'Percent Complete');
		data1.addColumn('string', 'Dependencies');

	var data2 = new google.visualization.DataTable();
      		data2.addColumn('string', 'Task ID');
		data2.addColumn('string', 'Task Name');
		data2.addColumn('string', 'Resource');
		data2.addColumn('date',   'Start Date');
		data2.addColumn('date',   'End Date');
		data2.addColumn('number', 'Duration');
		data2.addColumn('number', 'Percent Complete');
		data2.addColumn('string', 'Dependencies');

/* Populate the 2 datatables with information from the database. */
data1.addRows([ <?php echo $dataTable1; ?> ]);
data2.addRows([ <?php echo $dataTable2; ?> ]);

/* Options for the table */
          var options = {
              height: 1200
            };

          var chart1 = new google.visualization.Gantt(document.getElementById('chart_1'));
          chart1.draw(data1, options);
          var chart2 = new google.visualization.Gantt(document.getElementById('chart_2'));
          chart2.draw(data2, options);
        }
        </script>
      </head>

<body>
<h1>Gantt 1</h1>
<div id="chart_1"></div>
<h1>Gantt 2</h1>
<div id="chart_2"></div>
</body>
</html>
