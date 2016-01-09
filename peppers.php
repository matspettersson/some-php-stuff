<?php session_start();
error_reporting(E_ALL | E_STRICT);
?>
<html>
<!DOCTYPE html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<!-- Kom ihåg metainformation från databasen  -->
<title>Chiles in Stockholm - Chile Pepper Database</title>
<!-- Title ändras sen beroende på pepparsort...   -->
</head>

<body>

<?php
/*
*** Check action ***
*/
unset($action);
if(isset($_GET["action"]))
	$action=$_GET['action'];
else 
	$action = null;


switch($action) {
	case "variety":
		$id=$_GET["id"];
		if($id == null)
			$id = 1;
			
		$title = getVarietynameTitle($id);

		print "<div data-role=\"page\" id=\"var1\" data-theme=\"e\">\n";
		print "<div data-role=\"header\" data-theme=\"e\"><!-- /header -->\n";
		print "<h1>" . getNameAndURLtoSpecies($id) . "</h1>\n";   
		print "<a href=\"index.php\" rel=\"external\" data-role=\"button\" data-icon=\"home\"  data-iconpos=\"notext\" data-direction=\"reverse\">Home</a>\n";
		print "<a href=\"peppers.php\" rel=\"external\" data-role=\"button\" data-icon=\"back\" data-iconpos=\"notext\" data-rel=\"dialog\" data-transition=\"fade\">Back</a>\n";
		print "</div\n>";

		print "<div data-role=\"content\" data-theme=\"E\">\n";
		print "<script type=\"text/javascript\">";
		print "	document.title = " . "\"" . $title . "\";";
		print "</script>";

		$conn = connecttodb();
		$qry = "select * from pictures where varietyid = \"" . $id . "\";"; 
		try {
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$filename = $row['filename'];
				$comment = $row['comment'];
				$picdate = $row['picdate'];
				print "<p><img src=\"" . fixImageFilename($filename) . "\"></p>\n";
				print "<p>" . $picdate . " - " . $comment . "</p>\n";
			}
			} catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}

		$conn = NULL;
		print "</div><!-- /content -->\n";
	break;
	
	case "varietiesinspecies":
		$genusarr = array("Capsicum","other");
		$speciesarr = array("annuum","baccatum","chinense","cardenasii","chacoense","ciliatum","eximium","flexuosum","galapagoense","praetermissum","frutescens","???","pubescens","plants","tovarii");

		$genus =$_GET["genus"];
		$species =$_GET["species"];

		if(in_array($genus,$genusarr)) {
			} else {
			$genus = "Capsicum";
			}

		if(in_array($species,$speciesarr))  {
			} else {
			$species = "annuum";
			}

		print "<div data-role=\"page\" id=\"varietiesinspecies\"  data-theme=\"e\"\n>";
		printdataroleheader($genus . " " . $species);
		print "<div data-role=\"content\" data-theme=\"e\">\n";
		print "<ul data-role=\"listview\" data-mini data-theme=\"e\" data-count-theme=\"b\"  data-filter=\"true\">\n";

		$conn = connecttodb();	
		$qry = "select * from varieties where genus = \"$genus\" and species = \"$species\" order by commonname;"; 

		try {
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$id = $row['varietyid'];
				$commonname = $row['commonname'];
				printpepperlistitem($id, $commonname);
				}
			} catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
		$conn = NULL;

		print "</ul>";
		print "</div><!-- /content -->\n";
	break;

	
	case "allvarieties":
		print "<div data-role=\"page\" id=\"allvarieties\"  data-theme=\"E\">";
		printdataroleheader("All varieties");
		print "<div data-role=\"content\" data-theme=\"E\">\n";
		print "<ul data-role=\"listview\" data-mini data-theme=\"E\"  data-filter=\"true\" >";

		$conn = connecttodb();	
		$qry = "select * from varieties order by commonname;"; 

		try {
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$id = $row['varietyid'];
				$commonname = $row['commonname'];
				printpepperlistitem($id, $commonname);
				}
			} catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}
		$conn = NULL;

		print "</ul>\n";
		print "</div><!-- /content -->\n";
	break;

	case "latest":
		print "<div data-role=\"page\" id=\"latest\"  data-theme=\"E\">";
		printdataroleheader("Latest pictures");
		print "<div data-role=\"content\" data-theme=\"E\">\n";

		$conn = connecttodb();	

		try {
			$qry = "select max(picdate) from pictures;"; 
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$dt = $row[0];
				}

			print "<ul data-role=\"listview\" data-mini data-theme=\"E\"   data-filter=\"true\">";
			$qry = "select distinct varietyid from pictures where picdate = \"" . $dt . "\";"; 
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$id = $row['varietyid'];
				$qry1 = "select commonname from varieties where varietyid = \"" . $id . "\";"; 
				$stmt = $conn->prepare($qry1);
				$stmt->execute();
				$result = $stmt->fetchAll();

				while($row = array_shift($result)) {
					$cn1 = $row['commonname'];
					printpepperlistitem($id, $cn1);
					}
				}
			} catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}

		$conn = NULL;
		print "</ul>";
		print "</div><!-- /content -->\n";
	break;
	
	
	default:
		print "<div data-role=\"page\" id=\"pepperhome\" data-theme=\"e\" data-title=\"Chile Pepper Database\">\n";
		print "<div data-role=\"header\" data-theme=\"e\"><!-- /header -->\n";
		print "<a href=\"index.php\" rel=\"external\" data-role=\"button\" data-icon=\"home\">Home</a>\n";
		print "<h1>Chile Pepper Database</h1>\n";   
		print "</div>\n";

		print "<div data-role=\"content\" data-theme=\"E\">\n";
		print "<ul data-role=\"listview\" data-mini data-theme=\"c\" data-count-theme=\"c\">\n";	//  data-filter=\"true\"

		$conn = connecttodb();
		$qry = "select distinct genus, species from varieties order by genus;"; 

		try {
			$stmt = $conn->prepare($qry);
			$stmt->execute();
			$result = $stmt->fetchAll();

			while($row = array_shift($result)) {
				$genus 	 = $row['genus'];
				$species = $row['species'];
				print "<li><a href=\"peppers.php?action=varietiesinspecies&genus=$genus&species=$species\"  rel=\"external\" >$genus&nbsp;$species <div class=\"ui-li-count\">" . getnumberofvarieties($genus, $species) . "</div></a></li>\n";	//  class=\"ui-li-has-thumb\"
			} 
			} catch(PDOException $e) {
			    echo "Error: " . $e->getMessage();
			}

		$conn = NULL;

		print "<li><a href=\"peppers.php?action=allvarieties\"  rel=\"external\" >All varieties<div class=ui-li-count>" . getnumberofallvarieties() . "</div></a></li>\n";	
		print "<li><a href=\"peppers.php?action=latest\"  rel=\"external\">Latest pictures<div class=ui-li-count>" . getnumberoflatestpictures() . "</div></a></li>\n";	
		print "</ul>";

		print "</div><!-- /content -->\n";
	break;
	}



