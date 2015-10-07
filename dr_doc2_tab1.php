<?php
/**
* @comment ฟอร์มบันทึก ดร.02 tab1
* @projectCode
* @tor
* @package 
* @author Kiatisak  Chansawang
* @access
* @created 02/10/2558
*/
?>
<form method="post" onsubmit="return checkTab1();">
	<input type="hidden" name="tab" value="tab1">
    <input type="hidden" name="checkVal" value="<?php echo $val['person']['eq_id']?>">
	<input type="hidden" name="eq[eq_id]" value="<?php echo $_GET['eq_id']?>" >
    <header>
  <div class="center","form-code">แบบ ดร. 02</div>
        <div class="title-logo clear">
            <span>แบบรับรองสถานะของครัวเรือน</span>
        </div>
        <div class="write-at">
            <span class="require">เขียนที่</span>
            <input 	type="text" 
            		id="verify_tab1-1"
                    name="eq[write_at]" 
                    value="<?= $val['person']['write_at'] ?>">
        </div>
        <div class="clear"></div>
    </header>
    <main>
        <section>
            <?php for($i=0;$i<=1;$i++){ ?>
            <input type="hidden" name="eq_id[]" value="<?php echo $_GET['eq_id']?>" >
            <table>
                <tbody>
                    <tr><td colspan="3" class="info-head">ผู้รับรองคนที่ <?= $i+1 ?></td></tr>
                    <tr>
                        <td>1.</td>
                        <td class="require">เลขประจำตัวประชาชน</td>
                        <td>
                            <input 	type="text" 
                                    name="guarantee_idcard[]" 
                                    id="v3<?= $i+1 ?>"
                                    maxlength="13" 
                                    value="<?= $val['guarantee'][$i]['guarantee_idcard'] ?>">
                          
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td> 
                            <span class="require">ออกให้โดย</span> 
                            <input 	type="text" 
                                    name="idcard_approver_by[]" 
                                    id="verify_tab1-2<?= $i+1 ?>"
                                    value="<?= $val['guarantee'][$i]['idcard_approver_by'] ?>">
                            <span class="require">วันออกบัตร</span> 
                            <input 	type="text" 
                                    class="datepick" 
                                    id="verify_tab1-3<?= $i+1 ?>"
                                    name="idcard_issue_date[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_issue_date']) ?>">
                            <span class="require">วันหมดอายุ</span> 
                            <input 	type="text" 
                                    class="datepick" 
                                    id="verify_tab1-4<?= $i+1 ?>"
                                    name="idcard_expire_date[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_expire_date']) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td class="require">ข้าพเจ้า</td>
                        <td>
                            <select name="guarantee_prename[]" id="verify_tab1-5<?= $i+1 ?>">
                                <?php foreach($prename as $txt){ ?>
                                <option value="<?= $txt ?>" 
                                        <?= $txt==$val['guarantee'][$i]['guarantee_prename']?'SELECTED':''?>>
                                    <?= $txt ?>
                                </option>
                                <?php } ?>
                            </select>
                            <input 	type="text" 
                                    placeholder="ชื่อ" 
                                    id="verify_tab1-6<?= $i+1 ?>"
                                    name="guarantee_name[]" 
                                    value="<?= $val['guarantee'][$i]['guarantee_name'] ?>">
                            <input 	type="text" 
                                    placeholder="นามสกุล" 
                                    id="verify_tab1-7<?= $i+1 ?>"
                                    name="guarantee_surname[]" 
                                    value="<?= $val['guarantee'][$i]['guarantee_surname'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>ตำแหน่ง</td>
                        <td>
                            <input 	type="text" 
                                    name="position[]" 
                                    value="<?= $val['guarantee'][$i]['position'] ?>"> 
                            สังกัดหน่วยงาน 
                            <input 	type="text" 
                                    name="sector[]" 
                                    value="<?= $val['guarantee'][$i]['sector'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>วันเดือนปีเกิด</td>
                        <td>
                            <input 	type="text" 
                                    class="datepick1" 
                                    name="birthday[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['birthday']) ?>"> 
                            <span class="require">อายุ</span>
                            <input 	type="text" 
                                    name="age[]" 
                                    maxlength="3" 
                                    id="verify_tab1-8<?= $i+1 ?>"
                                    value="<?= $val['guarantee'][$i]['age'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>ที่อยู่อาศัย</td>
                        <td>
                            <table>
                                <tr>
                                    <td class="require">บ้านเลขที่</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_number[]" 
                                                id="verify_tab1-9<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_number'] ?>">
                                    </td>
                                    <td class="require">หมู่</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_group[]" 
                                                id="verify_tab1-10<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_group'] ?>">
                                    </td>
                                    <td>ตรอก/ซอย</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_lane[]"
                                                value="<?= $val['guarantee'][$i]['address_lane'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>ถนน</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_road[]" 
                                                value="<?= $val['guarantee'][$i]['address_road'] ?>">
                                    </td>
                                    <td class="require">จังหวัด</td>
                                    <td>
                                        <?php $province_list = getProvince(); ?>
                                        <select name="address_province[]" id="verify_tab1-11<?= $i+1 ?>">
                                            <option>กรุณาเลือกจังหวัด</option>
                                            <?php foreach($province_list as $prov){ ?>
                                                <option value="<?=$prov[ccDigi]?>" 
                                                        <?= $val['guarantee'][$i]['address_province']==$prov[ccDigi]?'SELECTED':''?>>
                                                    <?=$prov[ccName]?>
                                                </option>	
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="require">อำเภอ/เขต</td>
                                    <td>
                                        <?php $district_list = getDistrict($val['guarantee'][$i]['address_province'],'array'); ?>
                                        <select name="address_district[]" id="verify_tab1-12<?= $i+1 ?>">
                                            <option>กรุณาเลือกอำเภอ/เขต</option>
                                            <?php /*foreach($district_list as $ccDigi=>$ccName){ 
                                                <option value="<?=$ccDigi?>" 
                                                        <?= $val['guarantee'][$i]['address_district']==$ccDigi?'SELECTED':''?>>
                                                    <?=$ccName?>
                                                </option>	
                                            <?php } */?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="require">ตำบล/แขวง</td>
                                    <td>
                                        <?php $sub_district_list = getSubDistrict($val['guarantee'][$i]['address_district'],'array'); ?>
                                        <select name="address_subdistrict[]" id="verify_tab1-13<?= $i+1 ?>">
                                            <option>กรุณาเลือกตำบล/แขวง</option>
                                            <?php /*foreach($sub_district_list as $ccDigi=>$ccName){ 
                                                <option value="<?=$ccDigi?>" 
                                                        <?= $val['guarantee'][$i]['address_subdistrict']==$ccDigi?'SELECTED':''?>>
                                                    <?=$ccName?>
                                                </option>	
                                            <?php } */?>
                                        </select>
                                    </td>
                                    <td class="require">รหัสไปรษณีย์</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_postcode[]"
												size=3 
                                                maxlength="5" 
                                                id="verify_tab1-14<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_postcode'] ?>">
                                    </td>
                                    <td>โทรศัพท์</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_telephone[]" 
                                                value="<?= $val['guarantee'][$i]['address_telephone'] ?>">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>					
                </tbody>
            </table>
            <?= $i==0?'<hr>':''?>
            <?php } ?>
        </section>
        
        <section>
            <p class="indent">ขอรับรองว่า 							
                <select name="request_prename" disabled>
                    <?php foreach($prename as $p){ ?>
                    <option value="<?= $p ?>" 
                            <?= $val['eq_person']['eq_prename']==$p?'SELECTED':''?>>
                        <?= $p ?>
                    </option>
                    <?php } ?>
                </select> 
                <input 	type="text" 
                        placeholder="ชื่อ" 
                        value="<?= $val['eq_person']['eq_firstname'] ?>"
                        name="request_name" 
                        readonly> 
                <input 	type="text" 
                        placeholder="นามสกุล" 
                        value="<?= $val['eq_person']['eq_lastname'] ?>"
                        name="request_surname"
                        readonly> 
                เป็นหญิงตั้งครรภ์ที่อยู่ในครัวเรือนยากจน/เสี่ยงต่อความยากจนจริง มีรายได้ต่ำกว่า 3,000 บาท ต่อคน ต่อเดือน หรือ 36,000 บาท ต่อคน ต่อปี (รายได้รวมของสมาชิกทั้งหมดในครัวเรือนหารด้วยจำนวนสมาชิกทั้งหมดของครัวเรือนซึ่งรวมเด็กแรกเกิดด้วย)
            </p>
        </section>
        <section>
            <table width="100%" class="tableBorder">
                <tr>
                    <td width="33%" class="tdUnderBorder">ผู้รับรองคนที่ 1</td>
                    <td width="33%" class="tdUnderBorder">ผู้รับรองคนที่ 2</td>
                    <td width="33%" class="tdUnderBorder">ข้อมูลสถานะของครัวเรือน</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - กรุงเทพมหานคร : ประธานกรรมการชุมชน หรือหัวหน้าผ่ายพัฒนาชุมชนและสวัสดิการสังคมประจำสำนักงานเขต</td>
                    <td class="tdlineRight"> - กรุงเทพมหานคร : ผู้อำนวยการเขตหรือผู้ที่ได้รับมอบหมาย</td>
                    <td rowspan="4">
                        <input 	type="checkbox" 
                            name="eq[leader]" 
                            value="1"
                            <?= $val['person']['leader']==1?'CHECKED':''?>>
                    มีภาระพึ่งพิง ได้แก่ ในครอบครัวมีคนพิการ หรือ ผู้สูงอายุ หรือเด็กอายุต่ำกว่า 15 ปี หรือคนว่างงานอายุ 15 - 65 ปี หรือเป็นพ่อ/แม่เลื้ยงเดียว<br>
                        <input 	type="checkbox" 
                            name="eq[decadent_house]" 
                            value="1"
                            <?= $val['person']['decadent_house']==1?'CHECKED':''?>>
                    สภาพบ้านชำรุดทรุดโทรม บ้านทำจากวัสดุพื้นบ้าน เช่น ไม้ไผ่ ในจาก..........เป็นต้น หรือวัสดุเหลือใช้ หรืออยู่บ้านเช่า<br>
                        <input 	type="checkbox" 
                        name="eq[carless]" 
                        value="1"
                        <?= $val['person']['carless']==1?'CHECKED':''?>>
                    ไม่มีรถยนต์ส่วนบุคคล รถปิคอัพ รถบรรทุกเล็ก รถตู้<br>
                        <input 	type="checkbox" 
                            name="eq[landless]" 
                            value="1"
                            <?= $val['person']['landless']==1?'CHECKED':''?>>
                    เป็นเกษตรกรมีที่นาไม่เกิน 1 ไร่<br>
                        <input 	type="checkbox" 
                            name="eq[other]" 
                            value="1"
                            id="check_other"
                            onclick="valChecked('check_other','other_comment');"
                            <?= $val['person']['other']==1?'CHECKED':''?>>
                    อื่น ๆ (ระบุ) 
                    <input 	type="text" 
                            name="eq[other_comment]" 
                            style="width:50%"
                            id="other_comment"
                            disabled="disabled"
                            value="<?= $val['person']['other_comment'] ?>"><br>
                <p><u>หมายเหตุ</u> ต้องมีข้อมูลประกอบสถานะครัวเรือนอย่างน้อย 1 ข้อ</p>
                    </td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - เมืองพัทยา : ประธานชุมชน หรืออาสาสมัครสาธารณสุขเมืองพัทยา</td>
                    <td class="tdlineRight"> - เมืองพัทยา : ปลัดเมืองพัทยา หรือรองปลัดเมืองพัทยาที่ได้รับมอบหมาย</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - เทศบาล หรือ อบต. : อาสาสมัครพัฒนาสังคมและความมั่นคงของมนุษย์ (อพม.)หรืออาสาสมัครสาธารณสุขประจำหมู่บ้าน(อสม.)</td>
                    <td class="tdlineRight"> - เทศบาล หรือ อบต. : ปลัดเทศบาล หรือปลัด อบต. หรือผู้ที่ปลัดมอบหมาย หรือกำนันหรือผู้ใหญ่บ้าน</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - บ้านพักเด็กและครอบครัว หรือสถานสงเคราะห์ของรัฐ : เจ้าหน้าที่บ้านพักเด็กและครอบครัว หรือเจ้าหน้าที่สถานสงเคราะห์</td>
                    <td class="tdlineRight"> - บ้านพักเด็กและครอบครัว หรือสถานสงเคราะห์ของรัฐ : หัวหน้าบ้านเด็กและครอบครัว หรือผู้ปกครองสงเคราะห์</td>
                </tr>
            </table>
        </section>
        </main>
    <footer>
        <input type="submit" value="บันทึก">
        <input type="button" value="กลับหน้าหลัก" onClick="location='question_form.php'">
    </footer>
</form>