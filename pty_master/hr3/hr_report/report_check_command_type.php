<?php
include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
require_once("check_lvsalary.php");

$site = '7001';
$dbname = STR_PREFIX_DB.$site;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานผลการตรวจสอบประเภทคำสั่ง</title>
<style type="text/css">
<!--
.body,td,th{
font-size: 12px;}
-->
</style>
</head>
<body>
<?php
$sql_name = "SELECT * FROM eduarea WHERE secid = '$site' ";
$query_name = mysql_db_query('edubkk_master',$sql_name);
$rows_name = mysql_fetch_array($query_name);
echo $rows_name['secname'];
?>
<table width="80%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td>
	
	
<?php
	 	$strSQL = "SELECT * FROM view_general ";
		
		$rsConn = mysql_db_query($dbname,$strSQL);
		$all_row = mysql_num_rows($rsConn);
		$board_row_per_page = 20;
		$total_page = ceil($all_row/$board_row_per_page);
		$page = ($_GET['page'])?$_GET['page']:1;
		$page = ($page > $total_page)?$total_page:$page;
		$page = ($page <= 0)?1:$page;
		$limit_start = ($page==1)?0:(($page*$board_row_per_page)-$board_row_per_page);
		$limit_end = $board_row_per_page;
		if($View==''){
			$strSQL .= " LIMIT ".$limit_start.", ".$limit_end;
			$num = $limit_start ;
		}
		
		if(isset($cols)&&isset($sort)){
			$solink="&cols=$cols&sort=$sort";
		}
		
		
		
		$prev_page = $page - 1; $prev_page = ($prev_page <= 1)?1:$prev_page;
		$prev = "self.location='".$PHP_SELF."?page=$prev_page$link$solink'";
		$next_page = $page + 1; $next_page = ($next_page >= $total_page)?$total_page:$next_page;
		$next = "self.location='".$PHP_SELF."?page=$next_page$link$solink'";
		
		$prev_Tenpage=$page-$board_row_per_page;$prev_Tenpage=($prev_Tenpage<= 1)?1:$prev_Tenpage;
		$prevTen = "self.location='".$PHP_SELF."?page=$prev_Tenpage$link$solink'";
		$nextTenPage=$page+$board_row_per_page;$next_TenPage=($next_TenPage >= $total_page)?$total_page:$next_TenPage;
		$nextTen = "self.location='".$PHP_SELF."?page=$nextTenPage$link$solink'";
	?>
	<? if($View==""){$Klink="?View=All"; $CSh="ข้อมูลทั้งหมด"; $Klink2="?".$text_search."&View=";}else{$Klink="?".$text_search."&View=";$CSh="ข้อมูล ".$board_row_per_page." รายการล่าสุด";$Klink2="?View=All";}?>
	ทั้งหมด <b> <font color="#CC0000">
	<?=number_format($all_row);?>
	</font> </b> รายการ
	<? if($View==""){?>
	แบ่งเป็น <b><font color="#0033CC">
	<?=number_format($total_page);?>
	</font></b> หน้า
	<? }?>
	&nbsp;&nbsp;<a href="<?=$Klink?>"><img src="img/Search-Add.gif" alt="<?=$CSh?>" width="16" height="16" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <? if($View==''){?>
			<?  if($page==1){?>
			<img src="img/page_div_icon/xFirst.gif" />
			<? }else{?>
			<img src="img/page_div_icon/First.gif" align="absmiddle" border="0" width="10" height="12"  onclick="<?=$prevTen;?>" onMouseOver="style.cursor='hand';"/>
			<? }?>
	&nbsp;
	<?  if($page==1){?>
	<img src="img/page_div_icon/xPrevious.gif" />
	<? }else{?>
	<img src="img/page_div_icon/Previous.gif" align="absmiddle" border="0" width="7" height="12"  onclick="<?=$prev;?>" onMouseOver="style.cursor='hand';"/>
	<? }?>
	<?php
		$board_link_num = $board_row_per_page;
	$ii = 1;
	if ( $board_link_num > $total_page ){
			$ii = (($page-5)>=1)?$page-5:1;
			if($ii==1){
				if($page<=5){
					$loop_page =($total_page<10)?$total_page:10;
				}else{
					$loop_page = (($page-5) <= $total_page)?(($page+5>$total_page)?$total_page:$page+5):$total_page;
				}
			}else if($page<=5){
				$loop_page =($total_page<10)?$total_page:10;
			}else{
				$loop_page = (($page-5) <= $total_page)?$page+5:$total_page;
				$loop_page = ($loop_page <= $total_page)?$loop_page:$total_page;
			}
	} else {
		$bx = ceil(($board_link_num) / 2);
		$pp = $page - $bx;
		$pn = $page + $bx;
		$loop_page = $pn;
		$ii = $pp;
		if ( $total_page <= $loop_page ) {
			$loop_page = $total_page;
			$ii = $loop_page - ($board_link_num -1);
			
		}
		if ( $ii < 1 ) {
			$ii = 1;
			$loop_page = $ii + ($board_link_num -1);
		}
	}
	
	
	for($i=$ii;$i<=$loop_page;$i++){
		if ( $i==$page || !$page ) {
			$txt = "<b>$i</b>";
		} else {
			$txt = $i;
	
		}
	?>
	<a href="<?=$PHP_SELF;?>?Sort=<?=$Sort;?>&page=<?=$i;?>"><?=$txt;?>
	</a>
	<?
	} # for
	?>
	<? if($page==$loop_page){?>
	<img src="img/page_div_icon/xNext.gif" />
	<? }else{?>
	<img src="img/page_div_icon/Next.gif" align="absmiddle" border="0" width="7" height="12" onClick="<?=$next;?>" onMouseOver="style.cursor='hand';"/>
	<? }?>
	&nbsp;
	<? if($page==$loop_page){?>
	<img src="img/page_div_icon/xLast.gif" />

	<? }else{?>
	<img src="img/page_div_icon/Last.gif" align="absmiddle" border="0" width="10" height="12" onClick="<?=$nextTen;?>" onMouseOver="style.cursor='hand';"/>
	<? } }#End View=
		?>	
	
	</td>
  </tr>
