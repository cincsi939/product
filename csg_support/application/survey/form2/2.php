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
		'inputname' => 'v392',
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2">ข้อมูลส่วนตัว (กลุ่มเยาวชน อายุ 19-25 ปี)</th>
        </tr>
        <tr>
          <th colspan="4" align="center" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">เลขบัตรประชาชน</td>
              <td width="29%"><input type="text" value="" name="v196" id="tIDCard"  style="width:120px"  />
                <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span> <span  id="random2" class="bIdCard">สุ่มเลขบัตร
                  <input  name="pin" type="hidden" id="pin" value="<?php echo $_GET['id']; ?>"  />
                <input  name="eq_type" type="hidden" id="eq_type" value="2"  />
                </span></td>
              <td width="6%">ชื่อ-สกุล</td>
              <td width="54%"><select id="v400" name="v400"  style="width:120px"  >
                <option value="">โปรดระบุ</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
                <input type="text" value="" name="v194" id="tName"  style="width:120px"  />
                นามสกุล
                <input type="text" value="" name="v388" id="v388"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>เพศ</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />--><LABEL id="lblPreName">
                <input name="v396" type="radio"  class="rSex" id="female"  value="1"  />
                1. หญิง&nbsp;
                <input type="radio"  value="2" class="rSex" name="v396"  id="male" />
                2. ชาย
                <INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" /></LABEL></td>
              <td>วันเกิด</td>
              <td><?php echo $result; ?> อายุ
                <input name="v195" type="text"  value="" size="3" id="v195"  /></td>
            </tr>
            <tr>
              <td>ความสัมพันธ์ครอบครัว</td>
              <td><select name="v197" style="width:120px">
                <option value="">โปรดระบุ</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>การศึกษา</td>
              <td><select name="v198" style="width:120px">
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
        <td width="25%" valign="middle"><input type="checkbox" name="v199" id="checkbox" value="1">
1. ไม่ได้ศึกษา<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v205" id="checkbox2" value="7">
7. ติดยาบ้า</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v211" id="checkbox3" value="13">
13. ติดเชื้อ HIV</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v217" id="checkbox119" value="19">
19. มีโรคประจำตัว          
        ระบุ 
  <input type="text" value="" name="v218"  style=" width:30%"  /></td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v200" id="checkbox5" value="2">
2. ไม่มีงานทำ</td>
        <td valign="middle"><input type="checkbox" name="v206" id="checkbox6" value="8">
8. ติดยาอี</td>
        <td valign="middle"><input type="checkbox" name="v212" id="checkbox7" value="14">
14. ได้รับผลกระทบจาก HIV</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v201" id="checkbox9" value="3">
3. ถูกละเมิดทางเพศ</td>
        <td valign="middle"><input type="checkbox" name="v207" id="checkbox10" value="9">
9. ติดเกมส์</td>
        <td valign="middle"><input type="checkbox" name="v213" id="checkbox11" value="15">
15. บิดา/มารดาเสียชีวิต</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v202" id="checkbox12" value="4">
4. ถูกทำร้ายร่างกายและจิตใจ</td>
        <td valign="middle"><input type="checkbox" name="v208" id="checkbox15" value="10">
10. เล่นการพนัน</td>
        <td valign="middle"><input type="checkbox" name="v214" id="checkbox116" value="16">
16. บิดา/มารดาต้องโทษจำคุก</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v203" id="checkbox14" value="5">
5. ดื่มเครื่องดื่มที่มีแอลกอฮอล์</td>
        <td valign="middle"><input type="checkbox" name="v209" id="checkbox16" value="11">
11. มีพฤติกรรมทางเบี่ยงเบนทางเพศ</td>
        <td valign="middle"><input type="checkbox" name="v215" id="checkbox117" value="17">
17. บิดา/มารดาทอดทิ้ง</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v204" id="checkbox13" value="6">
6. สูบบุหรี่</td>
        <td valign="middle"><input type="checkbox" name="v210" id="checkbox17" value="12">
12. ไร้สัญชาติ</td>
        <td valign="middle"><input type="checkbox" name="v216" id="checkbox118" value="18">
18. ผู้พ้นโทษ</td>
        <td valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>ความช่วยเหลือที่ต้องการ</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v219" id="checkbox4" value="1">
1. การให้คำแนะนำ</td>
        <td valign="top"><input type="checkbox" name="v222" id="checkbox19" value="4">
4. เครื่องนุ่งหุ่ม</td>
        <td valign="top"><input type="checkbox" name="v225" id="checkbox22" value="7">
7. ค่าใช้จ่ายในการเดินทางรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v220" id="checkbox8" value="2">
2. ทุนประกอบ</td>
        <td valign="top"><input type="checkbox" name="v223" id="checkbox20" value="5">
5. ได้รับการบำบัด&nbsp;ฟื้นฟู</td>
        <td valign="top"><input type="checkbox" name="v226" id="checkbox23" value="8">
8. เงินค่าใช้จ่ายในการรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v221" id="checkbox18" value="3">
3. เงินสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v224" id="checkbox21" value="6">
6. ข้าวสารอาหารแห้ง </td>
        <td valign="top"><input type="checkbox" name="v227" id="checkbox24" value="9">
9. หางานทำ</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> บันทึกข้อมูล </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
  </table>
    </form>