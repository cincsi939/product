<?
session_start();
set_time_limit(0);
			include("../../../config/conndb_nonsession.inc.php");
			include("TableGear.php");

$table = new TableGear(array(
  
//  This first line is your database configuration.
//  You MUST include this for TableGear to work!
//  Replace all braces <> with your database info.

"database"			=> array("username" => "$username",
	                         "password" => "$password",
	                         "database" => "$dbnamemaster",
	                         "table" => "log_pdf_check"),
	"sortable"			=> "all",
	//"editable"			=> "all",
	"editable"			=> array("idcard",
"prename_th",
"name_th",
"surname_th",
"birthday",
"begindate",
"schoolname",
"position_now",
"status_file",
"comment_file",
"page_pdf",
"sent_scan"),	  

//  Below are example options that you may want to include.
//  Uncomment lines and adjust to your needs.
//  This should get you off to a good start, but many other features exist.
//  For help with more advanced options, see the docs:
//  http://www.andrewplummer.com/code/tablegear/

//  Columns that use selects instead of inputs.
 //"selects"       => array("status_file" => "increment[min=1,range=5]")
	"selects" => array("status_file" => array("YES" => "YES", "NO" => "NO"),"sent_scan" => array( "ยังไม่ได้ส่งไฟล์" => "0","ส่งไฟล์สแกนแล้ว" => "1")),
  
//  Columns that use textareas instead of inputs.
  "textareas"			=> array("comment_file"),

//  Data formats. Formats include "date", "currency", "numeric", and "memory".
//  "formatting"		=> array("date" => "date", "price" => "currency[prefix=$]", "memory" => "memory[auto]"),

//  Formats to accept as input from users. This can be a bit more complicated.
//  The "date" input format for example makes educated guesses about user input dates and standardizes them to
//  a MySQL format. Numeric will grab a full number from user input, for example 12345 from $12,345.
//	"inputFormat"		=> array("date" => "date", "price" => "numeric"),

//  Validates user input and won't allow anything that doesn't validate.
//  This example will only accept a string that ends in .jpg
//  "validate" => array("filename" => "/\.jpg/")
	
	
//  Uncomment this if you want the user to be able to delete rows.
  "allowDelete" => true,
  "deleteRowLabel" => array("tag" => "img", "attrib" => array("src" => "images/delete.gif", "alt" => "Delete Row")),
	  	
//  Uncomment this if you want to use pagination in your table. Very useful for large data sets.
/*  "pagination" => array(
    "perPage" => 30,
    "prev" => "Previous",
    "next" => "Next",
    "linkCount" => 4,
  )  
 */ 
	  
));



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>DATA EDITOR</title>
	<script type="text/javascript" src="javascripts/Mootools1.2.1.Core.js"></script>
	<script type="text/javascript" src="javascripts/TableGear.js"></script>
	<link type="text/css" rel="stylesheet" href="stylesheets/TableGear.css">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body>
  

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  height="50px" align="left" bgcolor="#0066CC" style="background-repeat:no-repeat; background-position:left; color: #FFF;"><h1>ระบบตรวจสอบเอกสาร</h1></td>
  </tr>
</table>
<?= $table->getTable(); ?>
<script type="text/javascript">
    new TableGear("tgTable");
  </script>
</body>
</html>