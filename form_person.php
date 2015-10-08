<?php
$p_id = $_GET['p_id'];
//print_r($_POST);
require_once("functions.php");
if($_POST['b_save']){
			if($_POST['day'] == ''){
				$_POST['day'] = '01';
			}else{
				$_POST['day'] =  sprintf("%'.02d\n", $_POST['day']);
			}
			
			if($_POST['month'] == ''){
				$_POST['month'] = '01';
			}else{
				$_POST['month'] =  sprintf("%'.02d\n", $_POST['month']);
			}
	if($_POST['services_ID'] != '' && $_POST['sv_received_ID'] != ''){
		$sql="UPDATE sv_temp_trans SET status_trans = 'Y',agency_received = '".$_POST['agency_received']."' WHERE services_ID='".$_POST['services_ID']."' AND sv_received_ID='".$_POST['sv_received_ID']."'";
		$query = mysql_db_query(DB_OSCC, $sql) or die("Query Error " .mysql_error());
		//echo $sql;//exit;
	}
    //Update
    if($_POST['p_id'] != '' ){
            if($_POST['action_new']=='new'){
                    $arr_p_join_date = explode("/",$_POST['p_join_date']);
                    $p_join_date = ($arr_p_join_date[2]-543).'-'.$arr_p_join_date[1].'-'.$arr_p_join_date[0].' '.$_POST['hourinput'].':'.$_POST['minuteinput'].':00';
                    $arr_join_number = explode('-',$_POST['p_join_number']);
                    $sql_join_number_ref = "INSERT INTO personal_join_number_ref 
                                        SET   p_id='".$_POST['p_id']."', gid='".$_SESSION['GID']."', staffid='".$_SESSION['STAFFID']."', 
                                        p_join_date='".$p_join_date."', p_join_number='".$_POST['p_join_number']."', 
                                        p_join_yy='".$arr_p_join_date[2]."', office_id='".$arr_join_number[1]."', p_join_num='".$arr_join_number[2]."', 
                                        active='3', record_date=NOW(), last_update=NOW()
                                        ";
                    mysql_db_query($dbname, $sql_join_number_ref);
            }
			$arr_p_birthdate=array($_POST['day'],$_POST['month'],$_POST['year']);
			
            /*$arr_p_birthdate[2];
            $arr_p_birthdate[1]; 
            $arr_p_birthdate[0];*/ 
            //$arr_p_birthdate = explode("/",$_POST['p_birthdate']);
           
            $p_birthdate = trim($arr_p_birthdate[2]).'-'.trim($arr_p_birthdate[1]).'-'.trim($arr_p_birthdate[0]);
            $arr_p_join_date = explode("/",$_POST['p_join_date']);
            $p_join_date = ($arr_p_join_date[2]-543).'-'.$arr_p_join_date[1].'-'.$arr_p_join_date[0].' '.$_POST['hourinput'].':'.$_POST['minuteinput'].':00';
            
            
            
            $sql = " UPDATE general  
                            SET idcard_type='".$_POST['idcard_type']."', citizen_id='".$_POST['citizen_id']."', 
                            prename_id='".$_POST['prename_id']."', p_firstname='".$_POST['p_firstname']."', p_lastname='".$_POST['p_lastname']."', 
                            p_nickname='".$_POST['p_nickname']."',
                            gid='".$_SESSION['GID']."', p_join_number='".$_POST['p_join_number']."',
                            p_join_date='".$p_join_date."', p_gender='".$_POST['p_gender']."',
                            p_birthdate='".$p_birthdate."', race_id='".$_POST['race_id']."', 
                            nationality_id='".$_POST['nationality_id']."', religion_id='".$_POST['religion_id']."',
                            last_update=NOW(), staffid='".$_SESSION['STAFFID']."',etc='".$_POST['idcard_type5']."',
							birthdayreal='".$_POST['birthdayreal']."'
                            WHERE p_id='".$_POST['p_id']."'
                             ";
            //echo $sql;
            $query = mysql_db_query($dbname, $sql); 
            
            $update_join_num_ref = "UPDATE personal_join_number_ref 
                                                    SET p_join_date = '".$p_join_date."' WHERE p_id='".$_POST['p_id']."' and p_join_number = '".$_GET['p_join_number']."'
                                                    ";
            $query_join_num_ref = mysql_db_query($dbname, $update_join_num_ref);                                            
            
            if($query){
                echo "<script>
                alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                window.location.href='?p=form_person&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
                </script>";
                exit(); 
            }else{
               echo "<script>
                alert('ไม่สามารถบันทึกข้อมูลได้');
                window.location.href='?p=form_person&p_id=".$_POST['p_id']."&p_join_number=".$_POST['p_join_number']."';
                </script>";
                exit();
            }
    }else{//Add
    $sqlckidcard = "SELECT
                                general.p_id,
                                general.idcard_type,
                                general.citizen_id,
                                general.p_join_number,
                                general.staffid,
                                general.etc,
                                personal_join_number_ref.active,
                                personal_join_number_ref.last_update
                            FROM
                                general INNER JOIN personal_join_number_ref ON general.p_id = personal_join_number_ref.p_id
                            where 
                                citizen_id='".$_POST['citizen_id']."' and
                                idcard_type='".$_POST['idcard_type']."' and 
                                general.gid ='".$_SESSION['GID']."'
                                ORDER BY personal_join_number_ref.last_update DESC";
								
            $sqlckidcard_data= mysql_db_query(DB_MASTER, $sqlckidcard);
            $dataqueryidcard = mysql_fetch_assoc($sqlckidcard_data);
            $statusActive = $dataqueryidcard['active'];
            $rowpid = $dataqueryidcard['p_id'];
            $rowpjoin = $dataqueryidcard['p_join_number'];
            $ckidcard = mysql_num_rows($sqlckidcard_data);
			
            if($ckidcard >0 ){
                /*
                if($statusActive==2){
                    ?>
    <script>
    var con = confirm("มีข้อมูลผู้รับบริการเลขประจำตัว <? echo $_POST['citizen_id'] ?> ในระบบแล้ว\n (เลขประจำตัวนี้เคยถูกจำหน่ายแล้ว)");
    if (con == true) {
        window.location = '?p=form_person&p_id=<? echo $rowpid;?>&p_join_number=<? echo $rowpjoin;?>';
    } else {
        window.location = '?p=form_person';
        return false;
    }
    </script>
    <?
                } */
                if($statusActive == 3 &&  $_POST['idcard_type'] != 3){
				//$msg_con =  'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อมูลเลขบัตรประจำตัว '.$_POST['citizen_id'].' อยู่ในหน่วยงานและยังไม่ได้จำหน่าย\nหากท่านต้องการเพิ่มข้อมูลการรับเข้าใหม่  กรุณาปรับปรุงสถานะข้อมูลเดิมให้เป็นจำหน่ายแล้ว' ;
				//$link_con = '?p=form_person&p_id='.$rowpid.'&p=form_distribution_list&p_join_number='.$rowpjoin;
				//	echo '<script>confirm("'.$msg_con.'");window.location.href="'.$link_con.'"</script>';
					//echo "return confirm('a');";
					//echo '</script>';
				
                ?>
				
				<script type="text/javascript">
					confirmDuplicate(<?php echo $_POST['citizen_id'] ?>,<?php echo $rowpid ?>,'<?php echo $dataqueryidcard['p_join_number']; ?>');
					function confirmDuplicate(id_card,p_id,p_join) {
						if (confirm('ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อมูลเลขบัตรประจำตัว '+id_card+' อยู่ในหน่วยงานและยังไม่ได้จำหน่าย\nหากท่านต้องการเพิ่มข้อมูลการรับเข้าใหม่  กรุณาปรับปรุงสถานะข้อมูลเดิมให้เป็นจำหน่ายแล้ว')) {
							window.location.href = '?p=form_person&p_id='+p_id+'&p_join_number='+p_join+'';

						}else{
							window.history.back();
						}
					}
					
				</script>

        <?php
				exit();
			
                }
            }
				
            $sqlckidcard2 = "SELECT
                                general.p_id,
                                general.idcard_type,
                                general.citizen_id,
                                general.p_join_number,
                                general.staffid,
                                general.etc,
                                personal_join_number_ref.active,
                                personal_join_number_ref.last_update
                            FROM
                                general INNER JOIN personal_join_number_ref ON general.p_id = personal_join_number_ref.p_id
                            where 
                                citizen_id='".$_POST['citizen_id']."' and
                                idcard_type='".$_POST['idcard_type']."' and 
                                personal_join_number_ref.gid !='".$_SESSION['GID']."'
                                ORDER BY personal_join_number_ref.last_update DESC";
            $sqlckidcard_data2= mysql_db_query(DB_MASTER, $sqlckidcard2);
            $dataqueryidcard2 = mysql_fetch_assoc($sqlckidcard_data2);
            $statusActive2 = $dataqueryidcard2['active'];
            $rowpid2 = $dataqueryidcard2['p_id'];
            $rowpjoin2 = $dataqueryidcard2['p_join_number'];
            $ckidcard2 = mysql_num_rows($sqlckidcard_data2);
                if($ckidcard2 >0 &&  $_POST['idcard_type'] != 3){
                    ?>
					<script type="text/javascript">
					confirmDuplicate(<?php echo $_POST['citizen_id'] ?>,<?php echo $rowpid2 ?>,'<?php echo $_POST['p_join_number']; ?>');
					function confirmDuplicate(id_card,p_id,p_join) {
						if (confirm('พบเลขประจำตัวประชาชน '+id_card+' หากท่านต้องการเพิ่มข้อมูล ระบบจะโอนถ่ายข้อมูลจากหน้ารายการเดิมมาให้อัตโนมัต กรุณากดปุ่มยืนยัน')) {
							window.location.href = '?p=form_person&p_id='+p_id+'&p_join_number='+p_join+'&action=new';

            } else {
                window.history.back();
						}
					}
					
            </script>
            
				<?php
					exit();
                }
                
                
               /*$arr_p_birthdate[2] = $_POST['year'];
            $arr_p_birthdate[1] = $_POST['month'];
            $arr_p_birthdate[0] = $_POST['day'];*/
            //$arr_p_birthdate = explode("/",$_POST['p_birthdate']);

			$arr_p_birthdate = array($_POST['day'],$_POST['month'],$_POST['year']);			
            $p_birthdate = trim($arr_p_birthdate[2]).'-'.trim($arr_p_birthdate[1]).'-'.trim($arr_p_birthdate[0]);
            $arr_p_join_date = explode("/",$_POST['p_join_date']);
            $p_join_date = ($arr_p_join_date[2]-543).'-'.$arr_p_join_date[1].'-'.$arr_p_join_date[0].' '.$_POST['hourinput'].':'.$_POST['minuteinput'].':00';
			
            $sql = "    INSERT INTO general  
                            SET idcard_type='".$_POST['idcard_type']."', citizen_id='".$_POST['citizen_id']."', 
                            prename_id='".$_POST['prename_id']."', p_firstname='".$_POST['p_firstname']."', p_lastname='".$_POST['p_lastname']."', 
                            p_nickname='".$_POST['p_nickname']."',
                            gid='".$_SESSION['GID']."', p_join_number='".$_POST['p_join_number']."',
                            p_join_date='".$p_join_date."', p_gender='".$_POST['p_gender']."',
                            p_birthdate='".$p_birthdate."', race_id='".$_POST['race_id']."', 
                            nationality_id='".$_POST['nationality_id']."', religion_id='".$_POST['religion_id']."',
                            record_date=NOW(), last_update=NOW(), staffid='".$_SESSION['STAFFID']."',etc='".$_POST['idcard_type5']."',birthdayreal='".$_POST['birthdayreal']."'
                             ";
            mysql_db_query($dbname, $sql);
            $p_id = mysql_insert_id();
            
            $arr_join_number = explode('-',$_POST['p_join_number']);
            $sql_join_number_ref = "INSERT INTO personal_join_number_ref 
                                SET   p_id='".$p_id."', gid='".$_SESSION['GID']."', staffid='".$_SESSION['STAFFID']."', 
                                p_join_date='".$p_join_date."', p_join_number='".$_POST['p_join_number']."', 
                                p_join_yy='".$arr_p_join_date[2]."', office_id='".$arr_join_number[1]."', p_join_num='".$arr_join_number[2]."', 
                                active='3', record_date=NOW(), last_update=NOW()
                                ";
            mysql_db_query($dbname, $sql_join_number_ref);
            $sql_personal_name = "  INSERT INTO personal_name 
                            SET p_id='".$p_id."', 
                            prename_id='".$_POST['prename_id']."', p_firstname='".$_POST['p_firstname']."', p_lastname='".$_POST['p_lastname']."', 
                            p_nickname='".$_POST['p_nickname']."', 
                            active='2', gid='".$_SESSION['GID']."', 
                            record_date=NOW(), last_update=NOW(), staffid='".$_SESSION['STAFFID']."'
                            ";
            $query_personal_name = mysql_db_query($dbname, $sql_personal_name);             
            if($query_personal_name){
                
                echo "<script>
                alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                window.location.href='?p=form_person&p_id=".$p_id."&p_join_number=".$_POST['p_join_number']."';
                </script>";
                exit(); 
            }else{
                echo "<script>
                alert('ไม่สามารถบันทึกข้อมูลได้');
                window.location.href='?p=form_person&p_id=".$p_id."&p_join_number=".$_POST['p_join_number']."';
                </script>";
                exit(); 
            }
                
    }
	
}

