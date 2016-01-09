<!doctype html>
<html>
<head>
<title>Chiles in Stockholm</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!---
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css">
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>



</head>
<body>

<div data-role="page" id="i1" data-theme="E">

<div data-role="header" data-theme="E">
<a href="peppers.php" rel="external">Chile Pepper Database</a><h1>Welcome to Chiles in Stockholm</h1><a href="http://chilesinstockholm.blogspot.com"  rel="external">Blog</a>
</div><!-- /header -->

<div data-role="content" data-theme="E">
<table>
<tr>
<td valign="top">
<p>This site is about chile peppers and my fascination in all their colours and shapes. I'm a hobby grower, living with my family in a flat in the central part of Stockholm, Sweden. So space is limited and the growing season is fairly short. I have therefore put together some <a href="growing.php" rel="external" >growing tips</a>.</p>
<p>Please visit my <a href="peppers.php" rel="external">Chile Pepper Database</a> to explore the pictures I have taken during the years.</p>
<p>Occasionally, I do some blogging on <a href="http://chilesinstockholm.blogspot.com"  rel="external">chilesinstockholm.blogspot.com</a>.</p>
<h4>Enjoy the wonderful world of chile peppers!</h4>
</td>
<td><!--- Randompicture --->
<?php
$servername = "mysql-server-name";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = NULL;
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$qry = "select id from randompicture where category=\"peppers\" order by id;";
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$links[] = $row['id'];
		}
	  	srand ((double) microtime() * 1000000);
	  	$random_number = rand(0,count($links)-1);

		$qry = "select link, ref from randompicture where id=\"" . ($links[$random_number]) . "\";";
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$piclink = $row['link'];
			$ref = $row['ref'];
		}
		echo "<img src=\".." . $piclink . "\">";
	
		$qry = "select commonname from varieties where varietyid=\"" . $ref . "\";";
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->fetchAll();

		while($row = array_shift($result)) {
			$commonname = $row['commonname'];
		}
		echo "<a href=\"peppers.php?action=variety&id=" . $ref . "\"><br><font size=\"-1\">" . $commonname . "</a></font>";

		} catch(PDOException $e) {
		    echo "Error: " . $e->getMessage();
		}
	$conn = NULL;
?>
</td>
</tr>
</table>
</div><!-- /content -->
<div data-role="footer" data-theme="E">

<!-- Webring text starts here -->
  <div align="center"> 
    <center>
      <font size="-1"></font> 
      
	  <table width="100%">
	  <tr>
	  <td width="150"></td>
	  <td width="600"><table border="1" align="center" cellpadding="5"cellspacing="0" bgcolor="#FFFF99">
        <tr> 
          <td align="center" width="127"> <a Target="_top" href="http://www.ringoffire.net/" rel="external"> 
            <img src="http://www.ringoffire.net/images/firering.jpg" width="100" height="150" alt="Visit The Ring of Fire Home Page" border="0"><br>
            </a><font size="-1">A service of<br>
            <a Target="_top" href="http://www.netrelief.com" rel="external">netRelief, Inc.</a></font> 
          </td>
          <td width="444"><p align="center"> <font face="Verdana" size="2"><strong> 
              This site is a member of <font color="#800000"> <a
Target="_top" href="http://www.ringoffire.net/" rel="external">Ring Of Fire </a><br>
              </font></strong>A linked list of Chile websites</FONT></p>
            <p align="center"> <a Target="_top" href="http://www.ringoffire.net/next.asp?id=22" rel="external"><font size="-1">Next</font></a><font size="-1"> 
              - <a Target="_top" href="http://www.ringoffire.net/skip.asp?id=22" rel="external">Skip 
              Next</a> - <a Target="_top" href="http://www.ringoffire.net/next5.asp?id=22" rel="external">Next 
              5</a> - <a Target="_top"
 href="http://www.ringoffire.net/prev.asp?id=22" rel="external">Prev</a> - <a Target="_top"
 href="http://www.ringoffire.net/sprev.asp?id=22" rel="external">Skip Prev</a> - <a Target="_top"
 href="http://www.ringoffire.net/random.asp?id=22" rel="external">Random Site</a></font></p>
            <p align="center"><font size="-1"><a Target="_top"
 href="http://www.ringoffire.net/join.asp" rel="external">Join the ring</a> or <a
Target="_top" href="http://www.ringoffire.net/list.asp" rel="external">browse</a> a complete 
              <a
Target="_top" href="http://www.ringoffire.net/list.asp" rel="external">list</a> of <strong> <font
color="#800000">Ring Of Fire </font></strong> members</font></p>
            <p align="center"><font size="-1">If you discover problems with any 
              of <a Target="_top" href="http://www.ringoffire.net/" rel="external">Ring Of Fire 
              </a> sites,<br>
              please notify the <a href="mailto:ringmaster@ringoffire.net ">Ringmaster</a> 
              </font></td>
        </tr>
      </table>
	  </td>
	    <td width="150" align="right" valign="bottom"></td>
	  </tr>
	  </table>
    </font> 
  </center>
  </div>
  <!-- Webring text ends here -->

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
