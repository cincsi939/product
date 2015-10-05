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
<form method="post" onsubmit="return checkTab2();">
<input type="hidden" name="tab" value="tab2">
<input type="hidden" name="eq[eq_id]" value="<?php echo $_GET['eq_id']?>" >
<header>
	<div class="form-code">แบบ ดร. 02</div>
    <div class="clear"></div>
</header>
<main>
    <section>
    	<table width="100%" cellpadding="0" cellspacing="0">
        	<tr><td><strong>การปิดประกาศ</strong></td></tr>
            <tr><td>
            <p>
            <span class="require">ได้ปิดประกาศ 15 วันแล้ว ตามประกาศ</span>
            <input 	type="text" 
                    name="eq[announce_subject]" 
                    id="verify_tab2-1"
                    value="<?= $val['person']['announce_subject'] ?>"> 
            <span class="require">เลขที่</span>
            <input 	type="text" 
            		id="verify_tab2-2"
                    name="eq[announce_number]" 
                    value="<?= $val['person']['announce_number'] ?>"> 
            <span class="require">ลงวันที่</span>
            <input 	type="text" 
                    class="datepick" 
                    id="verify_tab2-3"
                    name="eq[announce_date]" 
                    value="<?= re_date_view_fomat($val['person']['announce_date']) ?>">
        	</p>
            </td></tr>
            <tr><td>
            <p>
            <input 	type="radio" 
            		id="verify_tab2-41"
                    onclick="valChecked2('verify_tab2-41','verify_tab2-42','verify_tab2-5','verify_tab2-6');"
                    name="eq[announce_result]" 
                    value="0" <?= $val['person']['announce_result']=='0'?'CHECKED':''?>>
            ไม่มีผู้คัดค้าน
        	</p>
            </td></tr>
            <tr><td>
            <p>
            <input 	type="radio" 
            		id="verify_tab2-42"
                    onclick="valChecked2('verify_tab2-41','verify_tab2-42','verify_tab2-5','verify_tab2-6');"
                    name="eq[announce_result]" 
                    value="1" <?= $val['person']['announce_result']=='1'?'CHECKED':''?>>
            มีผู้คัดค้าน เนื่องจาก 
            <input 	type="text" 
            		id="verify_tab2-5"
                    name="eq[announce_comment]" 
                    style="width:50%"
                    disabled="disabled"
                    value="<?= $val['person']['announce_comment'] ?>">
        	</p>
            </td></tr>
            <tr><td>
            <p>
            กรณีมีผู้คัดค้านได้ดำเนินการตรวจสอบข้อเท็จจริงแล้วพบว่า
            <input	type="text"
            		id="verify_tab2-6"
                    name="eq[announce_prove]"
                    style="width:50%"
                    disabled="disabled"
                    value="<?= $val['person']['announce_prove'] ?>">
        	</p>
            </td></tr>
        </table>
    </section>
</main>
<footer>
    <input type="submit" value="บันทึก">
    <input type="button" value="กลับหน้าหลัก" onClick="location='question_form.php'">
</footer>
</form>