if($_GET['action'] == 'delete'){
    if($_GET['id'] != ''){
            $sql_del = "UPDATE personal_join_number_ref SET active='1' WHERE id='".$_GET['id']."' ";
            $query_del = mysql_db_query($dbname, $sql_del);     
            if($query_del){
                    echo "<script>
                                alert('ลบข้อมูลเรียบร้อยแล้ว');
                                window.location.href='?p_id=".$_POST['p_id']."';
                                </script>";
                    exit(); 
            }else{
                echo "<script>
                                alert('ไม่สามารถลบข้อมูลได้');
                                window.location.href='?p_id=".$_POST['p_id']."';
                                </script>";
                    exit(); 
            }
    }
}

?>
                <style>
                .txtInputAlert input {
                    border: #F00 1px solid;
                }
                
                .txtInput input {
                    border: #000000 1px solid;
                }
                </style>
                <script src="../../common/SMLcore/TheirParty/js/jquery-1.8.1.min.js"></script>
                <link href="../../common/SMLcore/Plugin/DatepickerTh/zebra_datepicker.css" rel="stylesheet">
                <script src="../../common/DatepickerTh/ZebraDatepickerTh.min.js"></script>
                <script src="../../common/Script_CheckIdCard.js"></script>
                <script src="js/function_person.js"></script>
                <script type="text/javascript">
                $(function() {

                    $("input[name='p_gender']").click(function() {
                        var r = confirm('ยืนยันการเปลี่ยนเแปลงข้อมูลเพศ')
                        if (r == true) {} else {
                            return false;
                        }
                    });

                    // เช็คประเภทบัตร
                    var str = "";
                    $("#idcard_type")
                        .change(function() {
                            $("#idcard_type option:selected").each(function() {
                                str = $(this).val();
                            });
                        })
                        .trigger("change");

                    $("#b_save").click(function() {
                        if (str == 1) {
                            if ($("#idcard1,#idcard2,#idcard3,#idcard4,#idcard5").val() == "") {
                                alert("กรุณากรอกบัตรประจำตัวประชาชน");
                                return false;
                            }
                        } else if (str == 2) {
                            if ($("#idcard").val() == "") {
                                alert("กรุณากรอกข้อมูลบัตรประจำตัวบุคคลต่างด้าว");
                                return false;
                            }
                        }
                        if ($("input[name='p_birthdate']").val() == "") {
                            alert('กรุณากรอกข้อมูลวันเดือนปีเกิด');
                            return false;
                        }
                    });

                });

                function alertFn(id, type, textalert) {
                    var typesymbol = "";
                    if (type == "class") {
                        var typesymbol = ".";
                    } else if (type == "id") {
                        var typesymbol = "#";
                    }
                    var keysearch = typesymbol.concat(id);
                    if ($(keysearch).val() == "") {
                        alert(textalert);
                        $(keysearch).focus();
                        return false;
                    }
                }
                </script>
                <script type="text/javascript">
                function check_specail_cha(text, id) {
                    var special_cha = /([.*+?^=!:@${}()|\[\]\/\\])/g;
                    var idsearch = ".textnotification" + id;
                    if (special_cha.test(text)) {
                        $(idsearch).text('ไม่สามารถใส่อักขระพิเศษได้');
                    } else {
                        $(idsearch).text('');
                    }
                }


                function checkPerson(id, gid, type_citizen) {
                    link_page = 'ajax.checkperson.php?citizen_id=' +  id + '&gid=' + gid + '&type_citizen=' + type_citizen;
                    $.get(link_page, function(data) {
                        var text = data;
                        var obj = JSON.parse(text);
                        if (obj.statusquery == 1) { //"สถานะจำหน่าย";
                            var con1 = confirm('เลขประจำตัวนี้ถูกจำหน่ายไปแล้ว ยืนยันการใช้เลขประจำตัว ?')
                            if (con1 == true) {
                                window.location.href = '?p=form_person&p_id=' + obj.p_id + '&p_join_number=' + obj.p_join_number;
                            } else {}
                        } else if (obj.statusquery == 2) { //"สถานะยังอยู่ในระบบ";
                            var con2 = confirm('ไม่สามารถเพิ่มเลขประจำตัวนี้ได้ เนื่องจากมีผู้ใช้งานเลขประจำตัวนี้อยู่ในหน่วยงานนี้แล้ว')
                            if (con2 == true) {} else {
                                document.getElementById("idcard").value = '';
                            }
                        } else if (obj.statusquery == 3) {
                            alert('เลขประจำตัวนี้ ถูกลบจากระบบแล้ว')
                        } else if (obj.statusquery == 4) { //"คนละหน่วยงาน";
                            var con4 = confirm('มีเลขประจำตัวนี้อยู่ในหน่วยงานอื่นแล้ว คุณต้องการใช้เลขประจำตัวนี้หรือไม่ ?')
                            if (con == false) {
                                document.getElementById("idcard").value = '';
                                return false;
                            }
                        }

                    });
                }


                function checkWhiteSpace(str) {
                    var patt1 = /\s/g;
                    var result = str.match(patt1);
                    return result.length;
                }
                $(document).ready(function() {
				

                    // assuming the controls you want to attach the plugin to 
                    // have the "datepicker" class set
                    $('.datepicker').Zebra_DatePicker({
                        format: 'd/m/Y',
                        readonly_element: false,
                            //direction: [true, '<?php echo date('d/m/').(date('Y')+543);?>' ]
                            direction: [false, '<?php echo date('d/m/Y').(date('Y')+543);?>' ]
                    });

                });
                </script><script>
				$(document).ready(function() {
					//var idcard1,idcard2,idcard3,idcard4,idcard5;
	                var idcard1 = document.getElementById('idcard1').value;
				var idcard2 = document.getElementById('idcard2').value;
				var idcard3 = document.getElementById('idcard3').value;
				var idcard4 = document.getElementById('idcard4').value;
				var idcard5 = document.getElementById('idcard5').value;
				if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}
					$( "#idcard1" ).keyup(function() {
					idcard1 = $("#idcard1").val();
					if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}
					});

					$( "#idcard2" ).keyup(function() {
						idcard2 = $("#idcard2").val();
						if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}

					});
					$( "#idcard3" ).keyup(function() {
						idcard3 = $("#idcard3").val();
						if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}

					});
					$( "#idcard4" ).keyup(function() {
						idcard4 = $("#idcard4").val();
						if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}

					});
					$( "#idcard5" ).keyup(function() {
					idcard5 = $("#idcard5").val();
					if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singha.png' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}else{

				var textdetail = "<a onclick='checkIDnumber();'><img src='images/singhawhite.jpg' width='25px' style='margin-left:10px;vertical-align: middle;cursor:pointer;' alt='ตรวจสอบเลขบัตรประชาชน' title='ตรวจสอบเลขบัตรประชาชน'></a>"
				$( "#checkDetail" ).html(textdetail);
				
				}

					});


				
				});
		
