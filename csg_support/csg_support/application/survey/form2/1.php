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
		'inputname' => 'v382',
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
	$sql = "SELECT educ_id,education,level FROM eq_member_education order by level asc";
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
          <th height="24" colspan="4" align="center" bgcolor="#f2f2f2" >ข้อมูลส่วนตัว (กลุ่มเด็กเล็ก อายุ 0-18 ปี)</th>
        </tr>
        <tr>
          <th colspan="4" align="left" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="11%">เลขบัตรประชาชน</td>
              <td width="29%"><input type="text" name="v156" id="tIDCard"  style="width:120px"  />
              <span  id="idClassCheck" class="bIdCard">ตรวจสอบ</span> <span  id="random2" class="bIdCard">สุ่มเลขบัตร
              <input type="hidden" value="<?php echo $_GET['id']; ?>"  name="pin"  />
              <input  name="eq_type" type="hidden" id="eq_type" value="1"  />
              </span></td>
              <td width="6%">ชื่อ</td>
              <td width="54%"><select id="v384" name="v384"  style="width:120px"  >
                <option value="">โปรดระบุ</option>
                <?php
				$sql_Prename = 'SELECT id,prename_th,gender FROM `tbl_prename` ORDER BY priority asc;';
				$results_Prename = $con->select($sql_Prename);
				foreach($results_Prename as $rd){
						echo '<option  value="'.$rd['id'].'">'.$rd['prename_th'].'</option>';
				}
			 ?>
              </select>
              <input type="text" value="" name="v154" id="tName"  style="width:120px"  />
              นามสกุล
              <input type="text" value="" name="v381" id="v381"  style="width:120px"  /></td>
            </tr>
            <tr>
              <td>เพศ</td>
              <td><!--<input type="text" value=""  style=" width:10%"  />-->
              <LABEL id="lblPreName">
                <input name="v383" type="radio"  class="rSex" id="female"  value="1"  />
1. หญิง&nbsp;
<input type="radio"  value="2" class="rSex" name="v383"  id="male" />
2. ชาย
<INPUT name="chkSex" type="hidden" id="tSex" value="1" size="30" />
			</LABEL></td>
              <td>วันเกิด</td>
              <td><?php echo $result; ?> อายุ
              <input name="v155" type="text"  value="" size="3" id="v155"  /></td>
            </tr>
            <tr>
              <td>ความสัมพันธ์ครอบครัว</td>
              <td><select name="v157" style="width:120px">
              			<option value="">โปรดระบุ</option>
                <?php
foreach($relation as $rd){
	echo '<option value="'.$rd['id'].'">'.$rd['r_name'].'</option>';
}
?>
              </select></td>
              <td>การศึกษา</td>
              <td><select name="v158" style="width:120px">
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
          <th colspan="4" align="left" ><!--<input type="text" value=""  style=" width:10%"  />--></th>
        </tr>
        <tr>
          <td  height="24" colspan="4" align="center" bgcolor="#f2f2f2" ><strong>สถานปัญหา</strong></td>
        </tr>
      </thead>
       <tr>
        <td width="25%" valign="middle"><input type="checkbox" name="v159" id="checkbox" value="1">
1. ไม่มีทุนการศึกษา<br></td>
        <td width="25%" valign="middle"><input type="checkbox" name="v165" id="checkbox2" value="7">
7. ติดยาอี</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v171" id="checkbox3" value="13">
13. พ่อแม่วัยรุ่น</td>
        <td width="25%" valign="middle"><input type="checkbox" name="v177" id="checkbox119" value="19">
19. บิดา/มารดาต้องโทษจำคุก</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v160" id="checkbox5" value="2"> 
        2. ถูกละเมิดทางเพศ</td>
        <td valign="middle"><input type="checkbox" name="v166" id="checkbox6" value="8">
8. ติดเกมส์</td>
        <td valign="middle"><input type="checkbox" name="v172" id="checkbox7" value="14">
14. เด็กที่บกพร่องทางการเรียนรู้</td>
        <td valign="middle"><input type="checkbox" name="v178" id="checkbox120" value="20">
