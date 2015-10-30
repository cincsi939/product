<?
@include("../../config/conndb_nonsession.inc.php");
@include("../../../../config/conndb_nonsession.inc.php");
@include("../../../config/conndb_nonsession.inc.php");

function GetProvinceId_v1(){
	global $dbnamemaster;
	$sql = "SELECT left(t1.ccDigi,2) as prov_id FROM `view_province` as t1";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[prov_id]] = $rs[prov_id];	
	}// end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}// end function GetProvinceId_v1(){

function Check_IDCard($StrID){
	$arrprov = GetProvinceId_v1();
	 if(is_numeric($StrID)){
				 $sub_id = substr($StrID,0,1); // หาตัวเลขตัวแรกว่าเป็น 0 หรือไม่
				 $sub_idprovince = substr($StrID,1,2); // หารหัส เลขบัตรที่เป็น id ของรหัสจังหวัด
			 if(array_key_exists("$sub_idprovince", $arrprov)  or $sub_id == "9") { #
				 	
				if($sub_id >0){
					if(strlen($StrID)==13){
						$id=str_split($StrID); 
						$sum=0;    
							for($i=0; $i < 12; $i++){
								 $sum += floatval($id[$i])*(13-$i); 
							}   
								if((11-$sum%11)%10!=floatval($id[12])){
									 return false;
								}else{
									 return true; 
								}
					}else{
						return false;
					} 
			}else{
				return false; 
			}
		}else{
			return false;	
		}//end 
    }else{
        return false;    
    }
} //end function Check_IDCard($StrID){
	
	
	
	function CheckIDCard($idcard){//ตรวจสอบความถูกต้องของเลขบัตร
      //return error type
      //0=ถูกต้อง
      //1=ไม่ครบ13 หลัก หรือ เกิน
      //2=ไม่ถูกต้องตามกรมการปกครอง
      //3=ค่าว่าง
      if(strlen($idcard)==13){
        $id=str_split($idcard); 
        $sum=0;    
        for($i=0; $i < 12; $i++){
        if(is_numeric($id[$i])){   
             $sum += floatval($id[$i])*(13-$i);            
          if((11-$sum%11)%10!=floatval($id[12])){
             return 2;
         }else{
             return 0; 
         }
        
        }else{
           return 2; 
        } 
        }  
    }else{
        if($idcard==""){
            return 3; 
        }else{
         return 1; 
        }
        
    }   
}




if(!Check_IDCard($xidcard)){

	echo "error";
}else{
	echo "OK";	
}



if(!CheckIDCard($xidcard)){
	echo "FAIL";	
}else{
	echo "K";	
}
?>