function checkIDnumber(){
                var idcard1 = document.getElementById('idcard1').value;
				var idcard2 = document.getElementById('idcard2').value;
				var idcard3 = document.getElementById('idcard3').value;
				var idcard4 = document.getElementById('idcard4').value;
				var idcard5 = document.getElementById('idcard5').value;
				if(idcard1!=''&&idcard2!=''&&idcard3!=''&&idcard4!=''&&idcard5!=''){
                MM_openBrWindow('showpopupid.php?idcard1='+idcard1+'&idcard2='+idcard2+'&idcard3='+idcard3+'&idcard4='+idcard4+'&idcard5='+idcard5,'10showpopupid','scrollbars=yes,width=700,height=450');
				}else{
				alert('กรุณากรอกเลขบัตรให้ครบทุกช่อง');
				}
        }
				</script>
                <?php 
$actionNew = ($_GET['action'] != '')?$_GET['action']:'';
$action = ($p_id != '')?'edit':'add';
$readonly = ($p_id != '')?'readonly':'add';

$sql = "SELECT * FROM `general`  WHERE p_id='".$p_id."'  ";
$query =  mysql_db_query( $dbname, $sql );
$row = mysql_fetch_assoc($query);

?>
                    <table style=" margin-left:50px;" width="90%" border="0">
                        <tr>
                            <td width="79%" align="left" valign="top">
                                <form action="" method="post" enctype="multipart/form-data" name="form1" onsubmit="return chkForm('<?php echo date('d/m/').(date('Y')+543)?>');">
                                    <p><img src="index_files/Folder-icon.png" alt="" width="21" height="21" align="absmiddle"> <span class="redlink">แบบฟอร์มบันทึกประวัติส่วนตัว</span></p>
                                    <br/>
                                    <table style=" margin-left:50px;" width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td width="17%" align="right" class="13_bold"><strong>วันที่รับเข้า</strong><span style="color:#FF0000;">*</span></td>
                                            <td width="83%">
                                                <?php
             if($actionNew == 'new'){
                    $arr_p_join_date = explode("-", date('Y-m-d'));
            }else{
                $time_p_join_date=substr($row['p_join_date'],11,15);
                $arrtime_p_join_date = explode(":", $time_p_join_date);
                    $date_p_join_date=substr($row['p_join_date'],0,10);
                    $arr_p_join_date = explode("-", $date_p_join_date);
            }
                
              if($row['p_join_date'] != '0000-00-00' && $row['p_join_date'] != '' ){
                $p_join_date = $arr_p_join_date[2].'/'.$arr_p_join_date[1].'/'.($arr_p_join_date[0]+543);
              }else{
                  $p_join_date = '';
              }
          ?>
                                                    <input type="text" name="p_join_date" id="p_join_date" class="datepicker" onchange="cal_join_date();" size="15" value="<?php 
          if($p_join_date==''){
          $hh = date("d/m/");
        $yyy= date("Y ");
        $yyy +=543;
        echo $hh.''.$yyy;
          }else{
          echo $p_join_date;
          }
