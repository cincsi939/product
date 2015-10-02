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
		'inputname' => 'v395',
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">ข้อมูลส่วนตัว (กลุ่มคนพิการ)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">เลขบัตรประชาชน</td>
              <td width="29%"><input type="text" value="" name="v299" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span> <span  id="random2" class="bIdCard">สุ่มเลขบัตร
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="5"  />
                </span></td>
              <td width="6%">ชื่อ-สกุล</td>
              <td width="54%"><select id="v403" name="v403"  style="width:120px"  >
                <option value="">โปรดระบุ</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v297" id="tName"  style="width:120px"  />
                นามสกุล
                <input type="text" value="" name="v391" id="v391"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>สภาพความพิการ</td>
              <td><input type="text" value="" name="v386"  style="width:120px" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>เพศ</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v399" type="radio"  class="rSex" id="female"  value="1"  />
                1. หญิง&nbsp;
                <input type="radio"  value="2" class="rSex" name="v399"  id="male" />
                2. ชาย
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>วันเกิด</td>
              <td><?php echo $result; ?> อายุ
                <input name="v298" type="text"  value="" size="3" id="v298"  /></td>
            </tr>
            <tr>
              <td>ความสัมพันธ์ครอบครัว</td>
              <td><select name="v300" style="width:120px">
                <option value="">โปรดระบุ</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>การศึกษา</td>
              <td><select name="v301" style="width:120px">
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
        <td width="25%" valign="middle"><input type="checkbox" name="v302" id="checkbox" value="1">
1. ถูกละเมิดทางเพศ<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v307" id="checkbox10" value="6">
6. ติดการพนัน</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v312" id="checkbox34" value="11">
11. ขาดกายอุปกรณ์ </td>
        <td width="25%" valign="middle"><input type="checkbox" name="v317" id="checkbox2" value="16">
16. ผู้ได้รับผลกระบทจากเอดส์ </td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v303" id="checkbox5" value="2">
2. ถูกทำร้ายร่างกายและจิตใจ</td>
        <td valign="middle"><input type="checkbox" name="v308" id="checkbox30" value="7">
7. ยังไม่ได้จดทะเบียน</td>
        <td valign="middle"><input type="checkbox" name="v313" id="checkbox35" value="12">
12.  ไร้สัญชาติ</td>
        <td valign="middle"><input type="checkbox" name="v318" id="checkbox6" value="17">
17. ผู้พ้นโทษ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v304" id="checkbox9" value="3">
3. ติดสุรา</td>
        <td valign="middle"><input type="checkbox" name="v309" id="checkbox31" value="8">
8. ถูกทอดทิ้ง</td>
        <td valign="middle"><input type="checkbox" name="v314" id="checkbox36" value="13">
13. ไม่ได้รับการออกเอกสารรับรองความพิการ</td>
        <td valign="middle"><input type="checkbox" name="v319" id="checkbox7" value="18">
18. มีโรคประจำตัว&nbsp;ระบุ&nbsp;
<input type="text" value=""  style=" width:30%" name="v320"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v305" id="checkbox12" value="4">
4. ติดยาบ้า</td>
        <td valign="middle"><input type="checkbox" name="v310" id="checkbox32" value="9">
9. ที่อยู่อาศัยไม่เหมาะสม</td>
        <td valign="middle"><input type="checkbox" name="v315" id="checkbox135" value="14">
14. พิการซ้ำซ้อน</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v306" id="checkbox13" value="5">
5. ติดยาอี</td>
        <td valign="middle"><input type="checkbox" name="v311" id="checkbox33" value="10">
10. ไม่มีอาชีพ</td>
        <td valign="middle"><input type="checkbox" name="v316" id="checkbox3" value="15">
15. ผู้ติดเชื้อHIV/ผู้ป่วยเอดส์ </td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="top" bgcolor="#f2f2f2"><strong>ความช่วยเหลือที่ต้องการ</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v321" id="checkbox38" value="1">
1. การให้คำแนะนำ</td>
        <td valign="top"><input type="checkbox" name="v327" id="checkbox45" value="7">
7. เข้าสถานสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v333" id="checkbox15" value="13">
13. รถเข็นนั่ง(วีลแชร์)</td>
        <td valign="top"><input type="checkbox" name="v339" id="checkbox4" value="19">
19. ต้องการซ่อมอุปกรณ์่</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v322" id="checkbox39" value="2">
2. เงินสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v328" id="checkbox46" value="8">
8. ต้องการเข้าร่วมกิจกรรมต่างๆในชุมชน</td>
        <td valign="top"><input type="checkbox" name="v334" id="checkbox16" value="14">
14. รถสามล้อโยก</td>
        <td valign="top"><input type="checkbox" name="v340" id="checkbox21" value="20">
20. เครื่องนุ่งห่ม</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v323" id="checkbox40" value="3">
3. เงินทุนประกอบอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v329" id="checkbox136" value="9">
9. เงินค่าใช้จ่ายในการรักษาพยาบาล</td>
        <td valign="top"><input type="checkbox" name="v335" id="checkbox17" value="15">
15. ไม้เท้าค้ำยัน</td>
        <td valign="top"><input type="checkbox" name="v341" id="checkbox22" value="21">
21. ผ้าอ้อมสำเร็จรูป</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v324" id="checkbox42" value="4">
4. ต้องการฝึกอาชีพ</td>
        <td valign="top"><input type="checkbox" name="v330" id="checkbox8" value="10">
10. เงินค่าใช้จ่ายในการเดินทางไปรักษาพยาบาล</td>
        <td valign="top"><input type="checkbox" name="v336" id="checkbox18" value="16">
16. เครื่องช่วยฟัง</td>
        <td valign="top"><input type="checkbox" name="v342" id="checkbox23" value="22">
22. ข้าวสารอาหารห้ง </td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v325" id="checkbox43" value="5">
5. ซ่อมแซมที่อยู่อาศัย </td>
  <td valign="top"><input type="checkbox" name="v331" id="checkbox11" value="11">
11. จัดหาสถานศึกษา</td>
        <td valign="top"><input type="checkbox" name="v337" id="checkbox25" value="17">
17. ขาเทียม</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v326" id="checkbox44" value="6">
6. สิ่งอำนวยความสะดวก</td>
        <td><input type="checkbox" name="checkbox34" id="v332" value="12">
12. สื่ออุปกรณ์พิเศษทางการศึษา      
        <td valign="top"><input type="checkbox" name="v338" id="checkbox20" value="18">
18. แขนเทียม</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> บันทึกข้อมูล </button>        </td>
        <td valign="top">&nbsp;</td>
      </tr>
</table>
    </form>