# some-php-stuff
Some scripts

## Examples with the Google Visualization API's

[google-visualization] (https://developers.google.com/chart/ "Google Chart API's")


### db.schema
Contains the MySQL DDL for creating the 'pipeline' table that is used in the gantt-example.php

### gantt-example.php
This example requires PHP and MySQL.

My first intention was to use JSON, but I never got json_encode to create the correct format for the Google API.
Instead I create the string myself, and insert the PHP variable into JavaScript.
