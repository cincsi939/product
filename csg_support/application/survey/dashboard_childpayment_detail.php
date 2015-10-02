<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  30/08/2014
 * @access  public
 */
//require_once("lib/class.function.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานการเบิกจ่ายเงินอุดหนุนเด็กแรกเกิด</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style_menu.css">
<script src="../js/jquery-latest.min.js" type="text/javascript"></script>
<script src="../js/jquery-latest.js" type="text/javascript"></script>
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
	border: 1px solid black;
}

#frame{border:0;}
</style>
<script>
$.fn.digits = function(){ 
    return this.each(function(){ 
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
    })
}

$(document).ready(function(){
	var budjet = parseInt($('#budjet').text().replace(/,/gi, ""));
	var cost = parseInt($('#sumall').val());
	var remain = budjet - cost;
	var percent1 = (cost*100)/budjet;
	percent1 = percent1.toFixed(2);
	var percent2 = (100 - percent1);
	
	$('#cost').text($('#sumall').val()).digits();
	$('#remain').text(remain).digits();
	$('#percent1').text(percent1);
	$('#percent2').text(percent2);
	
});

$("span.numbers").digits();
</script>
<body>
<? $box_search = 'on';  include "header.php";?>
<?php
		$strSQL2 = "SELECT sum(exsum_district_num) as sumpersonall FROM exsum_district_all";
		$con = new Cfunction();
		$con->connectDB();
		$objQuery2 = mysql_query($strSQL2);
		$obj2 = mysql_fetch_object($objQuery2);
