<?php
/**
 * @comment 
 * @projectCode
 * @tor     
 * @package  core
 * @author Tanachai Khampukhew (tanachai@sapphire.co.th)
 * @created  10/09/2014
 * @access  public
 */
 ?>
<link rel="stylesheet" href="../css/style.css">
<script type="text/javascript" src="../js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {
				$('a[id^="add"]').fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
					parent.location.reload(true); 
				}
			});
			
			$('a[id^="show"]').fancybox({
				'width'				: '90%',
				'height'			: '100%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
				}
			});
			
			$('a[id^="del"]').fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
					parent.location.reload(true); 
				}
			});
		});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<table width="840" border="0" id="tb2">
<tr>
  <td width="72" align="right">&nbsp;</td>
  <td width="667">&nbsp;</td>
</tr>
<tr>
	<td align="right"><b><u>ส่วนที่ 2</u></b></td>
    <td><b>ด้านกลุ่มเป้าหมาย</b></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
   	  <div align="right"><p><a id="add" href="main/form2_add.php?id=<?php echo $_GET['id']; ?>" class="button_tb2"> เพิ่มข้อมูล </a></p></div>
        <table width="840" border="0" cellpadding="0" cellspacing="1" id="ppDriverTable" class="order-list">
        <thead>
            <tr>
                <th width="28" height="24" ><strong>ลำดับ</strong></th>
                <th width="86" height="24" >กลุ่มเป้าหมาย</th>
                <th width="115" height="24" >เลขที่บัตรประชาชน</th>
                <th width="233" height="24" >ชื่อ-สกุล</th>
                <th width="73" height="24" >อายุ</th>
                <th width="90" >ความสัมพันธ์</th>
                <th width="151" >การศึกษา</th>
                <th width="55" height="24" >เครื่องมือ</th>
          </tr>
        </thead>
        <tbody>
        <?php
			$i = 0;
			//include('lib/class.function.php');
			$con = new Cfunction();
			$con->connectDB();
			/*$sql = "SELECT tbl2_type,tbl2_id,tbl2_name,tbl2_idcard,tbl2_birthday,tbl2_age,r_name,education,tbl2_problem,tbl2_help,getDetail(4,tbl2_prename) as tbl2_prename";
			$sql .= " FROM question_tbl2";
			$sql .= " INNER JOIN tbl_relation ON tbl_relation.id = question_tbl2.tbl2_relation";
			$sql .= " INNER JOIN eq_member_education ON eq_member_education.educ_id = question_tbl2.tbl2_education";
			$sql .= " WHERE main_id=".$_GET['id'];
			$sql .= " order by tbl2_id asc";*/
			/*$sql = "select siteid,form_id,number_action,pin,child_userid,vid,yy,mm,value from eq_var_data where siteid=1 AND form_id=2 AND pin='".$_GET['id']."'";
			$results = $con->select($sql);
			foreach($results as $row)
			{
				if(($row['vid']==154) or ($row['vid']==154))
				{
				}
				//$value[$row['vid']] = $row['value'];
			}*/
			
			$sql = "select eq_type,eq_idcard,eq_prename,eq_firstname,eq_lastname,eq_age,eq_education,eq_relation from eq_person where eq_partner_id = '".$_GET['id']."'";
			$tbl2 = $con->select($sql);
			foreach($tbl2 as $row){
				$i++;
		?>
            <tr>
                <td height="50" align="center" valign="top"><?php echo $i; ?></td>
                <td height="50" align="center" valign="top"><?php echo $con->chkImg($row['eq_type'],'../'); ?></td>
                <td height="50" align="center" valign="top"><?php /*?><a id="show" href="form2/show.php?id=<?php echo $row['eq_idcard']; ?>"><?php */?><?php echo $row['eq_idcard']; ?><!--</a>--></td>
                <td height="50" align="left" valign="top">&nbsp;&nbsp;<?php echo $row['eq_prename']; ?><?php echo $row['eq_firstname']; ?> <?php echo $row['eq_lastname']; ?></td>
                <td height="50" align="center" valign="top"><?php echo $row['eq_age']; ?></td>
                <td height="50" align="center" valign="top"><?php echo $row['eq_relation']; ?></td>
            <td height="50" align="left" valign="top"><?php echo $row['eq_education']; ?></td>
                <td height="50" align="center" valign="top"><a id="del" href="main_exc/form2_del_exc.php?id=<?php echo $row['eq_idcard']; ?>&main_id=<?php echo $_GET['id']; ?>" OnClick="return chkdel();">ลบ</a></td>
          </tr>
         <?php
			}
		 ?>
        </tbody>
        </table>
        
      </td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td align="right"><button onClick="location.href='question_form.php?frame=form3&id=<?php echo $_GET['id']; ?>'"> ดำเนินการต่อ </button></td>
  </tr>
</table>

<!----------------ยืนยันการลบข้อมูล------------------->
<script language="JavaScript">
       function chkdel(){
              if(confirm(' คุณต้องการลบตารางข้อมูลนี้ ')){
                     return true; // ถ้าตกลง OK โปรแกรมก็จะทำงานต่อไป 
              }else{
                     return false; // ถ้าตอบ Cancel ก็คือไม่ต้องทำอะไร 
              }
       }
</script>