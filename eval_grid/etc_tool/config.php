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
        "tableName" => "�����Ũѧ��Ѵ",
        "notAllnull" => array("ccName","ccType","cDate","areaid","secid","g_point","g_shape","partid")
    ),
    "pre_names" => array(
        "description" => "",
        "tableName" => "�����Ťӹ�˹�Ҫ���",
        "notAllnull" => array("pname","order_no")
    ),
    "cond_persons"  => array(
        "description" => "",
        "tableName" => "������ʶҹ�Ҿ",
        "notAllnull" => array("condpers","order_no")
    ),
	"relations" => array(
		"description" => "",
		"tableName" => "�����Ť�������ѹ��",
		"notAllnull" => array("relate","order_no")
	),
	"religions" => array(
		"description" => "",
		"tableName" => "��������ʹ�",
		"notAllnull" => array("religion","order_no")
	),
	"careers" => array(
		"description" => "",
		"tableName" => "�������Ҫվ",
		"notAllnull" => array("career","order_no")
	),
	"educates" => array(
		"description" => "",
		"tableName" => "�����š���֡��",
		"notAllnull" => array("statusedu","order_no")
	),
	"range_ages" => array(
		"description" => "",
		"tableName" => "�����Ū�ǧ����",
		"notAllnull" => array("range","since","until","type_pers_ID","order_no")
	),
    "crisis_centers" => array(
        "description" => "",
        "tableName" => "������˹��§ҹ",
        "notAllnull" => array("crisiscenter","order_no")
    ),
	"major_probs" => array(
		"description" => "",
		"tableName" => "��������Ǵ�ѭ����ѡ",
		"notAllnull" => array("majplob","order_no")
	),
	"minor_probs" => array(
		"description" => "",
		"tableName" => "��������Ǵ�ѭ������",
		"notAllnull" => array("maj_prob_ID","probmin","level_urge_ID","order_no")
	),
	"status_subject" => array(
		"description" => "",
		"tableName" => "������ʶҹТͧ����ͧ",
		"notAllnull" => array("subjstatus","order_no")
	),
	"type_persons" => array(
		"description" => "",
		"tableName" => "�����Ż������ؤ��",
		"notAllnull" => array("persontype","order_no")
	),
	"type_subscribers" => array(
		"description" => "",
		"tableName" => "�����Ż����������Ѻ��ԡ��",
		"notAllnull" => array("subscriber","order_no")
	),
	"type_demands" => array(
		"description" => "",
		"tableName" => "�����Ż�����������ͧ��ü����Ѻ��ԡ��",
		"notAllnull" => array("demand","order_no")
	),
	"type_executes" => array(
		"description" => "",
		"tableName" => "�����Ż�������ô��Թ���",
		"notAllnull" => array("execute","order_no")
	),
	"cond_families" => array(
		"description" => "",
		"tableName" => "������ʶҹ�Ҿ��ͺ����",
		"notAllnull" => array("physcondfam","order_no")
	),
	"type_dept" => array(
		"description" => "",
		"tableName" => "�����Ż�����˹��§ҹ",
		"notAllnull" => array("dept","order_no")
	),
	"forward_dept" => array(
		"description" => "",
		"tableName" => "������˹��§ҹ�觵��",
		"notAllnull" => array("deptname","type_dept_ID","order_no")
	),
	"levels_urgency" => array(
		"description" => "",
		"tableName" => "�������дѺ������觴�ǹ",
		"notAllnull" => array("urge","estimate","order_no")
	),
	"nationalities" => array(
		"description" => "",
		"tableName" => "���������ͪҵ� �ѭ�ҵ�",
		"notAllnull" => array("race","order_no")
	),
	"channal_complains" => array(
		"description" => "",
		"tableName" => "�����Ū�ͧ�ҧ�Ѻ����ͧ�����ͧ���¹",
		"notAllnull" => array("contact","order_no")
	),
	"way_advises" => array(
		"description" => "",
		"tableName" => "�������Ըա����",
		"notAllnull" => array("agent","order_no")
	),
	"type_attachs" => array(
		"description" => "",
		"tableName" => "�����Ż��������Ṻ",
		"notAllnull" => array("filetype","order_no")
	),
	"officer_expertises" => array(
		"description" => "",
		"tableName" => "�����Ť�������Ǫҭ�ͧ���˹�ҷ��",
		"notAllnull" => array("expert","order_no")
	),
	"way_travels" => array(
		"description" => "",
		"tableName" => "�������Ըա���Թ�ҧ",
		"notAllnull" => array("travel","order_no")
	),
	"trade_act" => array(
		"description" => "",
		"tableName" => "�������ѡɳС�á�зӡóդ��������",
		"notAllnull" => array("actiontrade","order_no")
	),
	"trade_method" => array(
		"description" => "",
		"tableName" => "�������Ըա�зӼԴ�óդ��������",
		"notAllnull" => array("actiontrade","order_no")
	),
	"trade_obj" => array(
		"description" => "",
		"tableName" => "�������ѵ�ػ��ʧ��óդ��������",
		"notAllnull" => array("objtrade","order_no")
	),
	"type_demands" => array(
		"description" => "",
		"tableName" => "�����Ż�����������ͧ��ü����Ѻ��ԡ��",
		"notAllnull" => array("demand","order_no")
	),
	"overall_oper" => array(
		"description" => "",
		"tableName" => "�����żš�õԴ�����ô��Թ�ҹ",
		"notAllnull" => array("result","order_no")
	)
);
?>