?>
<div style="width:98%; height:auto; float:left; padding:1%;">
	<div style="width:100%; height:auto; float:left;">
    	<div style="width:68%; height:auto; float:left;">
    	<div style="width:100%; height:auto; float:left; padding-left:10%; padding-top:80px;">
        <table class="table1">
        	<tr>
            	<td width="400">จำนวนเด็กแรกเกิดที่ขึ้นทะเบียน</td>
                <td align="right" style="font-weight:bold;"><?php echo number_format($obj2->sumpersonall); ?></td>
                <td>&nbsp;&nbsp;คน</td>
            </tr>
            <tr>
            	<td>งบประมาณทั้งหมด</td>
                <td align="right" id="budjet" style="font-weight:bold;">3,427,200</td>
                <td>&nbsp;&nbsp;บาท</td>
            </tr>
            <tr>
            	<td>เบิกจ่ายแล้ว</td>
                <td align="right" id="cost" style="font-weight:bold;">158,400,000</td>
                <td>&nbsp;&nbsp;บาท (<span id="percent1"></span>%)</td>
            </tr>
            <tr>
            	<td>คงเหลือ</td>
                <td align="right" id="remain" style="color:#0C3; font-weight:bold;">475,200,000</td>
                <td>&nbsp;&nbsp;บาท (<span id="percent2"></span>%)</td>
            </tr>
        </table>
        </div>
         <div style="width:100%; height:auto; float:left; text-align:right; margin-top:30px;">
        ข้อมูล ณ วันที่ 24 กรกฏาคม 2558
        </div>
        <div style="width:100%; height:auto; float:left; text-align:right;">
        <table width="100%;" class="table2">
            <thead>
                <tr>
                    <th rowspan="2">อำเภอ</th>
                    <th rowspan="2" width="8%">เด็กแรกเกิดที่ขึ้นทะเบียน (คน)</th>
                    <th colspan="12">งบประมาณ 2559 (บาท)</th>
                </tr>
                <tr>
                    <th width="5.5%">ต.ค. 58</th>
                    <th width="5.5%">พ.ย. 58</th>
                    <th width="5.5%">ธ.ค. 58</th>
                    <th width="5.5%">ม.ค. 59</th>
                    <th width="5.5%">ก.พ. 59</th>
                    <th width="5.5%">มี.ค. 59</th>
                    <th width="5.5%">เม.ย. 59</th>
                    <th width="5.5%">พ.ค. 59</th>
                    <th width="5.5%">มิ.ย. 59</th>
                    <th width="5.5%">ก.ค. 59</th>
                    <th width="5.5%">ส.ค. 59</th>
                    <th width="5.5%">ก.ย. 59</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            $con = new Cfunction();
            $con->connectDB();
			
			$sql_district_all = 'SELECT
			exsum_district_ccdigi,
			exsum_district_title,
			exsum_district_num,
			exsum_date,
			exsum_percent,
			exsum_tb2
			FROM exsum_district_all';
			$result_district_all = $con->select($sql_district_all);
			foreach($result_district_all as $key => $val){
				$numArr[$val['exsum_district_ccdigi']] = $val['exsum_district_num'];
			}
			
			$strSQL = "SELECT
			t1.ccDigi,
			t1.column1,
			t1.column2,
			t1.column3,
			t1.column4,
			t1.column5,
			t1.column6,
			t1.column7,
			t1.column8,
			t1.column9,
			t1.column10,
			t1.column11,
			t1.column12,
			t1.column13
			FROM
			report_childpayment AS t1
			WHERE t1.ccDigi = '23000000' ";
			$objQuery = mysql_query($strSQL);
			$objSum = mysql_fetch_object($objQuery);
            
			$strSQL = "SELECT
			t1.ccDigi,
			t1.ccName
			FROM
			ccaa_aumpur AS t1 ";
			$objQuery = mysql_query($strSQL);
            
            $sum2 = $objSum->column3;
			$sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = $sum10 = $sum11 = $sum12 = $sum13 =0;
			
			$arr['col2'] = array('66,000','8,000','33,200','32,000','16,800','4,000','800');
			$arr['col3'] = array('76,000','7,600','28,000','27,600','7,600','2,400','800');
			$arr['col4'] = array('97,200','10,000','22,800','14,000','12,800','2,000','800');
			$arr['col5'] = array('78,400','2,000','31,200','12,800','13,600','3,600','800');
			$arr['col6'] = array('42,800','1,600','38,800','29,600','19,600','2,400','400');
			$arr['col7'] = array('87,200','6,800','26,400','12,800','14,000','2,400','400');
			$arr['col8'] = array('66,000','8,000','33,200','32,000','16,800','3,600','800');

            while($obj = mysql_fetch_object($objQuery)){
                $bgColor = ($i % 2 == 1) ? '#FFF' : '#f2f2f2';
                
                $sum1 += $numArr[$obj->ccDigi];
				if($sum2 >= 0 && $i == 1){
					$randNum2 =  (rand(100,250) * 400);
					$sum2 = $sum2 - $randNum2;
				}elseif($sum2 >= 0 && $i == 2){
					$randNum2 =  (rand(2,28) * 400);
					$sum2 = $sum2 - $randNum2;
				}elseif($sum2 >= 0 && $i == 3){
					$randNum2 =  (rand(50,100) * 400);
					$sum2 = $sum2 - $randNum2;	
				}elseif($sum2 >= 0 && $i == 4){
					$randNum2 =  (rand(30,80) * 400);
					$sum2 = $sum2 - $randNum2;	
				}elseif($sum2 >= 0 && $i == 5){
					$randNum2 =  (rand(10,60) * 400);
					$sum2 = $sum2 - $randNum2;	
				}elseif($sum2 >= 0 && $i == 6){
					$randNum2 =  (rand(5,9) * 400);
					$sum2 = $sum2 - $randNum2;	
				}else{
					$randNum2 = $sum2;
				}
            ?>
            <tr style="background-color:<?php echo $bgColor?>">
                <td><?php echo $obj->ccName?></td>
                <td style="text-align:right;"><?php echo number_format($numArr[$obj->ccDigi])?></td>
                <td style="text-align:right;"><?php echo $arr['col2'][$i-1]?></td>
                <td style="text-align:right;"><?php echo $arr['col3'][$i-1]?></td>
                <td style="text-align:right;"><?php echo $arr['col4'][$i-1]?></td>
                <td style="text-align:right;"><?php echo $arr['col5'][$i-1]?></td>
                <td style="text-align:right;"><?php echo $arr['col6'][$i-1]?></td>
                <td style="text-align:right;"><?php echo $arr['col7'][$i-1]?></td>
                <td style="text-align:right;">-</td>
                <td style="text-align:right;">-</td>
                <td style="text-align:right;">-</td>
                <td style="text-align:right;">-</td>
                <td style="text-align:right;">-</td>
                <td style="text-align:right;">-</td>
            </tr>
            <?php $i++;} ?>
            </tbody>
            <tfoot>
            <tr>
                <th>รวม</th>
                <th style="text-align:right;"><?php echo number_format($obj2->sumpersonall); ?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column3)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column4)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column5)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column6)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column7)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column8)?></th>
                <th style="text-align:right;"><?php echo number_format($objSum->column9)?></th>
                <th style="text-align:right;"><?php echo number_format($sum9)?></th>
                <th style="text-align:right;"><?php echo number_format($sum10)?></th>
                <th style="text-align:right;"><?php echo number_format($sum11)?></th>
                <th style="text-align:right;"><?php echo number_format($sum12)?></th>
                <th style="text-align:right;"><?php echo number_format($sum13)?></th>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" id="sumall" value="<?php echo $objSum->column2 + $objSum->column3 + $objSum->column4 + $objSum->column5 + $objSum->column6 + $objSum->column7 + $objSum->column8?>" />
        </div>
        </div>
        
        <div style="width:30%; height:auto; float:left; padding-left:1%">
        <iframe id="frame" src="../../report_map/map.php?area_id=230000&level_area=province&year=2557&mapsize=m&maptype=1" style="width:100%;height:680px;">
        </iframe>
        </div>
    </div>
    
</div>
</body>
</html>