<?
set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc.php') ;
$getdata = explode("::",$sname) ;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Saraly wizard</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td height="446" valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="370" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="96%" height="65" class="table2"><div  class="header_font">สรุปการตรวจสอบข้อมูลของ &nbsp;<?=$getdata[0]?>&nbsp;&nbsp;<?=$getdata[1]?><br />
            </div>
                .</td>
            <td width="4%" class="table2">&nbsp;</td>
          </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%">&nbsp;</td>
              <td width="85%"><?
			  
			  	if($action=="result"){

				$dbsite = STR_PREFIX_DB.trim($getdata[2]) ;
				$getdata[1] = trim($getdata[1]);
				chdata($getdata[1],$dbsite,true);

				}
			  ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="40" align="center" class="table_button">&nbsp;&nbsp;&nbsp;
              <input name="button2"  type="button" class="bt" value="ปิด"  onclick="window.close();"/></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
