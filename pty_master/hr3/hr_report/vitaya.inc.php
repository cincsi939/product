<?
//���������� �ҤԴ�����͹�

$minsalary = array(
	"��.2"=>"14810",
	"��.3"=>"18180",
	"��.4"=>"22330",
	"��.5"=>"27450"
);

$error_message =array(); //��ͤ����ʴ��˵ؼŷ������ҹࡳ��


function GetVitaya($position,$vitaya,$force=false){
global $minsalary;
	$nvitaya = 0 ;

	if (!$force){
		//check �ѹ��� update �����ѹ�Ф���
		$result = mysql_query("select min(lastupdate) as lastupdate from temp_vitaya where position='$position' and vitaya='$vitaya';");
		$rs = mysql_fetch_assoc($result);
		if ($rs[lastupdate] < date("Y-m-01 00:00:00")){ //����͹�Ф��� ( �������ѹ ���������� )
			$force = true;
		}
	}

	if (!$force){
		$result = mysql_query("select count(position) as ncount from temp_vitaya where position='$position' and vitaya='$vitaya';");
		$rs = mysql_fetch_assoc($result);
		return $rs[ncount];
	}

	$sql = "delete from temp_vitaya where position = '$position' and vitaya='$vitaya';";
	mysql_query($sql);
	// re-calculate

	//echo "$position/$vitaya<BR>";

	if ($position == "���"){
		if ($vitaya == "�ӹҭ���"){
			$sql 		= " select * from general where position_now='���' and (vitaya='' or vitaya is null) and salary >= " . $minsalary['��.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "�ӹҭ��þ����"){

			//echo "<BR><BR>��٪ӹҭ��� => ��٪ӹҭ��þ����<BR>";
			$sql 		= " select * from general where position_now='���' and (vitaya='�ӹҭ���') and  salary >=" . $minsalary['��.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ"){

			//echo "<BR><BR>��٪ӹҭ��þ���� => �������Ǫҭ<BR>";
			$sql 		= " select * from general where position_now='���' and (vitaya='�ӹҭ��þ����') and  salary >=" . $minsalary['��.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ�����"){

			//echo "<BR><BR>�������Ǫҭ => �������Ǫҭ�����<BR>";
			$sql 		= " select * from general where position_now='���' and (vitaya='����Ǫҭ') and  salary >=" . $minsalary['��.5'] . "and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitaya4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);

			} //while

		} // if vitaya
//======================================================================================

	} else if ($position == "�֡�ҹ��ȡ�"){

		if ($vitaya == "�ӹҭ���"){
			$sql 		= " select * from general where position_now='�֡�ҹ��ȡ�' and (vitaya='') and  salary >=" . $minsalary['��.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "�ӹҭ��þ����"){

			$sql 		= " select * from general where position_now='�֡�ҹ��ȡ�' and (vitaya='�ӹҭ���') and  salary >=" . $minsalary['��.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ"){

			$sql 		= " select * from general where position_now='�֡�ҹ��ȡ�' and (vitaya='�ӹҭ���' || vitaya='�ӹҭ��þ����') and  salary >=" . $minsalary['��.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ�����"){

			$sql 		= " select * from general where position_now='�֡�ҹ��ȡ�' and (vitaya='����Ǫҭ') and  salary >=" . $minsalary['��.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaNites4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while


		} // if vitaya

//======================================================================================

	} else if ($position == "����ӹ�¡���ç���¹"){

		if ($vitaya == "�ӹҭ���"){
			$sql 		= " select * from general where position_now='����ӹ�¡���ç���¹' and (vitaya='') and  salary >=" . $minsalary['��.2'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "�ӹҭ��þ����"){

			$sql 		= " select * from general where position_now='����ӹ�¡���ç���¹' and (vitaya='�ӹҭ���') and  salary >=" . $minsalary['��.3'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ"){

			$sql 		= " select * from general where position_now='����ӹ�¡���ç���¹' and (vitaya='�ӹҭ���' || vitaya='�ӹҭ��þ����') and  salary >=" . $minsalary['��.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ�����"){

			$sql 		= " select * from general where position_now='����ӹ�¡���ç���¹' and (vitaya='����Ǫҭ') and  salary >=" . $minsalary['��.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolMgr4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya


//======================================================================================

	} else if ($position == "�ͧ����ӹ�¡���ç���¹"){

		if ($vitaya == "�ӹҭ���"){
			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡���ç���¹' and (vitaya='') and  salary >=" . $minsalary['��.2'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "�ӹҭ��þ����"){

			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡���ç���¹' and (vitaya='�ӹҭ���') and  salary >=" . $minsalary['��.3'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ"){

			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡���ç���¹' and (vitaya='�ӹҭ���' || vitaya='�ӹҭ��þ����') and  salary >=" . $minsalary['��.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr3($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ�����"){

			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡���ç���¹' and (vitaya='����Ǫҭ') and  salary >=" . $minsalary['��.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSchoolViceMgr4($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya


//======================================================================================

	} else if ($position == "����ӹ�¡�� ʾ�."){


		if ($vitaya == "����Ǫҭ"){

			$sql 		= " select * from general where position_now='����ӹ�¡�� ʾ�.' and (vitaya='') and  salary >=" . $minsalary['��.4'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSecMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ�����"){

			$sql 		= " select * from general where position_now='����ӹ�¡�� ʾ�.' and (vitaya='����Ǫҭ') and  salary >=" . $minsalary['��.5'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaSecMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya

//======================================================================================

	} else if ($position == "�ͧ����ӹ�¡�� ʾ�."){


		if ($vitaya == "�ӹҭ��þ����"){

			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡�� ʾ�.' and (vitaya='') and  salary >=" . $minsalary['��.3'] . "  and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaViceSecMgr1($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		}else if ($vitaya == "����Ǫҭ"){

			$sql 		= " select * from general where position_now='�ͧ����ӹ�¡�� ʾ�.' and (vitaya='�ӹҭ��þ����') and  salary >=" . $minsalary['��.4'] . " and unit not in (select id from login where not_j18<>1);";
			$result 	= mysql_query($sql);
			while($rs = mysql_fetch_assoc($result)){
				if(chkVitayaViceSecMgr2($rs[id])){
					$nvitaya++;
					$sql = "replace into temp_vitaya(id,position,vitaya,lastupdate) values('$rs[id]','$position','$vitaya',now());";
				}else{
					$sql = "delete from temp_vitaya where id='$rs[id]' and position = '$position' and vitaya='$vitaya';";
				}

				mysql_query($sql);
			} //while

		} // if vitaya



	} // if $position


	return $nvitaya;

}


//================================================================================
// ���
//================================================================================

function chkVitaya1($userid){
global $minsalary;
global $error_message;  $error_message=array();
	$p1 = $p2 = $p3 = $key1 = false;
	//Condition 1 : ��Ǩ�ͺ����֡����дѺ��ԭ�Ң���	
	
	$sql		= "
		select distinct grade from graduate 
		where (grade like '%��ԭ��%�͡%')  
		and grade not like '%͹ػ�ԭ��%' 
		and grade not like '%��С�ȹ���ѵ�%'
		and grade not like '%��С�ȹ�ºѵ�%'
		and grade not like '%�.��%'
		and grade not like '%�.��.%'
		and grade not like '%�.�.�.%'
		and grade not like '%���%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%���%'
		and grade not like '%���%'
		and grade not like '%�Ǫ%'
		and grade not like '%��.�%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%�.Ǫ%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p3	= (mysql_num_rows($result) >= 1) ? true : false ;


	$sql		= "
		select distinct grade from graduate 
		where (grade like '%��ԭ��%�%' or grade like '%�%�%' or grade like '%��ԭ�%��Һѳ%' or grade like '%��ʵ��%��Һѳ�Ե%' 	or grade like '%�.�.�.%' )  
		and grade not like '%͹ػ�ԭ��%' 
		and grade not like '%��С�ȹ���ѵ�%'
		and grade not like '%��С�ȹ�ºѵ�%'
		and grade not like '%�.��%'
		and grade not like '%�.��.%'
		and grade not like '%�.�.�.%'
		and grade not like '%���%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%���%'
		and grade not like '%���%'
		and grade not like '%�Ǫ%'
		and grade not like '%��.�%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%�.Ǫ%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p2	= (mysql_num_rows($result) >= 1) ? true : false ;

	$sql		= "
		select distinct grade from graduate 
		where (grade like '%��ԭ��%���%' or grade like '%�%���%' or grade like '%�.�.%' 
		or grade like '%��.%�.%' or grade like '%��ʵ��%�ѳ�Ե%' or grade like '%�����ø�áԨ�ѳ�Ե%'
		or grade like '%�����ʵúѳ�Ե%')  
		and grade not like '%͹ػ�ԭ��%' 
		and grade not like '%��С�ȹ���ѵ�%'
		and grade not like '%��С�ȹ�ºѵ�%'
		and grade not like '%�.��%'
		and grade not like '%�.��.%'
		and grade not like '%�.�.�.%'
		and grade not like '%���%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%���%'
		and grade not like '%���%'
		and grade not like '%�Ǫ%'
		and grade not like '%��.�%'
		and grade not like '%��.�%'
		and grade not like '%�.��%'
		and grade not like '%�.Ǫ%'
		and id='$userid' order by finishyear desc limit 0,1;		
	";	
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$p1	= (mysql_num_rows($result) >= 1) ? true : false ;



	if ($p1 || $p2 || $p3) $key1 = true; 

	//Condition 1 : End
	
	//Condition 2 : ��Ǩ�ͺ���͹䢷���ͧ�繤���� 6 ��
	if($key1 == true){
		
		$sql		= "		
			SELECT DISTINCT `position`
			from salary
			where 
			(`position` like '%���%'  or  `position` like '%�Ҩ����%') 
			and `position` not like '%�ӹҭ%' 
			and `position` not like '%����Ǫҭ%' 
			and `position` not like '%���ͧ%' 
			and `position` not like '%������%' 
			and `position` not like '%�ѡ�ҡ��%' 
			and `position` not like '%�鹨ҡ%' 		
		";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs 	= mysql_fetch_assoc($result)){
			$pos[$rs[position]]	= 1;
		}
		mysql_free_result($result);
		unset($rs,$sql);
	
		//echo "<pre>"; print_r($pos); echo "</pre>"; 
		
		$edu = 0;
		$sql		= " select * from `salary` where id='$userid' order by date desc;  ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs = mysql_fetch_assoc($result)){
			//echo "<li>$rs[position]";
			if($pos[$rs[position]] == 1){
				$x = explode("-",$rs[date]);
				$y1 = intval($x[0]);
				if ($y1 > 2400){
					$dy = intval(date("Y")+543) - $y1;
				}

				if ($dy > $edu){ //��һշ���ҡ�ش
					$edu = $dy;
				}

			}
		}
		mysql_free_result($result);
		unset($rs,$sql,$pos);

		if (($p3 && $edu >= 2) || ($p2 && $edu >= 4) || ($p1 && $edu >= 6)){
			$key2 = true;
		}else{
			$key2 = false;
			$error_message["���ʾ��ó�"] = "�ѧ��ç���˹觤�����ú���ࡳ�����к�";
		}
		//$key2	= ($edu >= 6) ? true : false ;	
	}else{
		$error_message["����֡��"] = "�زԡ���֡�����֧�дѺ��ԭ�ҵ��";
	}
	//Condition 2 : End
	
	//if ($userid == "13002307") echo "p1=$p1/p2=$p2/p3=$p3 /key1 = $key1/ key2=$key2/ edu=$edu<BR>";

	//Condition 3 : �Թ��͹
	if($key2 == true){
	/*
		$sql		= " select cs1 from `salary_rate` order by cs1 asc where cs1 > 0; "; // get �Թ��͹��1 
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		while($rs = mysql_fetch_assoc($result)){
			$sal[]= $rs[cs1];
		}
		mysql_free_result($result);
		unset($rs,$sql);
		
		$sql		= " select min(cs2) as cs2 from `salary_rate`; "; // get �Թ��͹����ش �� 2
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs 		= mysql_fetch_assoc($result);
		$sal[]	= $rs[cs2];
		mysql_free_result($result);
		unset($rs,$sql);
		
		$sql		= " select salary from `salary` where id='$id' order by date desc limit 0,1; "; // get �Թ��͹�Ѩ�غѹ
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs 		= mysql_fetch_assoc($result);
		$money	= $rs[salary];
		mysql_free_result($result);
		unset($rs,$sql);
		*/

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		if (($rs[salary] >= $minsalary['��.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	
	//Condition 3 : End
	return $getCon1;
}



function chkVitaya2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//��٪ӹҭ��þ����
//=============================
// ���Է°ҹ� "�ӹҭ���" 1 ��
// �Թ��� ��.2 ��ж֧��鹵�� ��. 3

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�ӹҭ���%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.3'])){
			if ($rs[vitaya] == "�ӹҭ���" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ���";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���Է°ҹ� �ӹҭ��� ���֧ 3 ��";
	}
	//Condition 3 : End
	return $getCon1;
}



function chkVitaya3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//��٪ӹҭ��þ���� => �������Ǫҭ
//=============================
// ���Է°ҹ� "٪ӹҭ��þ����" 3 ��
// �Թ��� ��.3 ��ж֧��鹵�� ��. 4
// �ռŧҹ��͹��ѧ 2 ��

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%٪ӹҭ��þ����%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.4'])){
			if ($rs[vitaya] == "�ӹҭ��þ����" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ��þ����";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "����Է°ҹ� �ӹҭ��þ���� ���֧ 3 ��";
	}
	//Condition 3 : End
	return $getCon1;
}

function chkVitaya4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�������Ǫҭ => �������Ǫҭ�����
//=============================
// ���Է°ҹ� "����Ǫҭ" 2 ��
// �Թ��� ��.4 ��ж֧��鹵�� ��. 5
// �ռŧҹ��͹��ѧ 2 ��

//
	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%����Ǫҭ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.5'])){
			if ($rs[vitaya] == "����Ǫҭ" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� ����Ǫҭ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "����Է°ҹ� ����Ǫҭ ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

//================================================================================
// �֡�ҹ��ȡ�
//================================================================================
function chkVitayaNites1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�֡�ҹ��ȡ� => �֡�ҹ��ȡ�ӹҭ���
//=============================
// ���֡�ҹ��ȡ�/��º��� 2 ��
// �Թ��� ��.1 ��ж֧��鹵�� ��. 2
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�֡�ҹ��ȡ�%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���֡�ҹ��ȡ� ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaNites2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�֡�ҹ��ȡ�ӹҭ��� => �֡�ҹ��ȡ�ӹҭ��þ����
//=============================
// ���֡�ҹ��ȡ�ӹҭ��� 1 ��
// �Թ��� ��.2 ��ж֧��鹵�� ��. 3
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�֡�ҹ��ȡ�%�ӹҭ���%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.3'])){
			if ($rs[vitaya] == "�ӹҭ���" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ���";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���֡�ҹ��ȡ�ӹҭ��� ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaNites3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�֡�ҹ��ȡ�ӹҭ��þ���� => �֡�ҹ��ȡ����Ǫҭ
//=============================
// �֡�ҹ��ȡ�ӹҭ��þ���� 3 �� ���� �֡�ҹ��ȡ�ӹҭ��� 5 ��
// �Թ��� ��.3 ��ж֧��鹵�� ��. 4
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�֡�ҹ��ȡ�%�ӹҭ���%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�֡�ҹ��ȡ�%�ӹҭ���%�����' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >=  $minsalary['��.4'] ) ){
			if ( (($rs[vitaya] == "�ӹҭ���" && $edu1 >= 5) || ($rs[vitaya] == "�ӹҭ��þ����" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ��þ����";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���֡�ҹ��ȡ�ӹҭ��þ�������֧ 3 �� ���� ���֡�ҹ��ȡ�ӹҭ������֧ 5 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaNites4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�֡�ҹ��ȡ����Ǫҭ => �֡�ҹ��ȡ����Ǫҭ�����
//==================================
// �֡�ҹ��ȡ����Ǫҭ 2 ��
// �Թ��� ��.4 ��ж֧��鹵�� ��. 5
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and position like '%�֡�ҹ��ȡ�%����Ǫҭ%' order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.5'])){
			if ($rs[vitaya] == "����Ǫҭ" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� ����Ǫҭ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���֡�ҹ��ȡ����Ǫҭ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}




//================================================================================
// ����ӹ�¡���ç���¹
//================================================================================
function chkVitayaSchoolMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡���ç���¹ => ����ӹ�¡���ç���¹�ӹҭ���
//=============================
// �繼���ӹ�¡���ç���¹ 1 ��
// �Թ��� ��.1 ��ж֧��鹵�� ��. 2
// �ռŧҹ��Ժѵ�˹�ҷ����͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡���ç���¹ ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSchoolMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡���ç���¹�ӹҭ��� => ����ӹ�¡���ç���¹�ӹҭ��þ����
//=============================
// ���֡�ҹ��ȡ�ӹҭ��� 1 ��
// �Թ��� ��.2 ��ж֧��鹵�� ��. 3
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%�ӹҭ���')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.3'])){
			if ($rs[vitaya] == "�ӹҭ���" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ���";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡���ç���¹�ӹҭ���  ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolMgr3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡���ç���¹�ӹҭ��þ���� => ����ӹ�¡���ç���¹����Ǫҭ
//=============================
// ����ӹ�¡���ç���¹�ӹҭ��þ���� 3 �� ���ͼ���ӹ�¡���ç���¹�ӹҭ��� 5 ��
// �Թ��� ��.3 ��ж֧��鹵�� ��. 4
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%�ӹҭ���%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%�ӹҭ���%�����%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.4']) ){
			if ( (($rs[vitaya] == "�ӹҭ���" && $edu1 >= 5) || ($rs[vitaya] == "�ӹҭ��þ����" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ��� ���� �ӹҭ��þ����";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡���ç���¹�ӹҭ��þ�������֧ 3 �� ���ͼ���ӹ�¡���ç���¹�ӹҭ��� 5 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolMgr4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡���ç���¹����Ǫҭ => ����ӹ�¡���ç���¹����Ǫҭ�����
//==================================
// ����ӹ�¡���ç���¹����Ǫҭ  2 ��
// �Թ��� ��.4 ��ж֧��鹵�� ��. 5
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%����Ǫҭ' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.5']) ){
			if ($rs[vitaya] == "����Ǫҭ" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� ����Ǫҭ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡���ç���¹����Ǫҭ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}



//================================================================================
// �ͧ����ӹ�¡���ç���¹
//================================================================================
function chkVitayaSchoolViceMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�ͧ����ӹ�¡���ç���¹ => �ͧ����ӹ�¡���ç���¹�ӹҭ���
//=============================
// ���ͧ����ӹ�¡���ç���¹ 1 ��
// �Թ��� ��.1 ��ж֧��鹵�� ��. 2
// �ռŧҹ��Ժѵ�˹�ҷ����͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ����ӹ�¡��%' or position like '%�ͧ%�.�%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.2']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.2";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡���ç���¹ ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSchoolViceMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�ͧ����ӹ�¡���ç���¹�ӹҭ��� => �ͧ����ӹ�¡���ç���¹�ӹҭ��þ����
//=============================
// ���֡�ҹ��ȡ�ӹҭ��� 1 ��
// �Թ��� ��.2 ��ж֧��鹵�� ��. 3
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ����ӹ�¡��%�ӹҭ���%'  or position like '%�ͧ%�.�%�ӹҭ���%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.3']) ){
			if ($rs[vitaya] == "�ӹҭ���" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ���";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡���ç���¹�ӹҭ��� ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolViceMgr3($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�ͧ����ӹ�¡���ç���¹�ӹҭ��þ���� => �ͧ����ӹ�¡���ç���¹����Ǫҭ
//=============================
// �ͧ����ӹ�¡���ç���¹�ӹҭ��þ���� 3 �� �����ͧ����ӹ�¡���ç���¹�ӹҭ��� 5 ��
// �Թ��� ��.3 ��ж֧��鹵�� ��. 4
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu1 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ����ӹ�¡��%�ӹҭ���%' or position like '%�ͧ%�.�%�ӹҭ���%' )  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu1 = intval(date("Y")+543) - $y1;
	}

	
	$edu2 = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ����ӹ�¡��%�ӹҭ���%�����%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu2 = intval(date("Y")+543) - $y1;
	}


//echo "edu1=$edu1/edu2=$edu2 ";
	if($edu1 >= 5 || $edu2 >= 3){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.4']) ){
			if ( (($rs[vitaya] == "�ӹҭ���" && $edu1 >= 5) || ($rs[vitaya] == "�ӹҭ��þ����" && $edu2 >= 3)) ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ��� ���� �ӹҭ��þ���� ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡���ç���¹�ӹҭ��þ���� ���֧ 3 �� �����ͧ����ӹ�¡���ç���¹�ӹҭ��� ���֧ 5 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


function chkVitayaSchoolViceMgr4($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//�ͧ����ӹ�¡���ç���¹����Ǫҭ => �ͧ����ӹ�¡���ç���¹����Ǫҭ�����
//==================================
// �ͧ����ӹ�¡���ç���¹����Ǫҭ  2 ��
// �Թ��� ��.4 ��ж֧��鹵�� ��. 5
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ����ӹ�¡��%����Ǫҭ' or position like '%�ͧ%�.�%����Ǫҭ' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}



	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.5']) ){
			if ($rs[vitaya] == "����Ǫҭ" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� ����Ǫҭ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else{
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡���ç���¹����Ǫҭ ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


//================================================================================
// ����ӹ�¡��ʾ�.
//================================================================================
function chkVitayaSecMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡�� ʾ�. => ����ӹ�¡�� ʾ�. ����Ǫҭ
//=============================
// �繼���ӹ�¡�� ʾ�. / ��º��� 1 ��
// �Թ��� ��.4
// �ռŧҹ��Ժѵ�˹�ҷ����͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%ʾ�%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.4']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡�� ʾ�. ���� ��º��� ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaSecMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
//����ӹ�¡�� ʾ�. ����Ǫҭ => ����ӹ�¡�� ʾ�. ����Ǫҭ�����
//=============================
// �繼���ӹ�¡�� ʾ�. ����Ǫҭ 2 ��
// �Թ��� ��.4 ��ж֧��鹵�� ��. 5
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%����ӹ�¡��%ʾ�%����Ǫҭ')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.5']) ){
			if ($rs[vitaya] == "����Ǫҭ" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� ����Ǫҭ";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.5";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["���ʾ��ó�"] = "�繼���ӹ�¡�� ʾ�.����Ǫҭ ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}





//================================================================================
// �ͧ����ӹ�¡��ʾ�.
//================================================================================
function chkVitayaViceSecMgr1($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
// �ͧ����ӹ�¡�� ʾ�. => �ͧ����ӹ�¡�� ʾ�. �ӹҭ��þ����
// ============================================
// ���ͧ����ӹ�¡�� ʾ�. / ��º��� 1 ��
// �Թ��� ��.3
// �ռŧҹ��Ժѵ�˹�ҷ����͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ%����ӹ�¡��%ʾ�%' ) order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	if($edu >= 1){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.3']) && $rs[vitaya] == "" ){
			$getCon1 = true;
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.3";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡�� ʾ�. ���� ��º��� ���֧ 1 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}

function chkVitayaViceSecMgr2($userid){ 
global $error_message;  $error_message=array();
global $minsalary;
// �ͧ����ӹ�¡�� ʾ�. �ӹҭ��þ���� => �ͧ����ӹ�¡�� ʾ�. ����Ǫҭ
// =============================
// ���ͧ����ӹ�¡�� ʾ�. �ӹҭ��þ���� 3 ��
// �Թ��� ��.3 ��ж֧��鹵�� ��. 4
// �ռŧҹ��͹��ѧ 2 ��


	$getCon1 = false;

	$edu = 0;
	$sql		= " select * from `salary` where id='$userid' and (position like '%�ͧ%����ӹ�¡��%ʾ�%�ӹҭ���%�����')  order by date asc limit 1;  ";
	$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
	$rs = mysql_fetch_assoc($result);
	//echo "<li>$rs[position]";
	$x = explode("-",$rs[date]);
	$y1 = intval($x[0]);
	if ($y1 > 2400){
		$edu = intval(date("Y")+543) - $y1;
	}

	
	if($edu >= 2){

		$sql		= " select * from `general` where id='$userid'; ";
		$result	= mysql_query($sql)or die(" line ". __LINE__ ."<hr>".mysql_error());
		$rs = mysql_fetch_assoc($result);
		$xx = explode("-",$rs[birthday]);
		$age = (date("Y")+543) - intval($xx[0]);

		if (($rs[salary] >= $minsalary['��.4']) ){
			if ($rs[vitaya] == "�ӹҭ��þ����" ){
				$getCon1 = true;
			}else{
				$error_message["�Է°ҹ�"] = "������Է°ҹ� �ӹҭ��þ����";
			}
		}else{
			$getCon1 = false;
			$error_message["�Թ��͹"] = "����Թ��͹���֧��鹵�� ��.4";
		}

		//$getCon1	= (in_array($sal, $money)) ? true : false ;
	}	else {
		$error_message["���ʾ��ó�"] = "���ͧ����ӹ�¡�� ʾ�. �ӹҭ��þ���� ���֧ 2 ��";
	}	
	//Condition 3 : End
	return $getCon1;
}


?>