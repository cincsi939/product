<?php
session_start();
include("../../config/conndb_nonsession.inc.php");
include('common/user_keyin_stat.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>User Keyin Stat</title>
<script>
function form_submit(){
	document.getElementById("form_date").submit();
}
function checkDate(){
	var val_date ='<?=(date("Y")+543).date('md')?>';
	var mval_date = document.getElementById("year").value+""+ document.getElementById("month").value+""+document.getElementById("date").value;
	if(val_date < mval_date){
		alert("เลือกวันที่มากกว่าวันที่ปัจุบัน");
		return false;
	}else{
		return true;
	}
}
</script>
</head>
<body <?php echo ($_POST['date']=="")?'onload="form_submit()"':"";?>>
<center><strong>รานงานค่าคะแนนการบันทึกข้อมูล (User Keyin Stat)</strong></center>
<table width="100%" border="0" align="center">
  <tr>
    <td align="center">
	<form action="" id="form_date" method="post" onsubmit="return checkDate();">
	วันที่
	<select name="date" id="date">
	<?php 
	for($i=0;$i<=31;$i++){
		echo '<option value="'.(($i<10)?"0":"").$i.'" '.( ( (($_POST['date'])?$_POST['date']:date("d")) ==(($i<10)?"0":"").$i)?"SELECTED":"" ).'>'.(($i<10)?"0":"").$i.'</option>';
	} 
	?>
	</select>
	<select name="month" id="month">
	<?php 
	for($i=0;$i<=12;$i++){
		echo '<option value="'.(($i<10)?"0":"").$i.'" '.(((($_POST['month'])?$_POST['month']:date("m"))==(($i<10)?"0":"").$i)?"SELECTED":"").'>'.(($i<10)?"0":"").$i.'</option>';
	} 
	?>
	</select>
	<select name="year" id="year">
	<?php 
	$e_year = date("Y")+543;
	$s_year = $e_year-5;
	for($i=$s_year;$i<=$e_year;$i++){
		echo '<option value="'.(($i<10)?"0":"").$i.'" '.(((($_POST['year'])?$_POST['year']:$e_year)==$i)?"SELECTED":"").'>'.(($i<10)?"0":"").$i.'</option>';
	} 
	?>
	</select>
	<input name="b_submit" type="submit" value="แสดง"/>
	</form>
	</td>
  </tr>
  <tr>
    <td align="center">
	<?php 
	$setGet = "?date_stat=".($_POST['year']-543)."-".$_POST['month']."-".$_POST['date'];
	$date_stat = ($_POST['year']-543)."-".$_POST['month']."-".$_POST['date'];
	$data_point_rate = array(1=>100);
	for($i=0;$i<40;$i++){
		$data_point_rate[$i+2]=array(101+($i*10),110+($i*10));
	}
	
	//$data = array();
	foreach($data_point_rate as $key=>$value){
		$count_user = 0;
		if(is_array($value)){
			$point = $value;
			$count_user = getNumkeyPoint($date_stat,$point[0],$point[1]);
			$point_rate = (($point[0])?$point[0]:"0")."-".$point[1];
		}else{
			$count_user = getNumkeyPoint($date_stat,$value);
			$point_rate = "0-".$value;
		}
		if($count_user>0){
			$data[] = $point_rate.":".$count_user;
		}
	}
	if(is_array($data)){
		natcasesort($data);
	}
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";*/
	?>
	<img src="image.php<?php echo $setGet;?>"  />
<?php /*?>	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="800" height="400">
  <param name="movie" value="http://202.129.35.106/graphservice/graphservice.php?category=<?=$category?>&data1=<?=$data1?>&data2=<?=$data2?>&outputstyle=&numseries=2&seriesname=คะแนนมาตรฐาน;คะแนนททำได้&xname=จำนวนคน&yname=ค่าคะแนน&title=กราฟแสดงค่าคะแนนการบันทึกข้อมูล&graphtype=xy&graphstyle=srd_allvisible_sf_point.scs&subtitle=User Keyin Stat">
  <param name="quality" value="high">
  <param name="wmode" value="transparent">
  <embed src="http://202.129.35.106/graphservice/graphservice.php?category=<?=$category?>&data1=<?=$data1?>&data2=<?=$data2?>&outputstyle=&numseries=2&seriesname=คะแนนมาตรฐาน;คะแนนททำได้&xseries=จำนวนคน&xname=จำนวนคน&yname=ค่าคะแนน&title=กราฟแสดงค่าคะแนนการบันทึกข้อมูล&graphtype=xy&graphstyle=srd_allvisible_sf_point.scs&subtitle=User Keyin Stat" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="800" height="400"></embed>
</object><?php */?>
</td>
  </tr>
</table>
<table width="650" border="0" cellpadding="2" cellspacing="1" align="center" style="font-size:14px;" bgcolor="#CCCCCC">
  <tr bgcolor="#EEEEEE" align="center">
    <td width="50"><strong>ลำดับ</strong></td>
    <td width="40%"><strong>ช่วงค่าคะแนน</strong></td>
    <td ><strong>จำนวนคน</strong></td>
  </tr>
  <?php
  $intData=0;
  $sum_user=0;
  if(is_array($data)){
	  foreach($data as $rate_point){
	  $intData++;
	  $arr_point=explode(":",$rate_point);
	  $txt_point = $arr_point[0];
	  $txt_user = $arr_point[1];
	  $arr_rate = explode("-",$txt_point);
	  ?>
	  <tr align="center" bgcolor="<?php echo ($arr_rate[0]<240)?"#FFFF99":"#afed9c";?>">
		<td width="50"><?php echo $intData;?></td>
		<td><?php echo $txt_point;?></td>
		<td><?php echo $txt_user;?></td>
	  </tr>
	  <?php
	  $sum_user +=  $txt_user;
	   } 
   }
   ?>
  <tr  bgcolor="#0099CC">
    <td colspan="2" align="left"><strong>รวม</strong></td>
    <td align="center"><strong><?php echo $sum_user;?></strong></td>
  </tr>
</table>


</body>
</html>