<?php
/**
 * Title: config file etc_tool system
 * Author: Kaisorrawat Panyo
 * Date: 14/10/2558
 * Time:
 */
#############################################################
$ApplicationName   = 'etc_tool';
$VERSION             = "1.0";
#############################################################
$arr_table = array(
    "ccaa" => array(
        "description" => "",
        "tableName" => "ข้อมูลจังหวัด",
        "notAllnull" => array("ccName","ccType","cDate","areaid","secid","g_point","g_shape","partid")
    ),
    "pre_names" => array(
        "description" => "",
        "tableName" => "ข้อมูลคำนำหน้าชื่อ",
        "notAllnull" => array("pname","order_no")
    ),
    "cond_persons"  => array(
        "description" => "",
        "tableName" => "ข้อมูลสถานภาพ",
        "notAllnull" => array("condpers","order_no")
    ),
	"relations" => array(
		"description" => "",
		"tableName" => "ข้อมูลความสัมพันธ์",
		"notAllnull" => array("relate","order_no")
	),
	"religions" => array(
		"description" => "",
		"tableName" => "ข้อมูลศาสนา",
		"notAllnull" => array("religion","order_no")
	),
	"careers" => array(
		"description" => "",
		"tableName" => "ข้อมูลอาชีพ",
		"notAllnull" => array("career","order_no")
	),
	"educates" => array(
		"description" => "",
		"tableName" => "ข้อมูลการศึกษา",
		"notAllnull" => array("statusedu","order_no")
	),
	"range_ages" => array(
		"description" => "",
		"tableName" => "ข้อมูลช่วงอายุ",
		"notAllnull" => array("range","since","until","type_pers_ID","order_no")
	),
    "crisis_centers" => array(
        "description" => "",
        "tableName" => "ข้อมูลหน่วยงาน",
        "notAllnull" => array("crisiscenter","order_no")
    ),
	"major_probs" => array(
		"description" => "",
		"tableName" => "ข้อมูลหมวดปัญหาหลัก",
		"notAllnull" => array("majplob","order_no")
	),
	"minor_probs" => array(
		"description" => "",
		"tableName" => "ข้อมูลหมวดปัญหาย่อย",
		"notAllnull" => array("maj_prob_ID","probmin","level_urge_ID","order_no")
	),
	"status_subject" => array(
		"description" => "",
		"tableName" => "ข้อมูลสถานะของเรื่อง",
		"notAllnull" => array("subjstatus","order_no")
	),
	"type_persons" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทบุคคล",
		"notAllnull" => array("persontype","order_no")
	),
	"type_subscribers" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทผู้ขอรับบริการ",
		"notAllnull" => array("subscriber","order_no")
	),
	"type_demands" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทความต้องการผู้ขอรับบริการ",
		"notAllnull" => array("demand","order_no")
	),
	"type_executes" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทการดำเนินการ",
		"notAllnull" => array("execute","order_no")
	),
	"cond_families" => array(
		"description" => "",
		"tableName" => "ข้อมูลสถานภาพครอบครัว",
		"notAllnull" => array("physcondfam","order_no")
	),
	"type_dept" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทหน่วยงาน",
		"notAllnull" => array("dept","order_no")
	),
	"forward_dept" => array(
		"description" => "",
		"tableName" => "ข้อมูลหน่วยงานส่งต่อ",
		"notAllnull" => array("deptname","type_dept_ID","order_no")
	),
	"levels_urgency" => array(
		"description" => "",
		"tableName" => "ข้อมูลระดับความเร่งด่วน",
		"notAllnull" => array("urge","estimate","order_no")
	),
	"nationalities" => array(
		"description" => "",
		"tableName" => "ข้อมูลเชื้อชาติ สัญชาติ",
		"notAllnull" => array("race","order_no")
	),
	"channal_complains" => array(
		"description" => "",
		"tableName" => "ข้อมูลช่องทางรับเรื่องราวร้องเรียน",
		"notAllnull" => array("contact","order_no")
	),
	"way_advises" => array(
		"description" => "",
		"tableName" => "ข้อมูลวิธีการแจ้ง",
		"notAllnull" => array("agent","order_no")
	),
	"type_attachs" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทไฟล์แนบ",
		"notAllnull" => array("filetype","order_no")
	),
	"officer_expertises" => array(
		"description" => "",
		"tableName" => "ข้อมูลความเชี่ยวชาญของเจ้าหน้าที่",
		"notAllnull" => array("expert","order_no")
	),
	"way_travels" => array(
		"description" => "",
		"tableName" => "ข้อมูลวิธีการเดินทาง",
		"notAllnull" => array("travel","order_no")
	),
	"trade_act" => array(
		"description" => "",
		"tableName" => "ข้อมูลลักษณะการกระทำกรณีค้ามนุษย์",
		"notAllnull" => array("actiontrade","order_no")
	),
	"trade_method" => array(
		"description" => "",
		"tableName" => "ข้อมูลวิธีกระทำผิดกรณีค้ามนุษย์",
		"notAllnull" => array("actiontrade","order_no")
	),
	"trade_obj" => array(
		"description" => "",
		"tableName" => "ข้อมูลวัตถุประสงค์กรณีค้ามนุษย์",
		"notAllnull" => array("objtrade","order_no")
	),
	"type_demands" => array(
		"description" => "",
		"tableName" => "ข้อมูลประเภทความต้องการผู้ขอรับบริการ",
		"notAllnull" => array("demand","order_no")
	),
	"overall_oper" => array(
		"description" => "",
		"tableName" => "ข้อมูลผลการติดตามการดำเนินงาน",
		"notAllnull" => array("result","order_no")
	)
);
?>