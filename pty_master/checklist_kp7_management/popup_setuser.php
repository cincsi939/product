<?
session_start();
include("checklist.inc.php");

if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>กำหนดพนักงานตรวจ</title>
<script src="../../common/jquery.js"></script>
<script >
function check_all(context, controller,status){	
	$("#"+context).find("input[@type$='checkbox']").each(function(){
				if(this.name!=controller){	
				this.checked = status;
				}
	});
}
function returnval(context, controller){
	var xobj=new Object;
	var strname="";
		$("#"+context).find("input[@type$='checkbox']").each(function(){
				if(this.name!=controller){													  
				if(this.checked ){
					if(strname!=""){strname+=",";}					
				     strname+= this.value;
				}
				}
	}); 
		
		xobj.strname=strname;
		window.returnValue=xobj;
		window.close();
}
</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #000;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="441" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="441" bgcolor="#666666"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#E4E4E4"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbl_data">
            <tr>
              <td width="11%" height="30" align="center" bgcolor="#333366"><strong style="color:#FFF">ลำดับ</strong></td>
              <td width="6%" align="center" bgcolor="#333366">             
                  <input type="checkbox" name="checkall" id="checkall" onclick="check_all('tbl_data','checkall',this.checked)" />                
              </td>
              <td width="83%" align="center" bgcolor="#333366"><strong style="color:#FFF"> ชื่อ-นามสกุล</strong></td>
            </tr>             
            <?
            	$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES' ORDER BY staffname ASC";
				//echo $sql_staff;
				$result_staff = mysql_db_query($dbcallcenter_entry,$sql_staff);
				$i=0;
				$bg="bgcolor='#FFFFFF'";
				while($rs_sf = mysql_fetch_assoc($result_staff)){
	$i++;
	if($bg=="bgcolor='#EFEFEF'"){$bg="bgcolor='#FFFFFF'";}else{$bg="bgcolor='#EFEFEF'";}
    $arr_staff=$_SESSION[def_staff];
	if($arr_staff[$rs_sf[staffid]]=="ok") {$chk=" checked ";} 
			 echo"<tr $bg>
              <td align=\"center\">$i</td>
              <td align=\"center\"><input  $chk type=\"checkbox\" name=\"xid\" id=\"checkall\" value=\"$rs_sf[staffid]\"  strname=\"$rs_sf[staffname] $rs_sf[staffsurname]\"/></td>
              <td>&nbsp;$rs_sf[staffname] $rs_sf[staffsurname]</td>
            </tr>";
            $chk="";
			}//end while($rs_sf = mysql_fetch_assoc($result_staff)){		
			?>
            
        <tr>
          <td colspan="3" align="center"><label>
            <input type="button" name="button" id="button" value="ตกลง"  style="font-size:12px;width:auto;height:auto" onclick="returnval('tbl_data','checkall');"/>
          </label>
            <label>
              <input type="button" name="button2" id="button2" value="ยกเลิก" style="font-size:12px;width:auto;height:auto" onclick="window.close()" />
            </label></td>
        </tr>   
            
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
