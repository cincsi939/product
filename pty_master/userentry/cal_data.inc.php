<?
require_once("../../config/conndb_nonsession.inc.php");
$dbcall = DB_USERENTRY;

			// id
			$arr_tbl1 = array("general"=>"�����ŷ����" ,"general_pic"=>"����ٻ�Ҿ","graduate"=>"����ѵԡ���֡��","salary"=>"���˹�����ѵ���Թ��͹","seminar"=>"�֡ͺ����д٧ҹ","sheet"=>"�ŧҹ�ҧ�Ԫҡ��","getroyal"=>"����ͧ�Ҫ��������ó� ","special"=>"��������������ö�����","goodman"=>"��¡�ä����դ����ͺ","hr_absent"=>"�ӹǹ�ѹ����ش�Ҫ��� �Ҵ�Ҫ��������","hr_nosalary"=>"�ѹ���������Ѻ�Թ��͹�������Ѻ�Թ��͹�������","hr_prohibit"=>"������Ѻ�ɷҧ�Թ��","hr_specialduty"=>"��û�Ժѵ��Ҫ��þ����","hr_other"=>"��¡����� � ������","hr_teaching"=>"����ѵԡ���͹","seminar_form"=>"������������Ъ������� / �Ѵ�Ԩ����" );
			// gen_id
			$arr_tbl3 = array( "hr_addhistoryaddress"=>"����ѵԡ������¹�ŧ�������","hr_addhistoryfathername"=>"����ѵԡ������¹�ŧ���ͺԴ�" , "hr_addhistorymarry"=>"����ѵԡ������¹�ŧ���ͤ������" , "hr_addhistorymothername"=>"����ѵԡ������¹�ŧ������ô�" , "hr_addhistoryname"=>"����ѵԡ������¹�ŧ����" );			

			$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");


	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


			
?>