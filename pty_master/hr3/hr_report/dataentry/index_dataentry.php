<? 
session_start();
session_destroy();

include ("../../../config/conndb_nonsession.inc.php")  ;

?>
<html>
<head>
<title>เข้าสู่ระบบฐานข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
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
    var url = "ajax_dataentry.php?Tid=" + provid;
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
    <td width="738" align="center" valign="top">
<!------	
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td align="center" bgcolor="#EFEFEF"><strong>ปิดระบบเพื่อสำรองข้อมูล </strong><br>
ระหว่างวันอังคาร ที่ 11 มี.ค 2551 เวลา 18.00 - วัน อังคาร ที่ 11  มี.ค 2551 เวลา 20.00 น. <br>
จึงขออภัยในความไม่สะดวกมา ณ. ที่นี้ </td>
    </tr>
  </table>
------->   
  <?

/*
$user_ip = $_SERVER["REMOTE_ADDR"] ;
if (substr($user_ip,0,8) == "192.168."){
	echo " <font color=red> สามารถเข้าได้เฉพาะใน Intra net เท่านั้น </font> ";
	$IPpermission = "allow" ; 
}else{
#	$IPpermission = "0"  ;
#	echo " <br><br> <center>ขออภัย หน้ารายงานนี้สามารถใช้ได้ในเครือข่าย Intranet เท่านั้น </center>$user_ip";
	die; 
}
*/


?>	  
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><img src="../../../images_sys/cmss64.png" width="64" height="64"  ></td>
        </tr>
        <tr>
          <td align="center">
<!--------------- 
		  <table width="400" border="0" cellpadding="2" cellspacing="0" bgcolor="#FF3366" style="border: 2 solid  #FF3366">
            <tr>
              <td bgcolor="#EAF6F7" class="login_text"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="13%" align="center" valign="middle" bgcolor="#FAC9CA"><img src="../images/tip_icon2.gif" width="40" height="38"></td>
                    <td align="center" bgcolor="#FAC9CA" ><p><strong> ประกาศปิดระบบเพื่อสำรองข้อมูล และ ตรวจสอบความถูกต้อง ของข้อมูล  
                          <br>
                          ในวัน                    <u>เสาร์ที่ 31 พ.ค. 2551 เวลา 21.00 น.</u>  ถึง <u><br>
                    วันจันทร์ที่ 2 มิ.ย. 2551 เวลา 09.00 น.</u>
                    </strong><br>
                    </p></td>
                  </tr>
              </table></td>
            </tr>
          </table>
------------->
		  
		  </td>
        </tr>
        <tr>
          <td align="center"><strong>ระบบ CMSS ปรับโครงสร้างเป็น 185 เขตพื้นที่การศึกษาแล้ว</strong> </td>
        </tr>
        <tr>
          <td align="center"><br>
กรุณาเลือกเขตพื้นที่การศึกษาเพื่อเข้าสู่ระบบ</td>
        </tr>
      </table>
	  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="34%" valign="top" class="13_W"><form name="form1" method="post" action="redirect_dataentry.php">
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
              </select>
                &nbsp;
                <select id="secname" name="secname">
                  </select></td>
              </tr>
            <tr>
              <td align="center"><input type="submit" name="Submit" value="      ตกลง     "></td>
              </tr>
          </table>
        </form></td>
      </tr>
    </table>
      <table width="98%" border="0" align="center">
        <tr>
          <td class="headerTB">สถานะการนำเข้าข้อมูล ระบบสนับสนุนการจัดการสมรรถนะบุคลากรทางการศึกษา</td>
        </tr>
        <tr>
          <td>ให้ทุกสพท. login เข้าด้วย username cmss.xxxx (รหัส สพท.ของท่าน เช่น กทม.เขต 1 ใช้ cmss.1001) และเลือกแท็บเมนู รายงาน ดังรูป </td>
        </tr>
        <tr>
          <td align="center"><img src="../../../images/cmss_tabreport.gif" width="397" height="140"></td>
        </tr>
      </table>
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
    </table> </td>
  </tr>
</table>
</body>
</html>
