<?
session_start();
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");

function AddLogUnApprove($get_idcard,$get_siteid){
	
	global $db_name;
	$sql_log = "INSERT INTO tbl_unapprove_log SET idcard='$get_idcard',siteid='$get_siteid', staff_unapprove='".$_SESSION[session_staffid]."'";
	$result_log = mysql_db_query($db_name,$sql_log);
	
}

function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_name,$key_surname,$key_idcard;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&displaytype=people".$kwd."\"><u><font color=\"black\">หน้าแรก</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&displaytype=people". $kwd."\"><u><font color=\"black\">หน้าสุดท้าย</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&displaytype=people". $kwd."\"><u><font color=\"black\">แสดงทั้งหมด</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">ส่งออกรูปแบบ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">จำนวนทั้งหมด <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;หน้า&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}

function ShowUser($get_ticket){
		global $db_name;
		$sql = "SELECT
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
tbl_assign_sub
Inner Join keystaff ON tbl_assign_sub.staffid = keystaff.staffid
WHERE
tbl_assign_sub.ticketid =  '$get_ticket'";
		$result =mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname] $rs[staffsurname]";
}

$arr_approve = array("0"=>"กำลังดำเนินการ","1"=>"รอตรวจสอบข้อมูล","2"=>"ผ่านการตรวจสอบข้อมูล");

if($_SERVER['REQUEST_METHOD'] == "POST"){
		if($Action == "SAVE"){
				if(count($chk) > 0){
					foreach($chk as $k => $v){
						
							$sql_update = "UPDATE tbl_assign_key SET approve='0' WHERE idcard='$v' AND nonactive='0'";
							$result_update = mysql_db_query(DB_USERENTRY,$sql_update);
							AddLogUnApprove($v,$arr_siteid[$k]);
							
					}
				}
					if($result_update){
						echo "<script>alert('บันทึกการปลดรับรองข้อมูลเรียบร้อยแล้ว'); location.href='?key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard';</script>";	
					}else{
							echo "<script>location.href='?key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard';</script>";	
					}
					
		}
}
?>

<html>
<head>
<title>เครื่องมือในการปลดสถานะการรับรองข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>
<style type="text/css">
.page {
	font						: 9px tahoma;
	font-weight			: bold; 	
	color					: #0280D5;	
	padding				: 1px 3px 1px 3px;
}	

