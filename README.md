# some-php-stuff
Some scripts that I've created mostly for learning stuff.



## Examples with the Google Visualization API's

Ref. [google-visualization] (https://developers.google.com/chart/ "Google Chart API's")

### db.schema
Contains the MySQL DDL for creating the 'pipeline' table that is used in the gantt-example.php

### gantt-example.php
This example requires PHP and MySQL.

My first intention was to use JSON, but I never got json_encode to create the correct format for the Google API.
Instead I create the string myself, and insert the PHP variable into JavaScript.

I found it easier to create the column structure in Javascript. The Gantt library requires the following fields to work, but the last one, dependencies, is optional.

		var data1 = new google.visualization.DataTable();
			data1.addColumn('string', 'Task ID');
			data1.addColumn('string', 'Task Name');
			data1.addColumn('string', 'Resource');
			data1.addColumn('date',   'Start Date');
			data1.addColumn('date',   'End Date');
			data1.addColumn('number', 'Duration');
			data1.addColumn('number', 'Percent Complete');
			data1.addColumn('string', 'Dependencies');


This is how I solved my JSON trouble.
I "echo" the string into the *addRows* function:

		data1.addRows([ <?php echo $dataTable1; ?> ]);

The $dataTable1 string contains the following text:

		data1.addRows([ ['taskid','My task','task_resid',new Date(2016,0,01),new Date(2016,8,30), null, 0, ''] ]);

Remember that the month number in the Javascript Date function is zero based, so I have to subtract 1 from the value in the database. I.e. new Date(2016,0,01) equals 2016-01-01.

Then I draw the charts using the following code:

		var chart1 = new google.visualization.Gantt(document.getElementById('chart_1'));
		chart1.draw(data1, options);
