<? 
session_start();
session_destroy();

include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>เข้าสู่ระบบฐานข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="common/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style5 {
	color: #FF0000;
	font-weight: bold;
}
.style7 {	color: #FF0000;
	font-weight: bold;
	font-size: 16px;
}
.style12 {font-size: 16}
-->
</style>
<script type="text/javascript">
     var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}
    
function refreshproductList() {
   var provid = document.getElementById("provid").value;
    if(provid == "" ) {
        clearproductList();
        return;
    }
    var url = "ajax_kp7.php?Tid=" + provid;
    createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleStateChange;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}
    
function handleStateChange() {
    if(xmlHttp.readyState == 4) {
        if(xmlHttp.status == 200) {
            updateproductList();
        }
    }
}

function updateproductList() {
    clearproductList();
    var secname = document.getElementById("secname");
    var results = xmlHttp.responseText;
    var option = null;
    p=results.split(",");
    for (var i = 0; i < p.length; i++){
	if(p[i] > ""){
			x = p[i].split("::");
           option = document.createElement("option");
		   option.setAttribute("value",x[1]);
           option.appendChild(document.createTextNode(x[0]));
           secname.appendChild(option);
	}
    }
}

function clearproductList() {
    var secname = document.getElementById("secname");
    while(secname.childNodes.length > 0) {
              secname.removeChild(secname.childNodes[0]);
    }
}

</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" height="420" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
  <tr>
    <td align="center" class="headerTB"  >	</td>
  </tr>
  <tr>
    <td width="738" align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><img src="../../../images_sys/cmss64.png" width="64" height="64"  ><br>
กรุณาเลือกเขตพื้นที่การศึกษาเพื่อเข้าสู่ระบบ</td>
      </tr>
    </table>
      <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="34%" valign="top" class="13_W"><form name="form1" method="post" action="redirect_eservice.php">
          <table width="100%" border="0" cellspacing="2" cellpadding="3">

            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="provid" id="provid" onChange="refreshproductList();">
                <option value="0">กรุณาเลือกจังหวัด</option>
                <?
#  				 where  area_id != 2   ภาคใต้				
			$sql = " SELECT  distinct  provid , name_proth   FROM  eduarea     order by name_proth  " ; 
		 	$query_area = mysql_query( $sql  ) ;				

			while($rs_area = mysql_fetch_assoc($query_area)){
		 	?>
                <option value="<?=$rs_area[provid]?>">
                <?=$rs_area[name_proth]?>
                </option>
                <? } ?>
              </select>                &nbsp;
              <select id="secname" name="secname">
                  </select>                </td>
              </tr>
            <tr>
              <td align="center"><input type="submit" name="Submit" value="      ตกลง     "></td>
              </tr>
          </table>
        </form></td>
      </tr>
    </table>
	  <br>
	  <table width="100%" border="0">
        <tr>
          <td align="center" valign="baseline"><strong>
            <? if  (3 == 5){   ### สำหรับโปรแกรมเมอร์ ?>
            ประกาศ</strong><br>
            ปิดสำรองข้อมูล สพท.ในเขตภาคใต้ <br>
            ในวันเสาร์ที่ 1 ธันวาคม 2550 เวลา 09.00 - 18.00 น. 
            
            <br>
            <br>
หากต้องการปิด / ระบบ  ต้องทำ 3 ไฟล์ 
		  index_dataentry.php<br>
index_kp7.php<br>
index_register.php
<? } # END  if  (3!= 5){   ### สำหรับโปรแกรมเมอร์ ?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
