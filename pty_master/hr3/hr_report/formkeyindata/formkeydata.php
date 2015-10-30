<?php
session_start();

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_graduate";
$module_code 		= "graduate"; 
$process_id			= "graduate";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: 
#DateCreate	::17/07/2007
#LastUpdate	::17/07/2007
#DatabaseTabel::
#END
#########################################################

include("../../../../config/conndb_nonsession.inc.php");
include("../../../../common/common_competency.inc.php");

$time_start = getmicrotime();

$staff_id = $_SESSION['session_staffid'];

require_once('lib/Form.php');
$obj = new Form();

//$obj->init('localhost','root','root','pty_master');
$obj->init(HOST,USERNAME_HOST,PASSWORD_HOST,DB_MASTER);

$idcard = $obj->valPostGet('idcard','');
$xsiteid = $obj->valPostGet('xsiteid','');

if(($idcard!='') && ($xsiteid!='')) {
    $obj->dupRecord2Temp($idcard);
    $obj->setStaffID($idcard, $staff_id);
    $rs = $obj->getEmp($idcard);
}
else {
    echo "<script>window.close();</script>";
}


if($obj->valPostGet('go2update',false)) {

    $q1 = $obj->updateDataProcess($_POST,'view_general_report_lastdata',$idcard,$xsiteid);
    $q2 = $obj->updateDataProcess($_POST,'general',$idcard,$xsiteid);
    $q3 = $obj->updateDataProcess($_POST,'view_general',$idcard,$xsiteid);

    if($q1 && $q2 && $q3) {
        if($obj->setStatus($idcard)) {
            echo "<script type='text/javascript'>
            alert('กรอกข้อมูลเรียบร้อยแล้ว!!');
            window.open('','_parent','');
            window.close();

            </script>";
        }
    }

}

$temp = $rs[0];


function convertDate($d) {
    $d1=explode("-",$d);
    return (intval($d1[2])) . "-" . $d1[1] . "-" . $d1[0];
}

$sex_id = $obj->valPostGet('sex_id',$temp['gender_id']); // gender_id ใน view_general
$posg_id = $obj->valPostGet('posg_id',$temp['positiongroup']); // positiongroup ใน view_general
$pid = $obj->valPostGet('pid',$temp['pid']); // pid ใน view_general
$radub_id = $obj->valPostGet('radub_id',$temp['level_id']); // level_id ใน view_general
$vitaya_id = $obj->valPostGet('vitaya_id',$temp['vitaya_id']); // vitaya_id ใน view_general
$grade_id = $obj->valPostGet('grade_id',$temp['graduate_level']); // graduate_level ใน view_general
$degree_id = $obj->valPostGet('degree_id',$temp['degree_level']); // degree_level ใน view_general
$gmajor_id = $obj->valPostGet('gmajor_id',false); // ไม่ใช้
$major_id = $obj->valPostGet('major_id',$temp['major_level']); // major_level ใน view_general

$salary_begin = $obj->valPostGet('salary_begin',$temp['salary_begin']); // salary_begin ใน view_general
$salary = $obj->valPostGet('salary',$temp['salary']); // salary ใน view_general
$noposition = $obj->valPostGet('noposition',$temp['noposition']); // noposition ใน view_general
$date_command = $obj->valPostGet('date_command',convertDate($temp['date_command'])); // data_command ใน view_general



?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta name="viewport" content="width=1024px, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
    <title>เครื่องมือการนำเข้าข้อมูล</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/icons.css" />
    <link rel="stylesheet" href="css/formalize.css" />
    <link rel="stylesheet" href="css/checkboxes.css" />
    <link rel="stylesheet" href="css/sourcerer.css" />
    <link rel="stylesheet" href="css/jqueryui.css" />
    <link rel="stylesheet" href="css/tipsy.css" />
    <link rel="stylesheet" href="css/calendar.css" />
    <link rel="stylesheet" href="css/tags.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/main.css" />

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <![endif]-->

    <script  type="text/javascript">
    var imgDir_path="../../../../common/popup_calenda/images/calendar/";
    function showvalue(){
    	alert(document.getElementById('date_command').value)
    }
    </script>
    <script src="../../../../common/popup_calenda/popcalendar.js" type="text/javascript"></script>
    <style type="text/css">
            #ui-datepicker-div
            {
                z-index: 999999 !important;
                position: absolute !important;
            }
    </style>
