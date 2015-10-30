<?
###################################################################
## CMSS
###################################################################
## Version :            201108002.001 (Created/Modified; Date.RunNumber)
## Created Date :    2011-08-02
## Created By :        Mr.Narong Roumsuk
## E-mail :            narong@sapphire.co.th
## Tel. :                
## Company :        Sappire Research and Development Co.,Ltd. (C)All Right Reserved
## Detail : เป็นฟังก์ชันสำหรับการแสดงข้อมูลวันที่
################################################################### 

################################################################### 
# $date=เป็นวันที่เป็นตัวเลข เช่น 2528-03-21
# $strDate=คือ label วันที่ที่เกิดจากเงื่อนไขก่อนหน้า
# $strDate_label=เป็นวันที่ที่เป็น label ซึ่งมาจากฐานข้อมูล
# $type=ประเภทของวัน {วันเกิด,วันสั่งบรรจุ,วันเริ่มปฎิบัติงาน}
# $section_number=ส่วนของการแสดงผล เช่นวันเกิด มีหลายที่
function showdate_label($date,$strDate,$strDate_label,$type,$section_number=""){
		$str="";
		
		if($type=="birthday"){		// วันเกิด
				if($section_number=="1"){	// วันเกิดส่วนที่อยู่ใต้รูปภาพ บนสุดเลย
						$str=$strDate;
				}else if($section_number=="2"){	// วันเกิดที่อยู่ติดกับชื่อบิดา มารดา  วันครบเกษียณ  ซึ่งไม่ใช่ที่อยู่ในวงเล็บ
						$str=$strDate;
				}else if($section_number=="3"){	// วันเกิดที่อยู่ติดกับชื่อบิดา มารดา  วันครบเกษียณ  และเป็นส่วนที่อยู่ในวงเล็บ
						if($strDate_label!=""){
								$str=$strDate_label;
						}else{
								$str=$strDate;
						}
				}
		}else if($type=="startdate"){	// วันสั่งบรรจุ
				if($strDate_label!=""){
						$str=$strDate_label;
				}else{
						$str=$strDate;
				}
		}else if($type=="begindate"){		// วันเริ่มปฎิบัติงาน
				if($strDate_label!=""){
						$str=$strDate_label;
				}else{
						$str=$strDate;
				}
		}
		return $str;
}
?>