20. บิดา/มารดาทอดทิ้ง</td>
      </tr>
      <tr>
        <td valign="middle"><input name="v161" type="checkbox" id="checkbox9" value="3">
3. ถูกทำร้ายร่างกายและจิตใจ</td>
        <td valign="middle"><input type="checkbox" name="v167" id="checkbox10" value="9">
9. เล่นการพนัน</td>
        <td valign="middle"><input type="checkbox" name="v173" id="checkbox11" value="15">
15. ไร้สัญชาติ</td>
        <td valign="middle"><input type="checkbox" name="v179" id="checkbox121" value="21">
21. เด็กขอทาน</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v162" id="checkbox12" value="4">
4. ดื่มเครื่องดื่มที่มีแอลกอฮอล</td>
        <td valign="middle"><input type="checkbox" name="v168" id="checkbox15" value="10">
10. มีพฤติกรรมเบี่ยงเบนทางเพศ</td>
        <td valign="middle"><input type="checkbox" name="v174" id="checkbox116" value="16">
16. เด็กติดเชื้อ HIV</td>
        <td valign="middle"><input type="checkbox" name="v180" id="checkbox122" value="22">
22. เด็กไม่ได้รับการศึกษาภาคบังคับ(ม.3)</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v163" id="checkbox14" value="5">
5. สูบบุหรี่</td>
        <td valign="middle"><input type="checkbox" name="v169" id="checkbox16" value="11">
11. มีเพศสัมพันธ์ก่อนวัยอันควร</td>
        <td valign="middle"><input type="checkbox" name="v175" id="checkbox117" value="17">
17. เด็กได้รับผลกระทบจาก HIV</td>
        <td valign="middle"><input type="checkbox" name="v181" id="checkbox123" value="23">
23. ผู้พ้นโทษ</td>
      </tr>
      <tr>
        <td valign="middle"><input type="checkbox" name="v164" id="checkbox13" value="6">
6. ติดยาบ้า</td>
        <td valign="middle"><input type="checkbox" name="v170" id="checkbox17" value="12">
12. ตั้งครรภ์ไม่พร้อม</td>
        <td valign="middle"><input type="checkbox" name="v176" id="checkbox118" value="18">
18. บิดา/มารดาเสียชีวิต</td>
        <td height="20" valign="middle"><input type="checkbox" name="v182" id="checkbox124" value="24">
24. มีโรคประจำตัว          
        ระบุ 
  <input type="text" value=""  style=" width:30%" name="v183"  /></td>
      </tr>
      <tr>
        <td height="24" colspan="4" align="center" valign="middle" bgcolor="#f2f2f2"><strong>ความช่วยเหลือที่ต้องการ</strong></td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v184" id="checkbox4" value="1">
1. การให้คำแนะนำ</td>
        <td valign="top"><input type="checkbox" name="v187" id="checkbox19" value="4">
4. นมผงสำหรับเด็กอ่อน</td>
        <td valign="top"><input type="checkbox" name="v190" id="checkbox22" value="7">
7. ข้าวสารอาหารแห้ง</td>
        <td valign="top"><input type="checkbox" name="v193" id="checkbox125" value="10">
10. ผ้าอ้อมสำเร็จรูปสำหรับเด็ก</td>	
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v185" id="checkbox8" value="2">
2. ทุนการศึกษา</td>
        <td valign="top"><input type="checkbox" name="v188" id="checkbox20" value="5">
5. เครื่องนุ่งห่ม</td>
        <td valign="top"><input type="checkbox" name="v191" id="checkbox23" value="8">
8. ค่าใช้จ่ายในการเดินทางรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><input type="checkbox" name="v186" id="checkbox18" value="3">
3. เงินสงเคราะห์</td>
        <td valign="top"><input type="checkbox" name="v189" id="checkbox21" value="6">
6. ได้รับการบำบัด ฟื้นฟู</td>
        <td valign="top"><input type="checkbox" name="v192" id="checkbox24" value="9">
9. เงินค่าใช้จ่ายในการรักษาพยาบาล</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" valign="top"><button> บันทึกข้อมูล </button>          </td></td>
        <td valign="top">&nbsp;</td>
      </tr>
</table>
    </form>