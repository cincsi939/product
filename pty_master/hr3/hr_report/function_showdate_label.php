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
## Detail : �繿ѧ��ѹ����Ѻ����ʴ��������ѹ���
################################################################### 

################################################################### 
# $date=���ѹ����繵���Ţ �� 2528-03-21
# $strDate=��� label �ѹ������Դ�ҡ���͹䢡�͹˹��
# $strDate_label=���ѹ������� label ����Ҩҡ�ҹ������
# $type=�������ͧ�ѹ {�ѹ�Դ,�ѹ��觺�è�,�ѹ�������Ժѵԧҹ}
# $section_number=��ǹ�ͧ����ʴ��� ���ѹ�Դ �����·��
function showdate_label($date,$strDate,$strDate_label,$type,$section_number=""){
		$str="";
		
		if($type=="birthday"){		// �ѹ�Դ
				if($section_number=="1"){	// �ѹ�Դ��ǹ����������ٻ�Ҿ ���ش���
						$str=$strDate;
				}else if($section_number=="2"){	// �ѹ�Դ�������Դ�Ѻ���ͺԴ� ��ô�  �ѹ�ú���³  ���������������ǧ���
						$str=$strDate;
				}else if($section_number=="3"){	// �ѹ�Դ�������Դ�Ѻ���ͺԴ� ��ô�  �ѹ�ú���³  �������ǹ��������ǧ���
						if($strDate_label!=""){
								$str=$strDate_label;
						}else{
								$str=$strDate;
						}
				}
		}else if($type=="startdate"){	// �ѹ��觺�è�
				if($strDate_label!=""){
						$str=$strDate_label;
				}else{
						$str=$strDate;
				}
		}else if($type=="begindate"){		// �ѹ�������Ժѵԧҹ
				if($strDate_label!=""){
						$str=$strDate_label;
				}else{
						$str=$strDate;
				}
		}
		return $str;
}
?>