function printdataroleheader($h1) {
		print "<div data-role=\"header\" data-theme=\"e\"><!-- /header -->\n";
		print "<h1>" . $h1 . "</h1>\n";   
		print "<a href=\"index.php\" rel=\"external\" data-role=\"button\" data-icon=\"home\"  data-iconpos=\"notext\" data-direction=\"reverse\">Home</a>\n";
		print "<a href=\"peppers.php\" rel=\"external\" data-role=\"button\" data-icon=\"back\" data-iconpos=\"notext\" data-rel=\"dialog\" data-transition=\"fade\">Back</a>\n";

		print "</div\n>";
}
	

function printpepperlistitem($id, $commonname) {
	print "<li class=\"ui-li-has-thumb\"><img src=\"" . getthumbnailpicture($id) . "  \" style=\"max-width:100px; max-height:100px;\"><a href=\"peppers.php?action=variety&id=" . $id . " \"  rel=\"external\">&nbsp;&nbsp;"  . $commonname . " <span class=ui-li-count>" . getnumberofpictures($id) . "</span></a></li>\n";
}

function getnumberofvarieties($genus, $species) {
	$qry = "select count(*) from varieties where genus = \"" . $genus . "\" and species = \"" . $species . "\";"; 
	$no = countvarieties($qry); 
	return $no;
}

