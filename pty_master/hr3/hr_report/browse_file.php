<?
		session_start();
		include("../libary/function.php");
		include("../../../config/config_hr.inc.php");
		include("../../../common/common_competency.inc.php");
		include("../../../config/phpconfig.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<style type="text/css">
<!--
body {
font-family: Arial, Helvetica, sans-serif;
font-size: 12px
}
.style1 {
color: #000000}
.style2 {color: #990000}
.style3 {color: #00CC00}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
	color: #000000;
}
a:active {
	text-decoration: none;
	color: #000000;
}
hr
{
     border:none;border-top:dotted 2px #e2e2e2; width:100%; height:1px; 
}
hr.thick
-->
</style>
<script language="javascript">
function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=no,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();
}
</script>
<script language="javascript">
function addImg(){

	if (!/(\.(jpg|jpeg))$/i.test(document.post.file.value)){
		alert("รูปแบบของ file ไม่ใช่รูปภาพ \nต้องเป้นนามสกุล jpg เท่านั้น");
		document.post.file.focus();
		return false;	
	} else if(document.post.yy.selectedIndex == 0) {
		alert("โปรดระบุปีของภาพ");
		document.post.yy.focus();
		return false;		
	} else {
		document.post.action.value = "upload";
		document.post.submit();
	}		    
}
</script>
<?
//include ("session.inc.php");
///session_start();


$ids=$_REQUEST['runid'];
if ($ids == ""){ $ids = $id ; } 

if(isset($_POST['submit'])=="บันทึก"){

$realname = $_FILES['userfile']['name']; 

if (is_uploaded_file($_FILES['userfile']['tmp_name']))  {   
$a3 =  $realname ['userfile'];
$rest3 = strtolower(strstr($realname ,'.'));
$realname =random_filename (5);
$file_name= "file_".$realname.$rest3;

copy($_FILES['userfile']['tmp_name'], "images/upload/$file_name");
 $_FILES['userfile']['name'];  }  else{     echo "Upload not complete";   }
				
$name=$_POST['txtname'];
$id1=$_POST['ids']; 

$sql="INSERT INTO  seminar_upload  (id,files,names) VALUE ('$id1','$name','$file_name')";

$result=mysql_query($sql); 
echo mysql_error() ; 

 echo" <br><br><center><font color=red><H3>INSERT... Completed</H3></font></center>";
 echo"<meta http-equiv='refresh' content='1;URL=browse_file.php?runid=$id1'>";
 exit;
 }
elseif($_GET[action] == 'delete') {
$id1=$_GET['runid'];
$ids=$_GET['id'];
	      $sqlun="select * from seminar_upload where id='$ids'";
			$presult = mysql_query($sqlun);
			$urow=mysql_fetch_array($presult);
		    $name=$urow['names'];
            unlink($_SERVER['DOCUMENT_ROOT'].'/democmss/application/hr3/hr_report/images/upload/'.$name);
	         mysql_query("delete from seminar_upload  where runid='$id1';")or die(" Cannot delete parameter. ");
	           if (mysql_errno())
			{
			$msg = "ไม่สามารถลบข้อมูลได้";
			}else
			{ 
		    echo"<meta http-equiv='refresh' content='1;URL=browse_file.php?id=$ids'>";
		   // header("Location: ?runid=$id1");
			exit;
			}
}
echo"<table width='305' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<form action=\"browse_file.php\" method=post enctype=\"multipart/form-data\"> 
<tr bgcolor='#A3B2CC'><td align='center'><b>รายละเอียด</b></td><td align='center'><b>ชื่อไฟล์</b></td>
<td align='center'><b>ลบ</b></td><td align='center'><b>โหลด</b></td></tr>";

$sql="select * from seminar_upload where id='$ids'";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
echo"<tr><td>".$row['files']."</td><td>".$row['names']."</td><td>  "; 
?>
<a href="#" onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&runid=<?=$row[runid]?>&id=<?=$row[id]?>';" >
<img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	
<input  type="hidden" name="id"  value="<?=$row[id]?>">
</td><td align="center"><a href="../hr_report/images/upload/<?=$row['names']?>"  target="_blank">
<img src="bimg/doc2.gif" width="20" height="20" border="0" align="absmiddle"></a></td></tr>
<? 
}
 ?>
 </table><br>
  <title>อัพโหลดไฟล์</title><table width="305" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
  <td width="81" ><font size="2">เลือกไฟล์ :: </font></td>
  <td width="224"><input type=file name="userfile"></td>
  </tr>
  <tr>
  <td ><font size="2">คำอธิบาย :: </font></td>
  <td><input type="text" name="txtname" /></td>
 <input  type="hidden" name="ids"  value="<?echo$ids;?>">
  </tr>
 <td colspan="2" align="center"> <INPUT  TYPE="submit" name="submit" value="บันทึก">&nbsp;
 <input type=button value="ปิดหน้าต่าง" onClick="javascript:window.close();"></td>
 <tr></form>
 </table>
 <?
function random_filename($len)
{
srand((double)microtime()*10000000);
$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$ret_str = "";
$num = strlen($chars);
	for($i = 0; $i < $len; $i++)
	{
	$ret_str.= $chars[rand()%$num];
	$ret_str.=""; 
	}
return $ret_str; 
}
 ?>