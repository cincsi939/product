<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Wised Wisesvatcharajaren
 * @created  25/07/2558
 * @access  public
 */
 
 $arr_month = array('01'=>'���Ҥ�','02'=>'����Ҿѹ��','03'=>'�չҤ�','04'=>'����¹','05'=>'����Ҥ�','06'=>'�Զع�¹','07'=>'�á�Ҥ�','08'=>'�ԧ�Ҥ�','09'=>'�ѹ��¹','10'=>'���Ҥ�','11'=>'��Ȩԡ�¹','12'=>'�ѹ�Ҥ�');
 $arr_year = array('2558'=>'2558','2559'=>'2559');
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>��§ҹ����ԡ�����Թ�ش˹ع���á�Դ</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../js/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="../js/fixtable/js/jquery.freezeheader.js"></script>
<script>
$(document).ready(function(){
	//$(".table2").freezeHeader({ 'height': '360px' });
});

function process(startdate,enddate){
	//alert(startdate+' || '+enddate);
	var arrStart = startdate.split('_');
	var arrEnd = enddate.split('_');
	
	var start_y = arrStart[0];
	var start_m = arrStart[1];
	
	var end_y = arrEnd[0];
	var end_m = arrEnd[1];
	
	window.location.href = "?frame=1&start_y="+start_y+"&start_m="+start_m+"&end_y="+end_y+"&end_m="+end_m;
}
</script>
</head>
<style>
table.table1, table.table2 {
    border-collapse: collapse;
}

table.table1, table.table1 th, table.table1 td{
	border: 0px solid black;
	font-size:18px;
}

table.table2, table.table2 th{
	border: 1px solid #CCC;
	font-size:13px;
	background-color:#2b5cd8;
	color:#FFF;
	height:30px;
}

table.table2 td{
	border: 1px solid #CCC;
	font-size:13px;
	color:#000;
	text-align:left;
	padding:2px;
}

table.table2 th{
	text-align:center;
}

.border1{
	/*border: 1px solid black;*/
}
table.table2 tr:hover{
	background:#FFC;
}
</style>
<body>
<? $box_search = 'on';  include "header.php";?>
<?php
	/*$sql = " SELECT
				*
				FROM eq_child_payment  ";
	$result = mysql_query($sql) or die(mysql_error());
	while( $row = mysql_fetch_array($result) ){
		$usemoney = (int)$row['num_child']*400;
		$paymoney = mt_rand(ceil($usemoney*0.10),$usemoney);
		$percent = number_format(($paymoney*100)/$usemoney,2);
		$update = " UPDATE eq_child_payment 
					SET use_money = {$usemoney},
					 pay_money = {$paymoney},
					 percent = {$percent}
					 WHERE  runid = '".$row['runid']."' ";
		mysql_query($update) or die(mysql_error().' SQL :: '.$update);
	}
	die;*/
	if( (isset($_GET['start_m']) && $_GET['start_m'] != '') && (isset($_GET['start_y']) && $_GET['start_y'] != '') && (isset($_GET['end_m']) && $_GET['end_m'] != '') && (isset($_GET['end_y']) && $_GET['end_y'] != '')  ){
		$date1=date_create(($_GET['start_y']-543)."-".$_GET['start_m']."-01");
		$date2=date_create(($_GET['end_y']-543)."-".$_GET['end_m']."-01");
		$diff=date_diff($date1,$date2);
		if( (int)$diff->format("%a") < 30 ){
			$diff = 1;
		}else{
			$diff = ceil((int)$diff->format("%a")/30);
		}
		
		$sql = " SELECT
						SUM(num_child) AS sum_num_child,
						SUM(use_money*".$diff.") AS sum_use_money,
						SUM(pay_money*".$diff.") AS sum_pay_money
					FROM eq_child_payment 
					ORDER BY provice ASC ";
	}else{	
		$sql = " SELECT
						SUM(num_child) AS sum_num_child,
						SUM(use_money) AS sum_use_money,
						SUM(pay_money) AS sum_pay_money
					FROM eq_child_payment 
					ORDER BY provice ASC ";
	}

	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$usemoney = $row['sum_use_money'];
	$paymoney = $row['sum_pay_money'];
	$percent = ($paymoney*100)/$usemoney;