?>" /> รูปแบบวันที่ วัน/เดือน/ปี(15/01/2557)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="17%" align="right" class="13_bold"><strong>เวลาที่รับเข้า</strong></td>
                                            <td width="83%">
                                                <select id="hourinput" name="hourinput">
                                                    <?php
             
                for($rr=0;$rr<=23;$rr++){
                    if($rr<=9){
                    $rr='0'.$rr;
                    }
                    if($arrtime_p_join_date[0]!=''){
                    if($arrtime_p_join_date[0]==$rr){
                        $showselected = 'selected';
                        }else{
                        $showselected = '';
                        }

                    }else {
                    $timeter = date("H");
                    if($timeter==$rr){
                        $showselected = 'selected';
                        }else{
                        $showselected = '';
                        }
                    }
             echo '<option value="'.$rr.'" '.$showselected.'>'.$rr.'</option>';
          }
              ?>
                                                </select> :
                                                <select id="minuteinput" name="minuteinput">
                                                    <?php
                for($zz=0;$zz<=59;$zz++){
                    if($zz<=9){
                    $zz='0'.$zz;
                    }
                    if($arrtime_p_join_date[1]!=''){
                    if($arrtime_p_join_date[1]==$zz){
                        $showselected = 'selected';
                        }else{
                        $showselected = '';
                        }
                    }else {
                    $timeterz = date("i");
                    if($timeterz==$zz){
                        $showselected = 'selected';
                        }else{
                        $showselected = '';
                        }
                    }
             echo '<option value="'.$zz.'" '.$showselected.'>'.$zz.'</option>';
          }
              ?>
                                                </select> น.
                                            </td>
                                        </tr>
										
										<tr> <td width="17%" align="right" class="13_bold"><strong>อายุแรกรับ</strong></td>
                                           
												
												<td width="83%"><font color="#FF0000"><strong id="cal_firstage">
												<?php
													$sqlage = mysql_query("SELECT * FROM general WHERE p_id='$p_id'");
													$queryage = mysql_fetch_assoc($sqlage);
													
													$queryage['p_birthdate'] = ($_POST['birthday'] != '' && $queryage['p_birthdate'] == '') ? $_POST['birthday'] : $queryage['p_birthdate'];
													$queryage['p_join_date'] = ($queryage['p_join_date'] == '') ? date('Y-m-d') : $queryage['p_join_date'];
													if($queryage['p_birthdate']==''){
														echo "-";														
													}else{
													 			$pjoin = substr($queryage['p_join_date'],0,10);
																$birthday = $queryage['p_birthdate'];      //รูปแบบการเก็บค่าข้อมูลวันเกิด
																$today = $pjoin;   //จุดต้องเปลี่ยน

																list($byear, $bmonth, $bday)= explode("-",$birthday);       //จุดต้องเปลี่ยน
																list($tyear, $tmonth, $tday)= explode("-",$today);                //จุดต้องเปลี่ยน

																$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
																$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
																$mage = ($mnow - $mbirthday);

  														$u_y=date("Y", $mage)-1970;
															$u_m=date("m",$mage)-1;
															$u_d=date("d",$mage)-1;

															echo"$u_y   ปี    $u_m เดือน  ";
													}


													

													
												?></strong></font></td>
												
										</tr>
                                        <tr>
											
                                            <td class="13_bold" align="right"><strong>เลขที่รับเข้า</strong></td>
                                            <td>
                                                <?php
            if($row['p_id'] != '' && $actionNew != 'new'){
                    $p_join_number = $row['p_join_number'];
            }else if($row['p_id'] != '' && $actionNew == 'new'){
                    echo "<script>
                    var myVar_join_number = setInterval(function(){ calJoinNumber(".$_SESSION['GID'].", $('#p_join_date').val()) }, 2000);
                    </script>";
            }else{
                    echo "<script>
                    var myVar_join_number = setInterval(function(){ calJoinNumber(".$_SESSION['GID'].", $('#p_join_date').val()) }, 2000);
                    </script>";
            }
            ?>
                                                    <font color="#FF0000"><strong><span id='p_join_number_show'><?php echo $p_join_number;?></span></strong></font>
                                                    <input type="hidden" name="p_join_number" id="p_join_number" value="<?php echo $p_join_number;?>" />
                                            </td>
                                        </tr>
                                    </table>
                                    <hr color="#CCC" width="97%" style="margin-top:10px; margin-bottom:10px;">
                                    <table style=" margin-left:50px;" width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td align="right" class="13_bold"><strong>ประเภทบัตร</strong><span id="idcard_type_verify"></span></td>
                                            <td>
											<?php
											$idcard_type = $row['idcard_type'];
											$passport = $row['citizen_id'];
											if($_POST['passport']!='' && trim($_POST['passport'])!='-'){
												$idcard_type = 2;
												$passport = $_POST['passport'];
											}
											?>
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td width="30%">
                                                            <select name="idcard_type" id="idcard_type" onchange="changeIDcardType(this.value);">
                                                                <option value="1" <?php echo ($idcard_type==1 )? 'selected': ''; ?> >บัตรประจำตัวประชาชน</option>
                                                                <option value="2" <?php echo ($idcard_type==2 )? 'selected': ''; ?> >บัตรประจำตัวบุคคลต่างด้าว</option>
                                                                <option value="3" <?php echo ($idcard_type==3 )? 'selected': ''; ?> >ไม่มีข้อมูลบัตรประจำตัว</option>
                                                                <option value="4" <?php echo ($idcard_type==4 )? 'selected': ''; ?> >ไม่มีสถานะทางทะเบียนราษฎร์</option>
                                                                <option value="5">อื่นๆ ระบุ...</option>
                                                            </select>
                                                        </td>
                                                        <td width="70%">
                                                            <input type="hidden" id="citizen_id" name="citizen_id" value="<?php echo $row['citizen_id'];?>">
                                                            <div id="idcard_type1">
                                                                <strong>เลขประจำตัว</strong>
                                                                <?php   
                            $rs_idcard = $row['citizen_id']; 
                            // ตัดรหัสประชาชน
                            $idcard1 = substr($row['citizen_id'],0,1);
                            $idcard2 = substr($row['citizen_id'],1,4);
                            $idcard3 = substr($row['citizen_id'],5,5);
                            $idcard4 = substr($row['citizen_id'],10,2);
                            $idcard5 = substr($row['citizen_id'],12,1);
							if($_POST['idcard']!=''){
								$idcard1 = substr($_POST['idcard'],0,1);
								$idcard2 = substr($_POST['idcard'],1,4);
								$idcard3 = substr($_POST['idcard'],5,5);
								$idcard4 = substr($_POST['idcard'],10,2);
								$idcard5 = substr($_POST['idcard'],12,1);
							}
                    ?>
                                                                    
																	<input type="text" id="idcard1" name="idcard1" size="1" value="<?php
																	if($_GET['idcard1']!=''){
																	echo $_GET['idcard1'];
																	}else{
																	echo $idcard1;
																	}
																	?>" maxlength="1" onKeyUp="return autoTab(this, 1, event);" onKeyDown="return Filter_Keyboard(event);" onChange="checkid();">

                                                                    <input type="text" id="idcard2" name="idcard2" size="4" value="<?php
																	if($_GET['idcard2']!=''){
																	echo $_GET['idcard2'];
																	}else{
																	echo $idcard2;
																	}
																	?>" maxlength="4" onKeyUp="return autoTab(this, 4, event);" onKeyDown="return Filter_Keyboard(event);" onChange="checkid();">

                                                                    <input type="text" id="idcard3" name="idcard3" size="5" value="<?php
																	if($_GET['idcard3']!=''){
																	echo $_GET['idcard3'];
																	}else{
																	echo $idcard3;
																	}
																	?>" maxlength="5" onKeyUp="return autoTab(this, 5, event);" onKeyDown="return Filter_Keyboard(event);" onChange="checkid();">
                                                                    <input type="text" id="idcard4" name="idcard4" size="2" value="<?php
																	if($_GET['idcard4']!=''){
																	echo $_GET['idcard4'];
																	}else{
																	echo $idcard4;
																	}
																	?>" maxlength="2" onKeyUp="return autoTab(this, 2, event);" onKeyDown="return Filter_Keyboard(event);" onChange="checkid();">
																	<input type="text" id="idcard5" name="idcard5" size="1" value="<?php
																	if($_GET['idcard5']!=''){
																	echo $_GET['idcard5'];
																	}else{
																	echo $idcard5;
																	}
																	?>" maxlength="1" onKeyUp="return autoTab(this, 1, event);" onKeyDown="return Filter_Keyboard(event);" onChange="checkid();"><oo id="checkDetail"></oo>
                                                                    <input type="hidden" name="check_citizen_id" id="check_citizen_id" value="" />
                                                                    <!--<span id="check_citizen_id_show"></span>-->
																
																	<div>
																	</div>
                                                            </div>
                                                            <div id="idcard_type2" style="display:none;">
                                                                <strong>เลขประจำตัว</strong>
                                                                <input type="text" name="idcard" id="idcard" value="<?php echo $passport;?>" size="20" onKeyup="if(isNaN(this.value) || (checkWhiteSpace(this.value)>0 ) ){ alert('กรุณากรอกตัวเลขเท่านั้น'); this.value=''; }" onblur="checkPerson(this.value,<? echo $_SESSION['GID']; ?>,2);" onChange="addidcard();" />
                                                                <div></div>
                                                                <div id="notification"></div>
                                                            </div>
                                                            <div id="idcard_type3" style="display:none;">
                                                                <strong>เลขประจำตัว</strong> -
                                                            </div>
                                                            <div id="idcard_type4" style="display:none;">
                                                                <input name="citi" type="text" value="<?php echo $row['citizen_id'];?>" onKeyUp="document.getElementById('citizen_id').value=this.value" />
                                                            </div>
                                                            <div id="ieie">
                                                                <input type="text" name="idcard_type5" id="idcard_type5" style='display:none;' />
                                                            </div>
                                                            </div>
                                                            <div id="notification"></div>
                                                            </div>
                                                            <!-- <script>checkid();</script>-->
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="13_bold"><strong>ชื่อ-นามสกุล/ชื่อเล่น</strong></td>
                                            <td>
                                                <table width="500" border="0">
                                                    <tr>
                                                        <td>คำนำหน้าชื่อ<span style="color:#FF0000;">*</span></td>
                                                        <td>ชื่อ<span style="color:#FF0000;">*</span></td>
                                                        <td>นามสกุล<span style="color:#FF0000;">*</span></td>
                                                        <td>ชื่อเล่น</td>
                                                    </tr>
                                                    <tr height="50px;">
                                                        <td>
                                                            <?php
                if($action == 'edit'){
                ?>
                                                                <input type="hidden" id="prename_id" name="prename_id" value="<?php echo $row['prename_id'];?>" />
                                                                <input type="text" id="prename" name="prename" value="<?php echo getPrename($row['prename_id']);?>" readonly />
                                                                <?php }else{  ?>
                                                                    <select id="prename_id" name="prename_id" onchange="changePrename(this.value);">
                                                                        <option value="">ระบุคำนำหน้าชื่อ</option>
                                                                        <?php
                    $sql_prename = "SELECT * FROM `tbl_prename` WHERE priority != 3 ORDER BY (
										   CASE `id`
										   WHEN '83' 	THEN 1
										   WHEN '84' 	THEN 2
										   ELSE 3 END
									  ) ASC";
                    $query_prename =  mysql_db_query( $dbname, $sql_prename );
                    while($prename = mysql_fetch_assoc($query_prename)){
                        $selected = ($prename['id'] == $row['prename_id'] || $prename['id'] == $_POST['pname_ID'])?'selected':'';
                    ?>
                                                                            <option value="<?php echo $prename['id'];?>" <?php echo $selected;?>>
                                                                                <?php echo $prename['prename_th'];?>
                                                                            </option>
                                                                            <?php } ?>
                                                                    </select>
                                                                    <?php }?>
                                                        </td>
															<?php
																	/*if($_GET['idcard5']!=''){
																	echo $_GET['idcard5'];
																	}else{
																	echo $idcard5;
																	}*/
																	?>
                                                        <td>
                                                            <input type="text" id="p_firstname" name="p_firstname" value="<?php 
															if($_POST['name']!=''){
																echo $_POST['name'];
																	}else{
															echo $row['p_firstname'];
															}?>" <?php echo $readonly;?> onBlur="check_specail_cha(this.value,1)" />
                                                            <div class="textnotification1" style="color:#F00"></div>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="p_lastname" name="p_lastname" value="<?php 
															if($_POST['s_name']!=''){
																echo $_POST['s_name'];
																	}else{
															echo $row['p_lastname'];
															}?>" <?php echo $readonly;?> onBlur="check_specail_cha(this.value,2)" />
                                                            <div class="textnotification2" style="color:#F00"></div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="p_nickname" id="p_nickname" value="<?php echo $row['p_nickname'];?>" <?php echo $readonly;?> onBlur="check_specail_cha(this.value,3)" />
                                                            <div class="textnotification3" style="color:#F00"></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php
                if($action == 'edit'){
        ?>
                                            <tr>
                                                <td align="right" class="13_bold">&nbsp;</td>
                                                <td>
                                                    คลิ๊กเครื่องหมายบวกเพื่อ เปลี่ยน ชื่อ-นามสกุล (เจ้าของข้อมูล)
                                                    <input type="button" name="Button311" value=" + " title="ประวัติการเปลี่ยนแปลง ชื่อ-สกุล (เจ้าของข้อมูล)" onClick="MM_openBrWindow('add_historyname.php?p_id=<?php echo $p_id;?>&gid=<?php echo GID;?>&staffid=<?php echo STAFFID;?>','<?php echo $p_id;?>historyname','scrollbars=yes,width=700,height=550')">
                                                </td>
                                            </tr>
                                            <?php } ?>
                                                <tr>
                                                    <td align="right" class="13_bold"><strong>เพศ</strong><span style="color:#FF0000;">*</span></td>
                                                    <td>
                                                        <input type="radio" name="p_gender" id="p_gender1" value="2" <?php echo ($row[ 'p_gender']==2 || $_POST['sex']=='M')? 'checked': '';?> >ชาย
                                                        <input type="radio" name="p_gender" id="p_gender2" value="1" <?php echo ($row[ 'p_gender']==1 || $_POST['sex']=='F')? 'checked': '';?>>หญิง
                                                        <input type="hidden" name="chkp_gender" id="chkp_gender" value="<?php echo getPrename($row['prename_id'], 'gender');?>" />
                                                    </td>
                                                </tr>
                                    </table>
                                    <hr color="#CCC" width="97%" style="margin-top:10px; margin-bottom:10px;">
                                    <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td align="right" class="13_bold"><strong>วัน/เดือน/ปีเกิด<span style="color:#FF0000;">*</span></strong></td>
                                            <td>
                                               
											   
											   <?php
													 $arr_p_birthdate = explode("-",$row['p_birthdate']);
													 if($_POST['birthday']!=''){
														$arr_p_birthdate = explode("-",$_POST['birthday']);
													 }
												?>
                                       <select name="day" id="day" onchange="cal_join_date();">
                                     <option value="<?php 
          if($p_join_date==''){
          $hh = date("d/m/");
        $yyy= date("Y ");
        $yyy +=543;
        echo $hh.''.$yyy;
          }else{
          echo $p_join_date;
          }