.pagelink {
	font						: 9px tahoma;
	font-weight			: bold; 
	color					: #000000;
	text-decoration	: underline;
	padding				: 1px 3px 1px 3px;
}
.go {
	BORDER: #59990e 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 105%; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #6eab26 repeat-x 0px -90px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 1.77em
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #3f8e00 1px solid; 
	BACKGROUND: url(../../application/hr3/hr_report/images/hdr_bg.png) #63a218 repeat-x 0px -170px; 
}
.q {
	BORDER-RIGHT: #5595CC 1px solid; 
	PADDING-RIGHT: 0.7em; 
	BORDER-TOP: #5595CC 1px solid; 
	PADDING-LEFT: 0.7em; 
	FONT-WEIGHT: normal; FONT-SIZE: 105%; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	MARGIN: 0px 0.38em 0px 0px; 
	BORDER-LEFT: #5595CC 1px solid; 
	WIDTH: 300px; 
	PADDING-TOP: 0.29em; 
	BORDER-BOTTOM: #5595CC 1px solid; 
	HEIGHT: 1.39em

}
.tabberlive .tabbertab {
	background-color:#FFFFFF;
  height:200px;
}
</style>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><form name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="4" align="left" bgcolor="#A3B2CC"><strong><img src="images/document_view.gif" width="24" height="24">ค้นหาบุคลากรเพื่อปลดสถานะการรับรองข้อมูล</strong></td>
              </tr>
            <tr>
              <td width="13%" align="right" bgcolor="#A3B2CC"><strong>ชื่อ :</strong></td>
              <td width="20%" align="left" bgcolor="#A3B2CC"><label>
                <input name="key_name" type="text" id="key_name" size="25" value="<?=$key_name?>">
              </label></td>
              <td width="8%" align="right" bgcolor="#A3B2CC"><strong>นามสกุล :</strong></td>
              <td width="59%" align="left" bgcolor="#A3B2CC"><label>
                <input name="key_surname" type="text" id="key_surname" size="25" value="<?=$key_surname?>">
              </label></td>
            </tr>
            <tr>
              <td width="13%" align="right" bgcolor="#A3B2CC"><strong>รหัสบัตรประชาชน :</strong></td>
              <td align="left" bgcolor="#A3B2CC"><label>
                <input name="key_idcard" type="text" id="key_idcard" size="25" value="<?=$key_idcard?>">
              </label></td>
              <td colspan="2" align="left" bgcolor="#A3B2CC"><label>
                <input type="submit" name="button" id="button" value="ค้นหา"> 
                <input type="reset" name="button2" id="button2" value="ล้างข้อมูล">
              </label></td>
              </tr>
            <tr>
              <td colspan="4" align="left" bgcolor="#A3B2CC">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center"><form name="form2" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="6" align="left" bgcolor="#A3B2CC"><strong>ผลการค้นหาเพื่อปลดสถานะการรับรองข้อมูล</strong></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
              <td width="15%" align="center" bgcolor="#A3B2CC"><strong>รหัสบัตร</strong></td>
              <td width="16%" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="23%" align="center" bgcolor="#A3B2CC"><strong>พนักงานที่คีย์ข้อมูล</strong></td>
              <td width="21%" align="center" bgcolor="#A3B2CC"><strong>สถานะการรับรอง</strong></td>
              <td width="21%" align="center" bgcolor="#A3B2CC"><strong>คลิ๊กเพื่อปลดสถานะ</strong></td>
            </tr>
            <?
			
				$page 	= (!isset($page) || $page <= 0) ? 1 : $page ; 
				$e		= (!isset($e) || $e == 0) ? 20 : $e ;
				$i			= (!isset($page) || ($page == 1)) ?  0 : ($page - 1) * $e ; 
			
            	if($key_name != ""){ $conv .= " AND fullname LIKE '%$key_name%'";}
				if($key_surname != ""){ $conv .= " AND fullname LIKE '%$key_surname%'";}
				if($key_idcard != ""){ $conv .= " AND idcard LIKE '$key_idcard'";}
				$sql_main = "SELECT * FROM tbl_assign_key WHERE nonactive='0' AND approve='2' $conv";
		
		$xresult = mysql_query($sql_main);
		$all= @mysql_num_rows($xresult);
		$allpage	= ceil($all / $e);
		$sumpage 	= (($i + $e) >= $all) ? $all : ($i + $e) ;
		$xpage=$allpage +1;
		
	if($page <= $allpage){
			$sql_main .= " LIMIT $i, $e";
	}else if($page == $xpage){
		$i=0;
			$sql_main .= " ";
	}else{
			$sql_main .= " LIMIT $i, $e";
	}

		$result_main = mysql_db_query(DB_USERENTRY,$sql_main);
		$num_row = mysql_num_rows($result_main);
		$search_sql = $sql_main ; 	
		if($num_row > 0){
			$disb = " ";
		while($rs = mysql_fetch_assoc($result_main)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		
			
			?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$i?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="left"><?=$rs[fullname]?></td>
              <td align="left"><?=ShowUser($rs[ticketid]);?></td>
              <td align="center"><?=$arr_approve[$rs[approve]]?></td>
              <td align="center"><label>
                <input type="checkbox" name="chk[]" value="<?=$rs[idcard]?>">
                <input type="hidden" name="arr_siteid[]" value="<?=$rs[siteid]?>">
              </label></td>
            </tr>
            <?
				}//end while(){
				}else{
					echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center'>บุคลากรที่ค้นหาได้ทำการปลดรับร้องแล้ว</td></tr>";	
					$disb = " disabled";
				}
			?>
            <tr>
              <td colspan="6" align="center" bgcolor="#FFFFFF">
			  	<? $sqlencode = urlencode($search_sql)  ; ?>	
				<?=devidepage($allpage, $keyword ,$sqlencode )?>
                </td>
              </tr>
            <tr>
              <td colspan="5" align="center" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="center" bgcolor="#FFFFFF"><label>
              <input type="hidden" name="Action" value="SAVE">
              <input type="hidden" name="key_name" value="<?=$key_name?>">
              <input type="hidden" name="key_surname" value="<?=$key_surname?>">
              <input type="hidden" name="key_idcard" value="<?=$key_idcard?>">
                <input type="submit" name="button3" id="button3" value="ปลดสถานะการรับรอง" <?=$disb?>>
              </label></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</BODY>
</HTML>
