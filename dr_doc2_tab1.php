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
<form method="post" onsubmit="return checkTab1();">
	<input type="hidden" name="tab" value="tab1">
    <input type="hidden" name="checkVal" value="<?php echo $val['person']['eq_id']?>">
	<input type="hidden" name="eq[eq_id]" value="<?php echo $_GET['eq_id']?>" >
    <header>
  <div class="center","form-code">Ẻ ��. 02</div>
        <div class="title-logo clear">
            <span>Ẻ�Ѻ�ͧʶҹТͧ�������͹</span>
        </div>
        <div class="write-at">
            <span class="require">��¹���</span>
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
                    <tr><td colspan="3" class="info-head">����Ѻ�ͧ����� <?= $i+1 ?></td></tr>
                    <tr>
                        <td>1.</td>
                        <td class="require">�Ţ��Шӵ�ǻ�ЪҪ�</td>
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
                            <span class="require">�͡�����</span> 
                            <input 	type="text" 
                                    name="idcard_approver_by[]" 
                                    id="verify_tab1-2<?= $i+1 ?>"
                                    value="<?= $val['guarantee'][$i]['idcard_approver_by'] ?>">
                            <span class="require">�ѹ�͡�ѵ�</span> 
                            <input 	type="text" 
                                    class="datepick" 
                                    id="verify_tab1-3<?= $i+1 ?>"
                                    name="idcard_issue_date[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_issue_date']) ?>">
                            <span class="require">�ѹ�������</span> 
                            <input 	type="text" 
                                    class="datepick" 
                                    id="verify_tab1-4<?= $i+1 ?>"
                                    name="idcard_expire_date[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['idcard_expire_date']) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td class="require">��Ҿ���</td>
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
                                    placeholder="����" 
                                    id="verify_tab1-6<?= $i+1 ?>"
                                    name="guarantee_name[]" 
                                    value="<?= $val['guarantee'][$i]['guarantee_name'] ?>">
                            <input 	type="text" 
                                    placeholder="���ʡ��" 
                                    id="verify_tab1-7<?= $i+1 ?>"
                                    name="guarantee_surname[]" 
                                    value="<?= $val['guarantee'][$i]['guarantee_surname'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>���˹�</td>
                        <td>
                            <input 	type="text" 
                                    name="position[]" 
                                    value="<?= $val['guarantee'][$i]['position'] ?>"> 
                            �ѧ�Ѵ˹��§ҹ 
                            <input 	type="text" 
                                    name="sector[]" 
                                    value="<?= $val['guarantee'][$i]['sector'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>�ѹ��͹���Դ</td>
                        <td>
                            <input 	type="text" 
                                    class="datepick1" 
                                    name="birthday[]" 
                                    value="<?= re_date_view_fomat($val['guarantee'][$i]['birthday']) ?>"> 
                            <span class="require">����</span>
                            <input 	type="text" 
                                    name="age[]" 
                                    maxlength="3" 
                                    id="verify_tab1-8<?= $i+1 ?>"
                                    value="<?= $val['guarantee'][$i]['age'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>������������</td>
                        <td>
                            <table>
                                <tr>
                                    <td class="require">��ҹ�Ţ���</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_number[]" 
                                                id="verify_tab1-9<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_number'] ?>">
                                    </td>
                                    <td class="require">����</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_group[]" 
                                                id="verify_tab1-10<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_group'] ?>">
                                    </td>
                                    <td>��͡/���</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_lane[]"
                                                value="<?= $val['guarantee'][$i]['address_lane'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>���</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_road[]" 
                                                value="<?= $val['guarantee'][$i]['address_road'] ?>">
                                    </td>
                                    <td class="require">�ѧ��Ѵ</td>
                                    <td>
                                        <?php $province_list = getProvince(); ?>
                                        <select name="address_province[]" id="verify_tab1-11<?= $i+1 ?>">
                                            <option>��س����͡�ѧ��Ѵ</option>
                                            <?php foreach($province_list as $prov){ ?>
                                                <option value="<?=$prov[ccDigi]?>" 
                                                        <?= $val['guarantee'][$i]['address_province']==$prov[ccDigi]?'SELECTED':''?>>
                                                    <?=$prov[ccName]?>
                                                </option>	
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="require">�����/ࢵ</td>
                                    <td>
                                        <?php $district_list = getDistrict($val['guarantee'][$i]['address_province'],'array'); ?>
                                        <select name="address_district[]" id="verify_tab1-12<?= $i+1 ?>">
                                            <option>��س����͡�����/ࢵ</option>
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
                                    <td class="require">�Ӻ�/�ǧ</td>
                                    <td>
                                        <?php $sub_district_list = getSubDistrict($val['guarantee'][$i]['address_district'],'array'); ?>
                                        <select name="address_subdistrict[]" id="verify_tab1-13<?= $i+1 ?>">
                                            <option>��س����͡�Ӻ�/�ǧ</option>
                                            <?php /*foreach($sub_district_list as $ccDigi=>$ccName){ 
                                                <option value="<?=$ccDigi?>" 
                                                        <?= $val['guarantee'][$i]['address_subdistrict']==$ccDigi?'SELECTED':''?>>
                                                    <?=$ccName?>
                                                </option>	
                                            <?php } */?>
                                        </select>
                                    </td>
                                    <td class="require">������ɳ���</td>
                                    <td>
                                        <input 	type="text" 
                                                name="address_postcode[]"
												size=3 
                                                maxlength="5" 
                                                id="verify_tab1-14<?= $i+1 ?>"
                                                value="<?= $val['guarantee'][$i]['address_postcode'] ?>">
                                    </td>
                                    <td>���Ѿ��</td>
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
            <p class="indent">���Ѻ�ͧ��� 							
                <select name="request_prename" disabled>
                    <?php foreach($prename as $p){ ?>
                    <option value="<?= $p ?>" 
                            <?= $val['eq_person']['eq_prename']==$p?'SELECTED':''?>>
                        <?= $p ?>
                    </option>
                    <?php } ?>
                </select> 
                <input 	type="text" 
                        placeholder="����" 
                        value="<?= $val['eq_person']['eq_firstname'] ?>"
                        name="request_name" 
                        readonly> 
                <input 	type="text" 
                        placeholder="���ʡ��" 
                        value="<?= $val['eq_person']['eq_lastname'] ?>"
                        name="request_surname"
                        readonly> 
                ��˭ԧ��駤����������㹤������͹�ҡ��/����§��ͤ����ҡ����ԧ ��������ӡ��� 3,000 �ҷ ��ͤ� �����͹ ���� 36,000 �ҷ ��ͤ� ��ͻ� (���������ͧ��Ҫԡ������㹤������͹��ô��¨ӹǹ��Ҫԡ�������ͧ�������͹���������á�Դ����)
            </p>
        </section>
        <section>
            <table width="100%" class="tableBorder">
                <tr>
                    <td width="33%" class="tdUnderBorder">����Ѻ�ͧ����� 1</td>
                    <td width="33%" class="tdUnderBorder">����Ѻ�ͧ����� 2</td>
                    <td width="33%" class="tdUnderBorder">������ʶҹТͧ�������͹</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - ��ا෾��ҹ�� : ��иҹ������ê���� �������˹�Ҽ��¾Ѳ�Ҫ����������ʴԡ���ѧ����Ш��ӹѡ�ҹࢵ</td>
                    <td class="tdlineRight"> - ��ا෾��ҹ�� : ����ӹ�¡��ࢵ���ͼ�������Ѻ�ͺ����</td>
                    <td rowspan="4">
                        <input 	type="checkbox" 
                            name="eq[leader]" 
                            value="1"
                            <?= $val['person']['leader']==1?'CHECKED':''?>>
                    �����о�觾ԧ ���� 㹤�ͺ�����դ��ԡ�� ���� ����٧���� ���������ص�ӡ��� 15 �� ���ͤ���ҧ�ҹ���� 15 - 65 �� �����繾��/�������§����<br>
                        <input 	type="checkbox" 
                            name="eq[decadent_house]" 
                            value="1"
                            <?= $val['person']['decadent_house']==1?'CHECKED':''?>>
                    ��Ҿ��ҹ���ش��ش��� ��ҹ�Өҡ��ʴؾ�鹺�ҹ �� ����� 㹨ҡ..........�繵� ������ʴ�������� ���������ҹ���<br>
                        <input 	type="checkbox" 
                        name="eq[carless]" 
                        value="1"
                        <?= $val['person']['carless']==1?'CHECKED':''?>>
                    �����ö¹����ǹ�ؤ�� ö�Ԥ�Ѿ ö��÷ء��� ö���<br>
                        <input 	type="checkbox" 
                            name="eq[landless]" 
                            value="1"
                            <?= $val['person']['landless']==1?'CHECKED':''?>>
                    ���ɵá��շ�������Թ 1 ���<br>
                        <input 	type="checkbox" 
                            name="eq[other]" 
                            value="1"
                            id="check_other"
                            onclick="valChecked('check_other','other_comment');"
                            <?= $val['person']['other']==1?'CHECKED':''?>>
                    ��� � (�к�) 
                    <input 	type="text" 
                            name="eq[other_comment]" 
                            style="width:50%"
                            id="other_comment"
                            disabled="disabled"
                            value="<?= $val['person']['other_comment'] ?>"><br>
                <p><u>�����˵�</u> ��ͧ�բ����Ż�СͺʶҹФ������͹���ҧ���� 1 ���</p>
                    </td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - ���ͧ�ѷ�� : ��иҹ����� ����������Ѥ��Ҹ�ó�آ���ͧ�ѷ��</td>
                    <td class="tdlineRight"> - ���ͧ�ѷ�� : ��Ѵ���ͧ�ѷ�� �����ͧ��Ѵ���ͧ�ѷ�ҷ�����Ѻ�ͺ����</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - �Ⱥ�� ���� ͺ�. : ������ѤþѲ���ѧ����Ф�����蹤��ͧ������ (;�.)����������Ѥ��Ҹ�ó�آ��Ш������ҹ(���.)</td>
                    <td class="tdlineRight"> - �Ⱥ�� ���� ͺ�. : ��Ѵ�Ⱥ�� ���ͻ�Ѵ ͺ�. ���ͼ�����Ѵ�ͺ���� ���͡ӹѹ���ͼ���˭��ҹ</td>
                </tr>
                <tr>
                    <td class="tdlineRight"> - ��ҹ�ѡ����Ф�ͺ���� ����ʶҹʧ������ͧ�Ѱ : ���˹�ҷ���ҹ�ѡ����Ф�ͺ���� �������˹�ҷ��ʶҹʧ������</td>
                    <td class="tdlineRight"> - ��ҹ�ѡ����Ф�ͺ���� ����ʶҹʧ������ͧ�Ѱ : ���˹�Һ�ҹ����Ф�ͺ���� ���ͼ�黡��ͧʧ������</td>
                </tr>
            </table>
        </section>
        </main>
    <footer>
        <input type="submit" value="�ѹ�֡">
        <input type="button" value="��Ѻ˹����ѡ" onClick="location='question_form.php'">
    </footer>
</form>