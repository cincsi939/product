<?php
/**
* @comment ������ѹ�֡ ��.02 tab1
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
	<div class="form-code">Ẻ ��. 02</div>
    <div class="clear"></div>
</header>
<main>
    <section>
    	<table width="100%" cellpadding="0" cellspacing="0">
        	<tr><td><strong>��ûԴ��С��</strong></td></tr>
            <tr><td>
            <p>
            <span class="require">��Դ��С�� 15 �ѹ���� �����С��</span>
            <input 	type="text" 
                    name="eq[announce_subject]" 
                    id="verify_tab2-1"
                    value="<?= $val['person']['announce_subject'] ?>"> 
            <span class="require">�Ţ���</span>
            <input 	type="text" 
            		id="verify_tab2-2"
                    name="eq[announce_number]" 
                    value="<?= $val['person']['announce_number'] ?>"> 
            <span class="require">ŧ�ѹ���</span>
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
            ����ռ��Ѵ��ҹ
        	</p>
            </td></tr>
            <tr><td>
            <p>
            <input 	type="radio" 
            		id="verify_tab2-42"
                    onclick="valChecked2('verify_tab2-41','verify_tab2-42','verify_tab2-5','verify_tab2-6');"
                    name="eq[announce_result]" 
                    value="1" <?= $val['person']['announce_result']=='1'?'CHECKED':''?>>
            �ռ��Ѵ��ҹ ���ͧ�ҡ 
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
            �ó��ռ��Ѵ��ҹ����Թ��õ�Ǩ�ͺ����稨�ԧ���Ǿ����
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
    <input type="submit" value="�ѹ�֡">
    <input type="button" value="��Ѻ˹����ѡ" onClick="location='question_form.php'">
</footer>
</form>