?>">-</option>
                               <?php
							   $b_day = explode("/",$_GET['birthday']);
                                for ($i=1; $i <= 31; $i++) { 
									if($arr_p_birthdate[2]==$i||$b_day[0]==$i){
									$selectday = "selected";
									}else{
									 $selectday='';							
											}
                                    echo '<option value="'.$i.'" '.$selectday.'>'.$i.'</option>';
                                }
                            ?>
                                                    </select>
                                                    <select name="month" id="month" onChange="dateChange('day','month','year');cal_join_date();">
                                                        <option value="<?php 
          if($p_join_date==''){
          $hh = date("d/m/");
        $yyy= date("Y ");
        $yyy +=543;
        echo $hh.''.$yyy;
          }else{
          echo $p_join_date;
          }
?>">-</option>
                                                        <?php

								
    $month = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
                                  for ($m=1; $m <= 12; $m++) { 
									if($arr_p_birthdate[1]==$m||$b_day[1]==$m){
									$selectmonth = "selected";
									}else{
									 $selectmonth='';							
											}
									if($m <=9){
											$m='0'.$m;
                                    }
									echo '<option value="'.$m.'" '.$selectmonth.'>'.$month[$m-1].'</option> ';
									
								}
									
                            ?>
                                                    </select>
                                                    <select name="year" id="year" onChange="dateChange('day','month','year');cal_join_date();">
                                                        <option value="<?php 
          if($p_join_date==''){
          $hh = date("d/m/");
        $yyy= date("Y ");
        $yyy +=543;
        echo $hh.''.$yyy;
          }else{
          echo $p_join_date;
          }