</table>

<table width="80%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;" bordercolor="#CCCCCC">
  <tr>
    <td width="23%" rowspan="2" bgcolor="#EEEEEE"><div align="center">เลขบัตรประชาชน</div></td>
    <td width="25%" rowspan="2" bgcolor="#EEEEEE"><div align="center"><strong>ชื่อ นามสกุล</strong></div></td>
    <td colspan="2" bgcolor="#EEEEEE"><div align="center"><strong>คำสั่งเลื่อนขั้นเงินเดือน</strong></div></td>
    <td width="16%" rowspan="2" bgcolor="#EEEEEE"><div align="center"><strong>ตรวจสอบ</strong></div></td>
  </tr>
  <tr>
    <td width="18%" bgcolor="#EEEEEE"><div align="center"><strong>โดยคน</strong></div></td>
    <td width="18%" bgcolor="#EEEEEE"><div align="center"><strong>โดยระบบ</strong></div></td>
  </tr> 
<?php
$k = 1;
$rsConn = mysql_db_query($dbname,$strSQL);
while($rows = mysql_fetch_array($rsConn)){
?>  
  <tr  <?php if($k%2 == '0'){echo 'bgcolor="#F2F2F2"';} ?>>
    <td align="center"><?=$rows['CZ_ID']?></td>
    <td><?php echo $rows['prename_th'].$rows['name_th']."  ".$rows['surname_th']; ?></td>
    <td><div align="center">
	<?php
	 $sql_person_check = "SELECT runno FROM salary WHERE id = '".$rows['CZ_ID']."' AND order_type = '4' ";
	 $query_person_check = mysql_db_query($dbname,$sql_person_check);
	 $num_person_check = mysql_num_rows($query_person_check);
	 echo $num_person_check;
	?>
	</div></td>
    <td><div align="center">
	<?php
	$sql_check_profile = "SELECT * FROM log_profile_check_command_type WHERE idcard = '".$rows['CZ_ID']."' AND order_type = '4' ORDER BY profile_id DESC LIMIT 0,1 ";
	$query_check_profile = mysql_db_query("competency_system",$sql_check_profile)or die(mysql_error());
	$rows_check_profile = mysql_fetch_array($query_check_profile);
	
	$sql_system_check = "SELECT * FROM log_check_command_type WHERE profile_id = '".$rows_check_profile['profile_id']."' ";
	$query_system_check = mysql_db_query("competency_system",$sql_system_check)or die(mysql_error());
	$num_system_check = mysql_num_rows($query_system_check);
	if($num_system_check > 0){
	 echo $num_system_check;
	}else{
	 echo "-";
	} 
	
	?>
	</div></td>
    <td align="center">
	<a href="#" onClick="window.open('script_check_salary.php?idcard=<?=$rows['CZ_ID']?>&site=<?=$site?>','_blank','addres=no,toolbar=no,status=yes,scrollbars=yes,width=900,height=600');">ตรวจสอบ</a></td>
  </tr>
<?php
  $k++;
}
?>  
</table>


</body>
</html>
