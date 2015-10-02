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
<?php
	$ws_client = $con->configIPSoap();
	$calendar = array('file' => 'calendar');
	echo $ws_client->call('includefile', $calendar);
	$para = array(
		'dateFormat' => 'dd/mm/yy',
		'inputname' => 'v393',
		'showicon' => false,
		'showOtherMonths' => true,
		'showButton' => false,
		'showchangeMonth' => true,
		'numberOfMonths' => 1,
		'format' => 'tis-620',
		'value'=>'',
		'showWeek' => false);	
	$result = $ws_client->call('calendar', $para); 
	
	$con->connectDB();
	$sql = "SELECT educ_id,education,level FROM eq_member_education";
	$education = $con->select($sql);
	
	$sql = "SELECT id,r_name FROM tbl_relation";
	$relation = $con->select($sql);
?>
<form id="form1" name="form1" method="post" action="../main_exc/form2_add_exc.php" onSubmit="JavaScript:return fncSubmit();">
    <table width="100%" border="0" cellspacing="3" cellpadding="0">
      <thead>
        <tr>
          <th colspan="4" align="center">&nbsp;</th>
        </tr>
        <tr>
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">ข้อมูลส่วนตัว (กลุ่มวัยแรงงาน อายุ 25 ปีขึ้นไป - 60 ปี)</th>
        </tr>
        <tr>
          <th colspan="4" align="center" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">เลขบัตรประชาชน</td>
              <td width="29%"><input type="text" value="" name="v230" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span> <span  id="random2" class="bIdCard">สุ่มเลขบัตร
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="3"  />
                </span></td>
              <td width="6%">ชื่อ-สกุล</td>
              <td width="54%"><select id="v401" name="v401"  style="width:120px"  >
                <option value="">โปรดระบุ</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v228" id="tName"  style="width:120px"  />
                นามสกุล
                <input type="text" value="" name="v389" id="v389"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>เพศ</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v397" type="radio"  class="rSex" id="female"  value="1"  />
                1. หญิง&nbsp;
                <input type="radio"  value="2" class="rSex" name="v397"  id="male" />
                2. ชาย
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>วันเกิด</td>
              <td><?php echo $result; ?> อายุ
                <input name="v229" type="text"  value="" size="3" id="v229"  /></td>
            </tr>
            <tr>
              <td>ความสัมพันธ์ครอบครัว</td>
              <td><select name="v231" style="width:120px">
                <option value="">โปรดระบุ</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>การศึกษา</td>
              <td><select name="v232" style="width:120px">
                <option value="">โปรดระบุ</option>
                <?php
foreach($education as $rd){
	echo '<option value="'.$rd['educ_id'].'">'.$rd['education'].'</option>';
}
?>
              </select></td>
            </tr>
          </table></th>
        </tr>
        <tr>
          <td height="24" colspan="4" align="center" bgcolor="#f2f2f2"><strong>สถานปัญหา</strong></td>
        </tr>
      </thead>
      <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v233" id="checkbox" value="1">
1. ถูกละเมิดทางเพศ<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v237" id="checkbox10" value="5">
5. ติดยาอี</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v241" id="checkbox2" value="9">
9. ไม่มีงานทำ</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v245" id="checkbox11" value="13">
13. ผู้พ้นโทษ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v234" id="checkbox5" value="2">
2. ถูกทำร้ายร่างกายและจิตใจ</td>
        <td valign="middle"><input type="checkbox" name="v238" id="checkbox15" value="6">
6. ติดการพนัน</td>
        <td valign="middle"><input type="checkbox" name="v242" id="checkbox3" value="10">
10. ขาดเงินทุนประกอบอาชีพ</td>
        <td valign="middle"><input type="checkbox" name="v246" id="checkbox25" value="14">
14. มีโรคประจำตัว          
        ระบุ
  <input type="text" value=""  style=" width:30%" name="v247"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v235" id="checkbox9" value="3">
3. ติดสุรา</td>
        <td valign="middle"><input type="checkbox" name="v239" id="checkbox13" value="7">
7. เป็นหม้ายที่ต้องเลี้ยงดูบุตรเพียงลำพัง</td>
        <td valign="middle"><input type="checkbox" name="v243" id="checkbox6" value="11">
11. ติดเชื้อ HIV/ป่วยเอดส์</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v236" id="checkbox12" value="4">
4. ติดยาบ้า</td>
        <td valign="middle"><input type="checkbox" name="v240" id="checkbox14" value="8">
8. ไร้สัญชาติ</td>
        <td valign="middle"><input type="checkbox" name="v244" id="checkbox7" value="12">
12. ได้รับผลกระทบจาก HIV</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr align="center">
        <td height="24" colspan="4" valign="middle" bgcolor="#f2f2f2"><strong>ความช่วยเหลือที่ต้องการ</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v248" id="checkbox4" value="1">
1. การให้คำแนะนำ</td>
        <td valign="top"><input type="checkbox" name="v251" id="checkbox42" value="4">
4. ข้าวสารอาหารแห้ง</td>
        <td valign="top"><input type="checkbox" name="v254" id="checkbox45" value="7">
7. ต้องการเข้าร่วมกิจกรรมต่างๆในชุมชน</td>
        <td valign="top"><input type="checkbox" name="v257" id="checkbox8" value="10">
10. ขอรับการคุ้มครอง</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v249" id="checkbox39" value="2">
2. เงินสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v252" id="checkbox43" value="5">
5.  ต้องการฝึกอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v255" id="checkbox17" value="8">
        8. เงินค่าใช้จ่ายในการรักษาพยาบาล</td>
        <td valign="top"><input type="checkbox" name="v258" id="checkbox16" value="11">
11. ให้ความช่วยเหลือทางกฏหมาย</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v250" id="checkbox40" value="3">
3. เงินทุนประกอบอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v253" id="checkbox44" value="6">
6. ที่อยู่อาศัย</td>
        <td align="left" valign="top"><input type="checkbox" name="v256" id="checkbox136" value="9">
9. เงินค่าใช้จ่ายในการเดินทางไปรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> บันทึกข้อมูล </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>