function getnumberofallvarieties() {
	$no = countvarieties("select count(*) from varieties;"); 
	return $no;
}

function getnumberofpictures($id) {
	$qry = "select count(*) from pictures where varietyid = \"" . $id . "\";"; 
	$no = countvarieties($qry); 
	return $no;
}

function getnumberoflatestpictures() {
	$conn = connecttodb();
	$qry = "select max(picdate) from pictures;"; 
	try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$dt = $row[0];
		}
		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}
	$conn = NULL;
	$qry = "select count(*) from pictures where picdate = \"" . $dt . "\";"; 
	$no = countvarieties($qry); 	
	return $no;
}


function countvarieties($qry) {
	$conn = connecttodb();

	try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$no = $row[0];
		}
		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}

	$conn = NULL;
	return $no;
}



// den här måste fixas till....	
function getthumbnailpicture($id) {
	$conn = connecttodb();
	$qry = "select filename from pictures where varietyid=$id order by picorder;"; 

	try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$filename = $row['filename'];
		}
		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}

	$conn = NULL;
	
	return fixImageFilename($filename);
}



function getNameAndURLtoSpecies($id) {
	$conn = connecttodb();
	$qry = "select genus, species, commonname from varieties where varietyid = \"" . $id . "\";"; 
	try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$genus = $row['genus'];
			$species = $row['species'];
			$name = $row['commonname'];
			}
		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}

	$conn = NULL;

	return $name . "&nbsp;<a href=\"peppers.php?action=varietiesinspecies&genus=" . $genus . "&species=" . $species . "\">(" . $genus . " " . $species  . ")</a>";
}
	

function getVarietynameTitle($id) {
	$conn = connecttodb();
	$qry = "select genus, species, commonname from varieties where varietyid = \"$id\";"; 

	try {
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$genus = $row['genus'];
			$species = $row['species'];
			$name1 = $row['commonname'];
		}
		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}

	$conn = NULL;

	$name = "\"" . $name1 . "\"";
	return $name . " (" . $genus . " " . $species . ")";
}


function fixImageFilename($filename) {
	if(strncmp($filename, '/habanero', 9) == 0)
		$retstr = ".." . $filename;
	elseif(strncmp($filename, 'images', 6) == 0)
			$retstr = "../habanero/" . $filename;
	else
		$retstr = $filename;

return $retstr;
}


function connecttodb() {
$servername = "mysql-server-name";
$username = "username";
$password = "password";
$dbname = "dbname";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn->exec("set names utf8");
return $conn;
}

?>

<div data-role="footer" data-theme="D">
<p></p>
<!--WEBBOT bot="HTMLMarkup" startspan ALT="Site Meter" -->
<script type="text/javascript" language="JavaScript">var site="s11pghabba"</script>
<script type="text/javascript" language="JavaScript1.2" src="http://s11.sitemeter.com/js/counter.js?site=sitemeter-user">
</script>
<noscript>
<a href="http://s11.sitemeter.com/stats.asp?site=sitemeter-user" target="_top">
<img src="http://s11.sitemeter.com/meter.asp?site=sitemeter-user" alt="Site Meter" border=0></a>
</noscript>
<!-- Copyright (c)2002 Site Meter -->
<!--WEBBOT bot="HTMLMarkup" Endspan -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'google-analytics-user-1', 'auto');
  ga('send', 'pageview');

</script>
<p><font size="-1">&copy; 2016 Mats Pettersson. All rights reserved.</font></p>
</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>
