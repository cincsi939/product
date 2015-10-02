<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title>Untitled Document</title>
</head>
<link type="text/css" href="template_report.css" rel="stylesheet" />
<body style="background-color:#FFF; margin-left:0px; margin-top:0px; margin-right:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="labelFont"><strong>Map Service Sample</strong></td>
  </tr>

  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;" >
    	<tr>
        	<td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td valign="top" >
                ไม่กำหนด width, height, focus, zoom
                <br />
                URL:map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&
                <iframe src="map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0" width="500"  height="400" frameborder="0"></iframe>
                </td>
                <td valign="top" >
                กำหนด  width, height, focus, zoom
                <br />
                URL:map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=9&width=400&height=250
                <iframe src="map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=9&width=400&height=250" width="500"  height="400" frameborder="0"></iframe>
                </td>
              </tr>
              <tr>
                <td valign="top" >
                กำหนด focus, zoom
                <br />
                URL:map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=9
                <iframe src="map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=9" width="500"  height="400" frameborder="0"></iframe>
                </td>
                <td valign="top">
                กำหนด  width, height, focus, zoom, ไม่ให้แสดงสัญลักษณ์แสดงความหมายข้อมูล
                <br />
                URL:map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=9&width=400&height=250&emblem=n" width="500"  height="400
                <iframe src="map_service.php?categories=10000000|11000000|12000000|13000000&dataset=10|15|5|0&focus=13.802553,100.800344&zoom=7&height=365&emblem=n" width="500"  height="400" frameborder="0"></iframe>
                </td>
              </tr>
    </table>     
    </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  
 
  