?>">-</option>
                                                        <?php
                                
                                for($Y=1980; $Y <=2015 ; $Y++){ 
									$thYear = $Y + 543;
									if($arr_p_birthdate[0]==$Y||($b_day[2]-543)==$Y){
									$selectyear = "selected";
									}else{
									 $selectyear='';							
											}
                                    echo '<option value="'.$Y.'"'.$selectyear.'>'.$thYear.'</option>';
									    
                                }
                            ?>
                                                    </select>
                                                
        <?php
		  $arr_p_birthdate = explode("-",$row['p_birthdate']);
		  /*if($row['p_birthdate'] != '0000-00-00' && $row['p_birthdate'] != '' ){
		  		$p_birthdate = $arr_p_birthdate[2].'/'.$arr_p_birthdate[1].'/'.($arr_p_birthdate[0]+543);
		  }else{
			  	$p_birthdate = '';
		  }*/
         ?>
          
                                                รูปแบบวันที่ วัน/เดือน/ปี(15/01/2557) <span style="color:#FF0000;">*</span>ให้กรอกอย่างน้อยปี พ.ศ. ที่เกิด
                                            </td>
                                        </tr>
										<tr>
                                            <td width="17%" align="right" class="13_bold"><strong>ข้อมูลวันเกิด</strong></td>
                                            <td width="83%">
											<?php 
											 
											?>
											<input type="radio" name="birthdayreal" value="1"<?php echo ($row[ 'birthdayreal']==1)? 'checked': '';?> checked >วันเกิดจริง<br>
											
											<input type="radio" name="birthdayreal" value="2"<?php echo ($row[ 'birthdayreal']==2)? 'checked': '';?>>วันเกิดสมมุติ
											</tr>
                                        <tr>
                                            <td align="right" class="13_bold"><strong>อายุ (ปี/เดือน)</strong></td>
                                            <td>
                                                <font color="#FF0000"><strong id="cal_age"><?php echo $_POST['age_date'];?></strong></font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="13_bold"><strong>เชื้อชาติ</strong></td>
                                            <td>
                                                <select id="race_id" name="race_id">
                                                    <option value="">ไม่ระบุ</option>
                                                    <?php
                    $sql_nationality = "SELECT * FROM `tbl_nationality` ORDER BY `priority` ASC, friendly_country DESC, nationality_th ASC";
                    $query_nationality =  mysql_db_query( $dbname, $sql_nationality );
                    while($nationality = mysql_fetch_assoc($query_nationality)){
                        $selected = ($nationality['id'] == $row['race_id'] || $nationality['id']==$_POST['nat_ID'])?'selected':'';
                    ?>
                                                        <option value="<?php echo $nationality['id'];?>" <?php echo $selected;?> >
                                                            <?php echo $nationality['nationality_th'];?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="13_bold"><strong>สัญชาติ</strong></td>
                                            <td>
                                                <select id="nationality_id" name="nationality_id">
                                                    <option value="">ไม่ระบุ</option>
                                                    <?php
                    $sql_nationality = "SELECT * FROM `tbl_nationality` ORDER BY `priority` ASC, friendly_country DESC, nationality_th ASC";
                    $query_nationality =  mysql_db_query( $dbname, $sql_nationality );
                    while($nationality = mysql_fetch_assoc($query_nationality)){
                        $selected = ($nationality['id'] == $row['nationality_id'] || $nationality['id']==$_POST['race_ID'])?'selected':'';
                    ?>
                                                        <option value="<?php echo $nationality['id'];?>" <?php echo $selected;?>>
                                                            <?php echo $nationality['nationality_th'];?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="13_bold"><strong>ศาสนา</strong></td>
                                            <td>
                                                <select id="religion_id" name="religion_id">
                                                    <?php
                    $sql_religion = "SELECT * FROM `hr_religion` order by orderby ";
                    $query_religion =  mysql_db_query( $dbname, $sql_religion );
                    while($religion = mysql_fetch_assoc($query_religion)){
                        $selected = ($religion['id'] == $row['religion_id'] || $religion['id'] == $_POST['religion_ID'])?'selected':'';
                    ?>
                                                        <option value="<?php echo $religion['id'];?>" <?php echo $selected;?>>
                                                            <?php echo $religion['religion'];?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" class="13_bold">&nbsp;</td>
                                            <td>
												<input type="hidden" name="services_ID" value="<?php echo $_POST['services_ID']; ?>" />
												<input type="hidden" name="sv_received_ID" value="<?php echo $_POST['sv_received_ID']; ?>" />
                                                <input type="hidden" name="agency_received" value="<?php echo $org['groupname'] ;?>" />
												<input type="hidden" name="action_new" value="<?php echo $actionNew ;?>" />
                                                <input type="hidden" name="p_id" value="<?php echo $p_id;?>" />
                                                <input type="submit" name="b_save" id="b_save" value="บันทึก">&nbsp;
                                                <input type="button" name="button2" id="button2" onclick="window.location.href='index.php'" value="ยกเลิก">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <?php 
      if($row['idcard_type'] != ''){
             echo "<script> changeIDcardType('".$row['idcard_type']."'); </script>";
      }
     
    ?>
                                    <script>
									/* $(function(){
									var getAge = $('#p_birthdate').val();
									calAge(getAge);
									}) */
                                    </script>
									

                                   <script>
                                    // var myVar = setInterval(function() {
                                        // calAge($('#p_birthdate').val())
                                    // }, 200000);

                                    //  select box date

                                    $('#day').change(function() {
                                        getage();


                                    })

                                    $('#month').change(function() {
                                        getage();


                                    })


                                    $('#year').change(function() {
                                        getage();


                                    })


                                    function getage() {

                                        var day = $('#day').val();
                                        var year = $('#year').val();
                                        var month = $('#month').val();


                                        if (day == "") {
                                            day = "1";

                                        }

                                        if (month == "") {

                                            month = '1';
                                        }

                                        var dateage = day + '/' + month + '/' + year;

                                        if (year != '') {

                                            year = parseInt(year) + 543;

                                            dateage = day + '/' + month + '/' + year;
                                            calAge(dateage);
                                            console.log(dateage);
                                        }


                                    }

                                    //  end select box date
                                   // select date //
                                    function dateChange(d, m, y) {

                                        d = MWJ_findSelect(d), m = MWJ_findSelect(m), y = MWJ_findSelect(y);
                                        //work out if it is a leap year

                                        var IsLeap = parseInt(y.options[y.selectedIndex].value);


                                        IsLeap = !(IsLeap % 4) && ((IsLeap % 100) || !(IsLeap % 400));
                                        //find the number of days in that month

                                        IsLeap = [0, 31, (IsLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m.selectedIndex];

                                        //store the current day - reduce it if the new month does not have enough days
                                        var storedDate = (d.selectedIndex > IsLeap - 1) ? (IsLeap - 1) : d.selectedIndex;

                                        if (storedDate < 0) {
                                            $('#day').html('<option value="">-</option> ');
                                            for (var x = 1; x <= 31; x++) {
                                                $('#day').append('<option value=' + x + '>' + x + '</option>');
                                            }

                                        } else {
                                            var chk = $('#day').val();
                                            while (d.options.length) {
                                                d.options[0] = null;
                                            } //empty days box then refill with correct number of days

                                            for (var x = 0; x < IsLeap; x++) {
                                                d.options[x] = new Option(x + 1, x + 1);
                                            }

                                            var chkstore = d.options[storedDate].value;

                                            if (chk < chkstore) {
                                                var sel = document.getElementById('day');
                                                for (var i = 0, j = sel.options.length; i < j; ++i) {
                                                    if (sel.options[i].value == chk) {
                                                        $("#day").prop('selectedIndex', i);
                                                    }
                                                }

                                            } else {
                                                d.options[storedDate].selected = true;
                                            }

                                            if (window.opera && document.importNode) {
                                                window.setTimeout('MWJ_findSelect( \'' + d.name + '\' ).options[' + storedDate + '].selected = true;', 0);
                                            }
                                        }
                                    }

                                    function MWJ_findSelect(oName, oDoc) { //get a reference to the select box using its name
                                        if (!oDoc) {
                                            oDoc = window.document;
                                        }
                                        for (var x = 0; x < oDoc.forms.length; x++) {
                                            if (oDoc.forms[x][oName]) {
                                                return oDoc.forms[x][oName];
                                            }
                                        }
                                        for (var x = 0; document.layers && x < oDoc.layers.length; x++) { //scan layers ...
                                            var theOb = MWJ_findObj(oName, oDoc.layers[x].document);
                                            if (theOb) {
                                                return theOb;
                                            }
                                        }
                                        return null;
                                    }

                                    // end select date //
           							    var day = $('#day').val();
                                        var year = $('#year').val();
                                        var month = $('#month').val();
											
	                                       if (day == "") {
                                            day = "1";

                                        }

                                        if (month == "") {

                                            month = '1';
                                        }

                                        var dateage = day + '/' + month + '/' + year;

                                        if (year != '') {

                                            year = parseInt(year) + 543;

                                            dateage = day + '/' + month + '/' + year;
                                            calAge(dateage);
                                            console.log(dateage);
                                        }
	function cal_join_date(){
		var jdate=$('#p_join_date').val();
		var bday = $('#day').val();
		var bmounth = $('#month').val();
		var byear = $('#year').val();
		var bdate = '';//;$('#day').val()+'/'+$('#month').val()+'/'+$('#year').val();
			if(bday == ''){
				bday = '01';
			}
			if(bmounth == ''){
				bmounth = '01';
			}
			bdate = bday+'/'+bmounth+'/'+byear;
		if($('#day').val() == '' || $('#month').val() == '' || $('#year').val() == ''){
			$('#cal_firstage').html('กำลังคำนวณอายุ');
		}else{
			link_page = 'ajax.cal_age.php?jdate='+jdate+'&bdate='+bdate;
			$.get(link_page, function(data){
				// alert(link_page);
				$('#cal_firstage').html(data);
			});
			console.log(link_page);
			}
	}

</script>

