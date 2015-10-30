<?
die;
set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function.inc_v1.php') ;

###  แสดงชื่อเขตพื้นที่การศึกษา
	function show_area($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname];
	}//end function show_area($get_secid){
	
###  ฟังก์ชั่นแสดงหน่วยงาน
	function show_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตรวจสอบข้อผิดพลาดการบันทึกข้อมูล</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
    <script type="text/javascript">        
        var xmlHttp;
        var completeDiv;
        var inputField;
        var nameTable;
        var nameTableBody;
		var p;
		var name=new String();

        function createXMLHttpRequest() {
            if (window.ActiveXObject) {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else if (window.XMLHttpRequest) {
                xmlHttp = new XMLHttpRequest();                
            }
        }

        function initVars() {
            inputField = document.getElementById("txtnames");            
            nameTable = document.getElementById("name_table");
            completeDiv = document.getElementById("popup");
            nameTableBody = document.getElementById("name_table_body");
        }

        function findNames() {
            initVars();
            if (inputField.value.length > 0) {
                createXMLHttpRequest();            
                var url = "CompleteData.php?names=" + inputField.value;                        
                xmlHttp.open("GET", url, true);
                xmlHttp.onreadystatechange = callback;
                xmlHttp.send(null);
            } else {
                clearNames();
            }
        }

        function callback() {
            if (xmlHttp.readyState == 4) {
                if (xmlHttp.status == 200) {
				    name =  document.getElementById("popup").innerHTML = xmlHttp.responseText;
					setNames();
                } else if (xmlHttp.status == 204){
                    clearNames();
                }
            }
        }
        
        function setNames() {         
           	p = name.split(",");  
            clearNames();
   	        var size = p.length;
            setOffsets();
            var row, cell, txtNode;
            for (var i = 0; i < size; i++) {
                var nextNode =p[i] 
                row = document.createElement("tr");
                cell = document.createElement("td");
                
                cell.onmouseout = function() {this.className='mouseOver';};
                cell.onmouseover = function() {this.className='mouseOut';};
                cell.setAttribute("bgcolor", "#FFFAFA");
                cell.setAttribute("border", "0");
                cell.onclick = function() { populateName(this); } ;                             

                txtNode = document.createTextNode(nextNode);
                cell.appendChild(txtNode);
                row.appendChild(cell);
                nameTableBody.appendChild(row);
				
            }
        }

        function setOffsets() {
            var end = inputField.offsetWidth;
            var left = calculateOffsetLeft(inputField);
            var top = calculateOffsetTop(inputField) + inputField.offsetHeight;

            nameTable.style.border = "black 1px solid";
            nameTable.style.left = left + "px";
            nameTable.style.top = top + "px";
            nameTable.style.width = end + "px";
        }
        
        function calculateOffsetLeft(field) {
          return calculateOffset(field, "offsetLeft");
        }

        function calculateOffsetTop(field) {
          return calculateOffset(field, "offsetTop");
        }

        function calculateOffset(field, attr) {
          var offset = 0;
          while(field) {
            offset += field[attr]; 
            field = field.offsetParent;
          }
          return offset;
        }

        function populateName(cell) {
            inputField.value = cell.firstChild.nodeValue;
            clearNames();
        }

        function clearNames() {
            var ind = nameTableBody.childNodes.length;
            for (var i = ind - 1; i >= 0 ; i--) {
                 nameTableBody.removeChild(nameTableBody.childNodes[i]);
            }
                 completeDiv.style.border = "none";
        }
    </script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#CCCCCC"><strong>รายงานบุคลากรที่ต้องแก้ไขข้อมูลเพิ่มเติม</strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>รหัสบัตรประชาชน</strong></td>
        <td width="20%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ-นามสกุล</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>โรงเรียน</strong></td>
        <td width="28%" align="center" bgcolor="#CCCCCC"><strong>บรรทัดที่ต้องแก้ไข</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>สถานะการแก้ไข</strong></td>
      </tr>
      <?
      	$sql = "SELECT id,idcard,siteid,prename_th,name_th,surname_th,position_now,schoolid FROM general WHERE id IN('3670700544444','3540400758636','3650500022860','3550700021205','3670300318552','3659900268015','3660200020942','3660100128318','3640100387445','3650800257919','3659900506153','3640100663736','3650100214451','3650200131817','3650500516889','3640600020435','3659900668927','3659900087118','3650500500362','3100501014296','3650100435121','3659900736213','5650600016698','3650101046960','3650500216796','3640600142735','3650800158953','3659900832026','3650800116720','3650100011810','3650800437119','3659900365827','3659900060554','3659900752481','3650500193796','3650100893138','3650100893090','3650200353194','3660400340142','3539900149912','5650890000803','3670400022264','3520101529317','3650800283766','3650500415012','3659900409361','3659900093568','3650700146953','3650500184100','3650800692666','3650500159792','3659900129791','3650100893120','3650500416442','3659900538519','3650800802801','3650800413821','3650100694089','3650900015861','3650100374335','3670100042367','3670400512156','3650600229636','3650600490458','5650590003670','3650600456331','3529900319681','3650900025718','3650500095948','3560200432931','3659900422308','3640700518907','3650500177561','3650100189040','3650100426092','3650100944891','3650800839411','3650700223621','3102001445834','3650900565992','3659900394169','3560100434282','3650800297465','3659900117904','3650900017821','3650100377407','3650101091167','3101702041127','3650600451916','3501900254514','3650800845314','3659900192639','3650800847155','3650900522410','3659900460781','3659900341871','3659900715691','3650500040248','5650800008532','3650800158350','3321000414347','3650400224614','3650500540411','3650100704912','3330800733586','3650800824392','3650800108964','3650500415624','3650100589218','3420300367989','3650101260457','3650101241860')";
		$result = mysql_db_query("cmss_6502",$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";} //<a href='login_data.php?xname_th=$xrs[name_th]&xsurname_th=$xrs[surname_th]&xidcard=$xrs[idcard]&action=login&xsiteid=$xrs[siteid]'
		$sql_log = "SELECT count(*) as num1 FROM tbl_log_edit WHERE idcard='$rs[idcard]'";
		$result_log = mysql_db_query("cmss_6502",$sql_log);
		$rs_log = mysql_fetch_assoc($result_log);
		
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? if($rs_log[num1] > 0){ echo "$rs[idcard]";}else{?><a href="login_data1.php?xname_th=<?=$rs[name_th]?>&xsurname_th=<?=$rs[surname_th]?>&xidcard=<?=$rs[idcard]?>&action=login&xsiteid=<?=$rs[siteid]?>"><?=$rs[idcard]?></a><? } ?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><?=show_school($rs[schoolid]);?></td>
        <td align="left">
        <?
        	$strsql = "SELECT * FROM salary WHERE id='$rs[idcard]' and (order_type='2' or order_type='7') order by runno ASC";
			$result1 = mysql_db_query("cmss_6502",$strsql);
			while($rs1 = mysql_fetch_assoc($result1)){
				echo "บรรทัดที่: $rs1[runno]  วันที่: $rs1[date]   ตำแหน่ง: $rs1[position]   เิงินเดือน:  $rs1[salary] <br>";	
			}
		?>
        
        </td>
        <td align="left">
        <?
        	if($rs_log[num1] > 0){
				echo "แก้ไขแล้ว";	
			}else{
				echo "";	
			}
		?>
        </td>
      </tr>
      <?
		}
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