</head>
<body>

<section id="maincontainer">
    <div id="main">

        <div class="box">

            <div class="box-header">
                <h1>แบบฟอร์มนำเข้าข้อมูล</h1>

                <ul>
                    <li class="active"><a href="#one">ข้อมูลพื้นฐาน</a></li>
                </ul>
            </div>

            <div class="box-content">
                <div class="tab-content" id="one">

                    <form id="searchidcard" action="" method="post">
                        <div class="column-left">
                            <!-- #ใช้งานได้แต่ตอนนี้ยังไม่ใช้งาน
                            <p>
                                <input type="text" id="idcard" name="idcard" placeholder="เลขบัตรประชาชน" class="{validate:{required:true, minlength:13,number:true}}" />
                                <span class="icon search"></span>
                            </p>


                            <p>
                                <input type="submit" name="search" class="button blue" value="ค้นหาข้อมูล" />
                            </p>
                            -->




                            <div class="box">
                                <div class="box-header">
                                    <h1>ข้อมูลเบื้องต้น</h1>
                                </div>

                                <table class="sap">
                                    <thead>
                                    <tr>
                                        <th>เลขบัตรประชาชน</th>
                                        <th><?=$idcard?></th>
                                    </tr>
                                    <tr>
                                        <th>ชื่อ-สกุล</th>
                                        <th><?php echo $rs[0]['prename_th'].$rs[0]['name_th'].' '.$rs[0]['surname_th'];?></th>
                                    </tr>
                                    <tr>
                                        <th>ตำแหน่ง</th>
                                        <th><?php echo $rs[0]['position_now']; ?></th>
                                    </tr>
                                    <tr>
                                        <th>เขตพื้นที่การศึกษา</th>
                                        <th><?php echo $rs[0]['secname']; ?></th>
                                    </tr>
                                    <tr>
                                        <th>โรงเรียน</th>
                                        <th><?php echo $rs[0]['schoolname']; ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </form>

                    <form id="infoform" action="" method="post">
                        <input type="hidden" id="position_now" name="position_now" value="<?=$temp['position_now']?>"/>
                        <input type="hidden" id="staff_id" name="staff_id" value="<?=$staff_id?>"/>
                        <input type="hidden" id="radub" name="radub" value=""/>
                        <input type="hidden" id="vitaya" name="vitaya" value=""/>
                        <div class="column-right">

                            <p>
                                <label>เพศ</label>
                                <?php $obj->genComboBoxByResult('sex_id',$sex_id,'method','getSex',false,'===== กรุณาเลือกเพศ ====='); ?>
                            </p>

                            <p>
                                <label>การศึกษาสูงสุด</label>
                                <?php
                                $js = array("onchange=\"getAjaxBox(this,'getDegree','#degree_id');\" ");
                                $obj->genComboBoxByResult('grade_id',$grade_id,'method','getHighGrade',false,'===== กรุณาเลือกการศึกษา =====',$js);
                                ?>
                            </p>

                            <p>
                                <label>วุฒิการศึกษา</label>
                                <?php
                                $obj->genComboBoxByResultNotValid('degree_id',$degree_id,'method','getDegree',$grade_id,'===== กรุณาเลือกวุฒิการศึกษา =====');
                                ?>
                            </p>
                            
                            <p>
                                <label>สายงาน</label>
                                <?php
                                $js = array("onchange=\"getAjaxBox(this,'getPosition','#pid');\" ");
                                $obj->genComboBoxByResult('posg_id',$posg_id,'method','getPositionGroup',false,'===== กรุณาเลือกสายงาน =====',$js);
                                ?>
                            </p>

                            <p>
                                <label>ตำแหน่ง</label>
                                <?php
                                $js = array("onchange=\"getAjaxBox(this,'getRadub','#radub_id');\" ");
                                $obj->genComboBoxByResult('pid',$pid,'method','getPosition',$posg_id,'===== กรุณาเลือกตำแหน่ง =====',$js);
                                ?>
                            </p>

                            <p>
                                <label>ระดับ</label>
                                <?php
                                $js = array("onchange=\"getAjaxBox(this,'getVitaya','#vitaya_id');\" ");
                                $obj->genComboBoxByResult('radub_id',$radub_id,'method','getRadub',$pid,'===== กรุณาเลือกระดับ =====',$js);
                                ?>
                            </p>

                            <p>
                                <label>วิทยะฐานะ</label>
                                <?php $obj->genComboBoxByResultNotValid('vitaya_id',$vitaya_id,'method','getVitaya',$radub_id,'===== กรุณาเลือกวิทยะฐานะ ====='); ?>
                            </p>




                            <p>
                            <div class="column-left">
                                <p>
                                    <label>เงินเดือนเริ่มต้น</label>
                                    <input type="text" id="salary_begin" name="salary_begin" value="<?php echo $salary_begin; ?>" placeholder="เงินเดือนเริ่มต้น" class=""/>
                                </p>
                                <p>
                                    <label>เลขที่ตำแหน่ง</label>
                                    <input type="text" id="noposition" name="noposition" value="<?php echo $noposition; ?>" placeholder="เลขที่ตำแหน่ง" class="{validate:{required:true}}"/>
                                </p>
                            </div>

                            <div class="column-right">
                                <p>
                                    <label>เงินเดือนปัจจุบัน</label>
                                    <input type="text" id="salary" name="salary" value="<?php echo $salary; ?>" placeholder="เงินเดือนปัจจุบัน" class="{validate:{required:true, number:true, minlength:4}}"/>
                                </p>
                                <p>
                                    <label>วันที่สั่ง</label>
                                    <input type="text" id="date_command" name="date_command" class="datepicker {validate:{required:true}}" placeholder="วันที่ได้รับคำสั่ง"/>
                                    <!--<input type="button" name="but" id="but" value="..." onclick='popUpCalendar(document.getElementById("date_command"), document.getElementById("date_command"), "dd/mm/yyyy","showvalue()") ;return false ' />-->
                                </p>
                            </div>
                            </p>

                            <p>
                                <input type="submit" name="go2update" class="button blue" value="บันทึกข้อมูล" />
                            </p>
                        </div>
                    </form>

                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

