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
		'inputname' => 'v394',
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
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <thead>
        <tr>
          <th colspan="4" align="center">&nbsp;</th>
        </tr>
        <tr>
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">ข้อมูลส่วนตัว (กลุ่มผู้สูงอาย อายุ 60 ปี ขึ้นไป)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">เลขบัตรประชาชน</td>
              <td width="29%"><input type="text" value="" name="v261" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span> <span  id="random2" class="bIdCard">สุ่มเลขบัตร
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="4"  />
                </span></td>
              <td width="6%">ชื่อ-สกุล</td>
              <td width="54%"><select id="v402" name="v402"  style="width:120px"  >
                <option value="">โปรดระบุ</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v259" id="tName"  style="width:120px"  />
                นามสกุล
                <input type="text" value="" name="v390" id="v390"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>เพศ</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v398" type="radio"  class="rSex" id="female"  value="1"  />
                1. หญิง&nbsp;
                <input type="radio"  value="2" class="rSex" name="v398"  id="male" />
                2. ชาย
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>วันเกิด</td>
              <td><?php echo $result; ?> อายุ
                <input name="v260" type="text"  value="" size="3" id="v260"  /></td>
            </tr>
            <tr>
              <td>ความสัมพันธ์ครอบครัว</td>
              <td><select name="v262" style="width:120px">
                <option value="">โปรดระบุ</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>การศึกษา</td>
              <td><select name="v263" style="width:120px">
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
          <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>สถานปัญหา</strong></td>
        </tr>
      </thead>
      <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v264" id="checkbox" value="1">
1. ถูกละเมิดทางเพศ<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v269" id="checkbox10" value="6">
6. ติดการพนัน</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v274" id="checkbox3" value="11">
11. ผู้ได้รับผลกระบทจากเอดส์ </td>
        <td width="25%" valign="middle"><input type="checkbox" name="v279" id="checkbox11" value="16">
16. อาศัยอยู่ตามลำพัง</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v265" id="checkbox5" value="2">
2. ถูกทำร้ายร่างกายและจิตใจ</td>
        <td valign="middle"><input type="checkbox" name="v270" id="checkbox15" value="7">
7. ผู้สูงอายุติดบ้าน</td>
        <td valign="middle"><input type="checkbox" name="v275" id="checkbox6" value="12">
12.  ไร้สัญชาติ</td>
        <td valign="middle"><input type="checkbox" name="v280" id="checkbox17" value="17">
17. ขาดความปลอดภัยในการดำรงชีวิต</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v266" id="checkbox9" value="3">
3. ติดสุรา</td>
        <td valign="middle"><input type="checkbox" name="v271" id="checkbox31" value="8">
8. ผู้สูงอายุป่วยเรื้อรัง/ป่วยติดเตียง</td>
        <td valign="middle"><input type="checkbox" name="v276" id="checkbox7" value="13">
13. ผู้สูงอายุที่ต้องเลี้ยงดูบุตรหลาน</td>
        <td valign="middle"><input type="checkbox" name="v281" id="checkbox18" value="18">
18. ผู้พ้นโทษ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v267" id="checkbox12" value="4">
4. ติดยาบ้า</td>
        <td valign="middle"><input type="checkbox" name="v272" id="checkbox32" value="9">
9. ผู้สูงอายุที่ซึมเศร้าหลงลืม</td>
        <td valign="middle"><input type="checkbox" name="v277" id="checkbox135" value="14">
14. ผู้สูงอายุไม่มีที่อยู่อาศัย/ขาดผู้อุปการะเลี้ยงดู</td>
        <td valign="middle"><input type="checkbox" name="v282" id="checkbox19" value="19">
19. มีโรคประจำตัว&nbsp;ระบุ&nbsp;
<input type="text" value=""  style=" width:30%" name="v283"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v268" id="checkbox13" value="5">
5. ติดยาอี</td>
        <td valign="middle"><input type="checkbox" name="v273" id="checkbox2" value="10">
10. ผู้ติดเชื้อHIV/ผู้ป่วยเอดส์</td>
        <td valign="middle"><input type="checkbox" name="v278" id="checkbox14" value="15">
15. ขาดเงินประกอบอาชีพ</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>ความช่วยเหลือที่ต้องการ</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v284" id="checkbox38" value="1">
1. การให้คำแนะนำ</td>
        <td valign="top"><input type="checkbox" name="v288" id="checkbox21" value="5">
5.  ต้องการฝึกอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v292" id="checkbox24" value="9">
9. เงินค่าใช้จ่ายในการเดินทางไปรักษาพยาบาล</td>
        <td valign="top"><input type="checkbox" name="v296" id="checkbox4" value="13">
13. ผ้าอ้อมสำเร็จรูปสำหรับผู้ใหญ่</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v285" id="checkbox39" value="2">
2. เงินสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v289" id="checkbox22" value="6">
6. ที่อยู่อาศัย</td>
        <td valign="top"><input type="checkbox" name="v293" id="checkbox25" value="10">
10. เงินค่าใช้จ่ายในการรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v286" id="checkbox40" value="3">
3. เงินทุนประกอบอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v290" id="checkbox8" value="7">
7. ขอรับการคุ้มครอง</td>
        <td valign="top"><input type="checkbox" name="v294" id="checkbox27" value="11">
11. ชุมชนวางระบบคุ้มครอง</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v287" id="checkbox20" value="4">
4. ข้าวสารอาหารแห้ง</td>
        <td valign="top"><input type="checkbox" name="v291" id="checkbox23" value="8">
        8. ต้องการเข้าร่วมกิจกรรมต่างๆในชุมชน</td>
        <td valign="top"><input type="checkbox" name="v295" id="checkbox26" value="12">
12. จัดอาสาสมัครเข้าไปดูแล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> บันทึกข้อมูล </button>        </td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>