?>
<div style="width:98%; height:auto; float:left; padding:1%;">
	<div class="border1" style="width:100%; height:auto; float:left;">
    	<div style="width:50%; height:auto; float:left; padding-left:10%;">
        <table class="table1">
        	<tr>
            	<td width="400">�ӹǹ���á�Դ����鹷���¹</td>
                <td align="right"><?php echo number_format($row['sum_num_child']);?></td>
                <td>&nbsp;&nbsp;��</td>
            </tr>
            <tr>
            	<td>������ҳ������</td>
                <td align="right"><?php echo number_format($usemoney);?></td>
                <td>&nbsp;&nbsp;�ҷ</td>
            </tr>
            <tr>
            	<td>�ԡ��������</td>
                <td align="right"><?php echo number_format($paymoney);?></td>
                <td>&nbsp;&nbsp;�ҷ</td>
            </tr>
            <tr>
            	<td>�������</td>
                <td align="right" style="color:#0C3; font-weight:bold;"><?php echo number_format($usemoney-$paymoney);?></td>
                <td>&nbsp;&nbsp;�ҷ</td>
            </tr>
        </table>
        </div>
        <div style="width:20%; height:auto; float:right; border:1px solid #999;">
        	<table width="99%" align="center">
            	<tr>
                	<td style="font-size:18px;"  colspan="2">���͡��ǧ����</td>
                </tr>
                <tr>
                	<td style="font-size:18px;" width="50%" align="center">�������</td>
                    <td style="font-size:18px;">
                    <select id="startdate" name="startdate" style="width:120px;">
                    <?php
						foreach(  $arr_year as $key1 => $value1 ){
							foreach(  $arr_month as $key2 => $value2 ){
								if( (isset($_GET['start_m']) && $_GET['start_m'] != '') && (isset($_GET['start_y']) && $_GET['start_y'] != '')  ){
									if( $key1 == $_GET['start_y'] && $key2 == $_GET['start_m'] ){
										echo '<option value="'.$key1.'_'.$key2.'" selected="selected" >'.$value2.'&nbsp;'.$value1.'</option>';
									}else{
										echo '<option value="'.$key1.'_'.$key2.'">'.$value2.'&nbsp;'.$value1.'</option>';
									}
								}else{
									if( $key1 == '2558' && $key2 == '01' ){
										echo '<option value="'.$key1.'_'.$key2.'" selected="selected" >'.$value2.'&nbsp;'.$value1.'</option>';
									}else{
										echo '<option value="'.$key1.'_'.$key2.'">'.$value2.'&nbsp;'.$value1.'</option>';
									}
								}
							}
						}
					?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td style="font-size:18px;" width="50%" align="center">����ش</td>
                    <td style="font-size:18px;">
                    <select id="enddate" name="enddate" style="width:120px;">
                    <?php
						foreach(  $arr_year as $key1 => $value1 ){
							foreach(  $arr_month as $key2 => $value2 ){
								if( (isset($_GET['end_m']) && $_GET['end_m'] != '') && (isset($_GET['end_y']) && $_GET['end_y'] != '')  ){
									if( $key1 == $_GET['end_y'] && $key2 == $_GET['end_m'] ){
										echo '<option value="'.$key1.'_'.$key2.'" selected="selected" >'.$value2.'&nbsp;'.$value1.'</option>';
									}else{
										echo '<option value="'.$key1.'_'.$key2.'">'.$value2.'&nbsp;'.$value1.'</option>';
									}
								}else{
									if( $key1 == '2558' && $key2 == '01' ){
										echo '<option value="'.$key1.'_'.$key2.'" selected="selected" >'.$value2.'&nbsp;'.$value1.'</option>';
									}else{
										echo '<option value="'.$key1.'_'.$key2.'">'.$value2.'&nbsp;'.$value1.'</option>';
									}
								}
							}
						}
					?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td align="right" colspan="2"><input  type="button" id="process" name="process" value="�����żŢ�����" style="font-size:16px; color:#FFF; border-radius:5px; width:120px; height:30px; background-color:#2b5cd8; border-color:#2b5cd8; box-shadow:5px;" onclick="process($('#startdate :selected').val(),$('#enddate :selected').val())"/></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div style="width:100%; height:auto; float:left; text-align:right; margin-top:5px; margin-bottom:5px;">
    ������ � �ѹ��� 24 �á�Ҥ� 2558
    </div>
    <?php
		if( (isset($_GET['start_m']) && $_GET['start_m'] != '') && (isset($_GET['start_y']) && $_GET['start_y'] != '') && (isset($_GET['end_m']) && $_GET['end_m'] != '') && (isset($_GET['end_y']) && $_GET['end_y'] != '')  ){
			$date1=date_create(($_GET['start_y']-543)."-".$_GET['start_m']."-01");
			$date2=date_create(($_GET['end_y']-543)."-".$_GET['end_m']."-01");
			$diff=date_diff($date1,$date2);
			if( (int)$diff->format("%a") < 30 ){
				$diff = 1;
			}else{
				$diff = ceil((int)$diff->format("%a")/30);
			}
			
			$sql = " SELECT
						provice AS provice,
						num_child AS num_child,
						use_money*".$diff." AS use_money,
						pay_money*".$diff." AS pay_money
					FROM eq_child_payment 
					ORDER BY provice ASC ";
		}else{	
			$sql = " SELECT
						provice AS provice,
						num_child AS num_child,
						use_money AS use_money,
						pay_money AS pay_money,
						percent AS percent
					FROM eq_child_payment 
					ORDER BY provice ASC ";
		}
		$result = mysql_query($sql) or die(mysql_error());
	?>
    <div style="width:100%; height:auto; float:left; text-align:right;">
    <table width="100%;" class="table2">
    	<thead>
        	<tr>
            	<th align="center" width="5%">�ӴѺ</th>
                <th align="center">�ѧ��Ѵ</th>
                <th align="center" width="14%">�ӹǹ���á�Դ����鹷���¹ (��)</th>
                <th align="center" width="14%">�ӹǹ�Թ������ (�ҷ)</th>
                <th align="center" width="14%">�ӹǹ�Թ����ԡ���� (�ҷ)</th>
                <th align="center" width="14%">�����С�è���</th>
            </tr>
        </thead>
        <tbody>
        <?php
			$strSQL2 = "SELECT sum(exsum_district_num) as sumpersonall FROM exsum_district_all";
			$objQuery2 = mysql_query($strSQL2);
			$obj2 = mysql_fetch_object($objQuery2);
			
			$index = 1;
			$sum_num_child = 0;
			$sum_usemoney = 0;
			$sum_paymoney = 0;
			while( $row = mysql_fetch_array($result) ){
				$usemoney = $row['use_money'];
				$paymoney = $row['pay_money'];
				$NumPerson = ($row['provice'] == '��Ҵ') ? $obj2->sumpersonall : $row['num_child'];

				$percent = ($paymoney*100)/$usemoney;
				$bgColor = ($index % 2 == 1) ? '#FFF' : '#f2f2f2';
		?>
        <tr style="background-color:<?php echo $bgColor?>">
            <td style="text-align:center;"><?php echo $index;?></td>
            <td style="text-align:left;"><?php echo $row['provice'];?></td>
            <td style="text-align:right;"><?php echo number_format($NumPerson);?></td>
            <td style="text-align:right;"><?php echo number_format($usemoney);?></td>
            <td style="text-align:right;"><?php echo number_format($paymoney);?></td>
            <td style="text-align:right;"><?php echo number_format($percent,2).'%';?></td>
        </tr>
        <?php
			$sum_num_child += $row['num_child'];
			$sum_usemoney += $usemoney;
			$sum_paymoney += $paymoney;
			$index++;
			}
			$sum_percent = ($sum_paymoney*100)/$sum_usemoney;
		?>
        </tbody>
        <tfoot>
        <tr>
        	<th colspan="2" align="center">���</th>
            <th style="text-align:right;"><?php echo number_format($sum_num_child);?></th>
            <th style="text-align:right;"><?php echo number_format($sum_usemoney);?></th>
            <th style="text-align:right;"><?php echo number_format($sum_paymoney);?></th>
            <th style="text-align:right;"><?php echo number_format($sum_percent,2).'%';?></th>
        </tr>
        </tfoot>
    </table>
    </div>
</div>
</body>
</html>