</section>



<!-- JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/jqueryui.min.js"></script>
<script src="js/jquery.cookies.js"></script>
<script src="js/jquery.pjax.js"></script>
<script src="js/formalize.min.js"></script>
<script src="js/jquery.metadata.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.checkboxes.js"></script>
<script src="js/jquery.selectskin.js"></script>
<script src="js/jquery.fileinput.js"></script>
<script src="js/jquery.datatables.js"></script>
<script src="js/jquery.sourcerer.js"></script>
<script src="js/jquery.tipsy.js"></script>
<script src="js/jquery.calendar.js"></script>
<script src="js/jquery.inputtags.min.js"></script>
<script src="js/jquery.wymeditor.js"></script>
<script src="js/jquery.livequery.js"></script>
<script src="js/jquery.highcharts.js"></script>

<script src="js/application.js"></script>
<script>
    function getAjaxBox(el, method, display) {
        var first = $(display+' option:first').text();

        var ajaxdata = 'mod=' + method + '&val=' + el.value + '&first=' + first;
        $.ajax({
            type: 'POST',
            url: 'getcombo_list.php',
            data: ajaxdata,
            success: function(msg) {
                $(display).html(msg);
            }
        });
    }


</script>
<?php
$time_end = getmicrotime(); //writetime2db($time_start,$time_end);

?>
</body>
</html>
