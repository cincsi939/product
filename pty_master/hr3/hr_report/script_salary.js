
var err_message =0;
var wanning_text='';
var errhis="";
var errsub=false;
var year_position=2547;
var year_radub=2547;
var year_vitaya=2547;
/*
001	������͡�Թ��͹
002	�Թ��͹�е�ͧ����������������ҹ��
003	�Թ��͹��ͧ����¹
004	��ͧ���ѹ��� 1 ��.�. ��� 1 �.�.
005	1 ��.�.- 31 ��.�.  ���1 �.�.- 30 �.�.
006	ʶҹ���ӧҹ��ͧ����¹�
007	������͡ʶҹ���ӧҹ
008	��������͡�Է�аҹ�
009	������͡�Ţ�����˹�
010	�Ţ�����˹觵�ͧ����¹
011	��������͡���˹�
012	���˹觵�ͧ����¹
013	��������͡�дѺ
014	�дѺ����¹ �Թ��͹ ��ͧ����¹
015	�дѺ�������¹ �Թ��͹ ��ͧ�������¹
016 �Թ��͹���١��ͧ����ѧ�Թ��͹
017 �к��ѹ���(�ѹ ��͹ ��)
018 ������к������Ţ�����
019 �к��ѹ�����ҧ�ԧ(�ѹ ��͹ ��)
020 ��ټ����¨�������Է°ҹ�
021 ������͡���˹� 
022 �Թ��͹  mod 5 
023 ����͹�Է�аҹлյ�ͧ�ҡ��� 2546
024 �Ţ�����˹� ����鹵鹴��� � �յ���� 17 �ԧ�Ҥ� 2549
*/


function select_ordertype(value,formevent){	
return true;
/*document.getElementById('tr_selschool').style.display="none";
document.getElementById('tr_money').style.display="none";
document.getElementById('tr_posduty1').style.display="none";
document.getElementById('tr_posduty2').style.display="none";*/
$('#tr_selschool').hide();
$('#tr_money').hide();
$('#tr_posduty1').hide();
$('#tr_posduty2').hide();

var xreturn=true;
switch(value)
{
	case '1'://��è�	        
			 $('#tr_selschool').show();
			xreturn= Check_AssignMode(formevent);			
	break;
	case '18'://��è�	        
			 $('#tr_selschool').show();
			xreturn= Check_chaengSchool(formevent);			
	break;
	case '2'://��������觵��
		if(formevent=="select_order_type"){
			    document.post.select_school_name.value="";
				document.post.select_school_label.value="";
				document.post.select_school.value="";
		
		}
			//document.getElementById('tr_selschool').style.display="block";		
			$('#tr_selschool').show();
			xreturn= Check_MoveMode(formevent);
	break;
	case '3'://����͹�Է°ҹ�
	       // if(document.post.vitaya.value==''){ getvitaya();}
			xreturn= Check_VitayaMode(formevent);
			
	break;
	case '4'://����͹����Թ��͹��Шӻ�			 
			// document.getElementById('tr_money').style.display="block";	
			 $('#tr_money').show();
			xreturn= Check_SalaryMode(formevent);
	break;
	case '5'://�����䢤����	
	break;
	case '6'://��Ѻ������ ���. (��Ѻ����͹�ѵ���Թ��͹����)	
			xreturn=Check_AdjustMode(formevent);
	break;
	case '7'://�͹				
	       $('#tr_selschool').show();
			// document.getElementById('tr_selschool').style.display="block";
			xreturn= Check_TransferMode(formevent);
	break;
	case '8'://���ͧ��Ժѵ��Ҫ���	
			  //xreturn=document.getElementById('tr_selschool').style.display="block";
			 $('#tr_selschool').show();
			
	break;
	case '9'://�鹨ҡ���ͧ��Ժѵ��Ҫ���	
			//xreturn=document.getElementById('tr_selschool').style.display="block";
			 $('#tr_selschool').show();
	break;
	case '10'://�觵������ç���˹�	
			xreturn=Check_AppointMode(formevent);
	break;
	case '11'://�ѡ���Ҫ���㹵��˹�	
	/*	document.getElementById('tr_posduty1').style.display="block";
		document.getElementById('tr_posduty2').style.display="block";*/
		 $('#tr_posduty1').show(); $('#tr_posduty2').show();
	xreturn=Check_onDuty(formevent);
	break;
	case '12'://�͡�ҡ�Ҫ���	
	break;
	case '13'://���֡�ҵ��	
	break;
	case '14'://��á�˹����˹�	
			xreturn=Check_DefineMode(formevent);
	break;
	case '15'://��Ѻ�ҡ���֡�ҵ��	
	break;
	case '17':
	$('#tr_posduty1').show(); $('#tr_posduty2').show();
	xreturn=Check_onDuty2(formevent);
	break;
}
return xreturn;
}

function onobjChange(){
//select_ordertype(document.post.select_type.value,'ObjChange');
}

function checkmod_salary(salary){
  salary=  salary.replace(',','');
   if(parseInt(salary)%5==0){
     return true;
   }else{	   
	    AddMessage('5','�������Թ��͹��è�ŧ���´��� 5  ���� 0 ��ҹ��õ�Ǩ�ͺ�ա����','504022','key','w'); 
		return true;
   }
}




function AddMessage(mode,msg,errcode,formevent,errtype){
	//var temp ={errmode:mode,formevent:formevent,errtype:errtype,errcode:errcode,errmsg:msg,time: new Date}; 
    errsub=true;	
	var temp=new Date;
	var text=$("#err_text").html();
	var erricon="";
	//if(text!=""){text+="<br>";}
	var day=temp.getDate();
	var month=temp.getMonth()+1;
	var year=temp.getFullYear()+543;
	var hh=temp.getHours();
	var mm=temp.getMinutes();
	var ss=temp.getSeconds();	
	
	if(day<10){day="0"+day.toString();}
	if(month<10){month="0"+month.toString();}
	if(hh<10){hh="0"+hh.toString();}
	if(mm<10){mm="0"+mm.toString();}
	if(ss<10){ss="0"+ss.toString();}
	
	var xtime=day+"/"+month+"/"+year+" "+hh+":"+mm+":"+ss
	var xtime2=(year-543)+"-"+month+"-"+day+" "+hh+":"+mm+":"+ss
	if(errtype=="w"){
	    erricon="text_wanning";
		errimg='<img src=\'../../../images_sys/attention.png\' width="18px" height="18px" borer=0>';
	}else if(errtype=="e"){
		erricon="text_wanning";
		errimg='<img src=\'../../../images_sys/close.gif\' width="18px" height="18px" borer=0>';
	}
var xvit=errcode.toString()+formevent.toString();
  if(errhis!=xvit){
	  err_message+=1;
	  var index=err_message;
	  if(index<10){index="0"+index.toString();}
	 errhis=xvit;	 
	text+="<div id=\"listerr\" errmode='"+mode+"' formevent='"+formevent+"'   errtype='"+errtype+"' errcode='"+errcode+"'  time='"+xtime2+"' errmsg='"+msg+"' class='"+erricon+"'>"+errimg+ index+ ":> ["+xtime+"] "+msg+"</div>" ;
	$("#err_text").html(text);
	}




	if(msghide){
	   // $("#info").animate({left:0});
		msghide=false
		$("#info").animate({left:0}).fadeOut(500).fadeIn(500).fadeOut(300).fadeIn(300).fadeOut(400).fadeIn(400,endpage());
	}else{
		$("#info").fadeOut(500).fadeIn(500,addlineendpage());
	}  
}
function addlineendpage(){

		var boxerr= $("#boxerror").height();
			var texterr=$("#err_text").height();			
			 var pos = $("#err_text").position();			
		if( texterr+pos.top>boxerr||pos.top<=3){ 			  
			   	$("#err_text").animate({top:boxerr-(texterr+3)});	
			   
		}
}
function endpage(){
	setTimeout('addlineendpage()',1000);
}
function Check_SalaryMode(formevent){//����͹����Թ��͹��Шӻ�
 var year=document.post.salary_year.value;
	var month=document.post.salary_month.value;
	var day=document.post.salary_day.value;
	var selschool=document.post.select_school.value;
	var selschool_label=document.post.select_school_name.value;
	var money=document.post.salary.value;	
	/*var now=new Date(year,month,day);
	var xpass=false;
	if(def_date!=""){
		var x = new Array();
		x=def_date.split('-');
	    var xdate =new Date((x[0]-543),x[1],x[2]);
		if(now<xdate){ var xpass=true;}
	}*/
	
	money=money.replace(',','');
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	 if(day==1&&(month==4||month==10)){	
	      if(money.length==0){
				errcode="504001";
				errmsg="����͹����Թ��͹��Шӻ� :������͡�Թ��͹";
				errstatus=false
				errtype="e";
		   }else{
			   if(parseInt(money)>=parseInt(def_salary)){
				 if(year>=2538&&year<=2552){
					getlevel_salary();
				  }   
			   }else{
				   if(document.post.action.value!='edit2'){
					errcode="504002";
					errmsg="����͹����Թ��͹��Шӻ� :�Թ��͹�е�ͧ����������������ҹ��";
					errstatus=false
					errtype="e";
				   }
			   }
		    }
	 }else{
		errcode="504004";
		errmsg="����͹����Թ��͹��Шӻ� : ������ѹ��� 1 ��.�. ��� 1 �.�.";
		errstatus=true;
		errtype="w";
	 }
      if(errtype!=""){
			   AddMessage(4,errmsg,errcode,formevent,errtype);
		}
	return errstatus;	
	
}
function Check_onDuty(formevent){//�ѡ�ҡ��
    var pos_id=document.post.pos_onduty.value;
	var pos_label=document.post.post_dutylabel.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if(formevent!="select_order_type"){
		if(pos_id.length==0&&pos_label.length==0){
		errcode="511021";
	    errmsg="�ѡ���Ҫ���㹵��˹� : ������͡���˹觷���ѡ�ҡ��";
	    errstatus=false;
		errtype="e"
		}
	}	
	if(errtype!=""){
			   AddMessage(11,errmsg,errcode,formevent,errtype);
		}
	return errstatus;
}
function Check_onDuty2(formevent){//�ѡ�ҡ��
    var pos_id=document.post.pos_onduty.value;
	var pos_label=document.post.post_dutylabel.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if(formevent!="select_order_type"){
		if(pos_id.length==0&&pos_label.length==0){
		errcode="511021";
	    errmsg="�觵��(��Ժѵ��Ҫ���) : ������͡���˹觷�軯Ժѵ��Ҫ���";
	    errstatus=false;
		errtype="e"
		}
	}	
	if(errtype!=""){
			   AddMessage(17,errmsg,errcode,formevent,errtype);
		}
	return errstatus;
}
function Check_MoveMode(formevent){//��������觵��
	var year=document.post.salary_year.value;
	var month=document.post.salary_month.value;
	var day=document.post.salary_day.value;
	var selschool=document.post.select_school.value;
	var selschool_label=document.post.select_school_name.value;
	var position=document.post.hr_addposition.value;
	var noposition=document.post.noposition.value;
	var hr_addradub=document.post.hr_addradub.value; 
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if((day>=1&&day<=30&&month==9)||(day>=1&&day<=31&&month==3)){
		errcode="502005";
	    errmsg="�ѹ������¨Ф���������㹪�ǧ�Ѻ��� :1 ��.�.- 31 ��.�.  ���1 �.�.- 30 �.�.";
	    errstatus=true;
		errtype="w"
	}
	if(!errstatus||errtype==""){		
	if(noposition.length==0&&year>2547){		
			errmsg="��������觵�� ������͡�Ţ�����˹�";
			errstatus=false;
			errcode='502009';
			errtype="e";	   
	}else if(position.length==0){		
			errmsg="��������觵�� ��������͡���˹�";
			errstatus=false;
			errcode='502011';
			errtype="e";		
	}else if(hr_addradub.length==0&&year>=2547){		
				errmsg="��������觵�� ��������͡�дѺ";
				errstatus=false;
				errcode='502013';
				errtype="e";		
	}else if(formevent!="select_order_type"){	
		 if(selschool.length>0){
			if(selschool==def_school&&(document.post.action.value!='edit2')){
				errcode="502006";
				errmsg="��������觵�� ʶҹ���ӧҹ��ͧ����¹�";
				errstatus=true;	
				errtype="w"
		      }
		 }else{			
		    if(selschool_label.length>0){	
			//||def_ordertype!=document.post.select_type.value
				if(selschool_label==def_schoolname&&(document.post.action.value!='edit2')){
					errcode="502006";
					errmsg="��������觵�� ʶҹ���ӧҹ��ͧ����¹�";
					errstatus=true;	
					errtype="e"
		        } 
			}else{				
				errcode="502007";
				errmsg="��������觵�� ������͡ʶҹ���ӧҹ";
				errstatus=true;	
				errtype="w"
			}		  
		  }		  
		}
	}
			
		if(errtype!=""){
			   AddMessage(2,errmsg,errcode,formevent,errtype);
		}
	return errstatus;		
		
}
function Check_VitayaMode(formevent){//����͹�Է°ҹ�
	var position=document.post.hr_addposition.value;
	var vitaya=document.post.vitaya.value;
	var year=document.post.salary_year.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
//	alert (position);

	 if(year<year_vitaya){
		errmsg="����͹�Է°ҹ� �յ�ͧ�ҡ���� 2546";
		errstatus=false;
		errcode='503023';
		errtype="e"
		document.post.select_type.selectedIndex=0;
	}else if(position=='425471006'){
		errmsg="����͹�Է°ҹ� ��ټ����¨�������Է°ҹ�";
		errstatus=false;
		errcode='503020';
		errtype="e"
		document.post.select_type.selectedIndex=0;
	}else if(vitaya.length==0){
	    errmsg="����͹�Է°ҹ� ��������͡�Է°ҹ�";
		errstatus=false;
		errcode='503008';
		errtype="e"
	}
	
	if(errtype!=""){
	   AddMessage(3,errmsg,errcode,formevent,errtype);
	}
	return errstatus;	
	
}
function Check_AppointMode(formevent){//�觵������ç���˹�
	var money=document.post.salary.value;
	money=money.replace(',','');
	var position=document.post.hr_addposition.value;
	var noposition=document.post.noposition.value;
	var hr_addradub=document.post.hr_addradub.value; 
	var year=document.post.salary_year.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if(noposition==def_noposition||noposition.lenght==0){
		if(position.lenght==0&&year>2547){
			errmsg="�觵������ç���˹� ������͡�Ţ�����˹�";
			errstatus=false;
			errcode='510009';
			errtype="e"
	    }else{	
			if(document.post.action.value!='edit2'){
			/*errmsg="�觵������ç���˹� �Ţ�����˹觵�ͧ����¹";
			errstatus=true;
			errcode='510010';
			errtype="w";*/
			}
		}
	}else if(position==def_position||position.lenght==0){
		if(position.lenght==0){
			errmsg="�觵������ç���˹� ��������͡���˹�";
			errstatus=false;
			errcode='510011';
			errtype="e";
		}else{	
		if((document.post.action.value!='edit2')){
			errmsg="�觵������ç���˹� ���˹觵�ͧ����¹";
			errstatus=false;
			errcode='510012';
			errtype="e";
		}
		}
	}else if(hr_addradub!=def_radub||hr_addradub.length==0){
		if(hr_addradub.length==0&&year>=2547){
		        errmsg="�觵������ç���˹� ��������͡�дѺ";
				errstatus=false;
				errcode='510013';
				errtype="e";
		}else{
			if(def_salary==money&&(document.post.action.value!='edit2')){
				/*errmsg="�觵������ç���˹� �дѺ����¹ �Թ��͹ ��ͧ����¹";
				errstatus=false;
				errcode='510014';
				errtype="e";*/
			}
		
		}
		
	  	
	}else if(hr_addradub==def_radub){
	if(def_salary!=money&&(document.post.action.value!='edit2')){
		/*errmsg="�觵������ç���˹� �дѺ�������¹ �Թ��͹ ��ͧ�������¹";
		errstatus=false;
		errcode='510015';
		errtype="e";*/
		}
	}
	
	if(errtype!=""){
	   AddMessage(10,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}
function Check_chaengSchool(formevent){
	 var money=document.post.salary.value;
	var position=document.post.hr_addposition.value;
	var noposition=document.post.noposition.value;  
	var hr_addradub=document.post.hr_addradub.value; 
	var year=document.post.salary_year.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	money=money.replace(',','');
	 if(noposition.length==0&&year>2547){
		errmsg="����¹����ʶҹ�֡�� ������͡�Ţ�����˹�";
		errstatus=false;
		errcode='518009';
		errtype="e";
	
	}else if(money.length==0){
		errmsg="����¹����ʶҹ�֡�� ������͡�Թ��͹";
		errstatus=false;
		errcode='518001';
		errtype="e";
	}else if(position.length==0){
		errmsg="����¹����ʶҹ�֡�� ��������͡���˹�";
		errstatus=false;
		errcode='518011';
		errtype="e";
	}else if(hr_addradub.length==0&&year>=2547){
        errmsg="����¹����ʶҹ�֡�� ��������͡�дѺ";
		errstatus=false;
		errcode='518013';
		errtype="e";
	}
	if(errtype!=""){
	   AddMessage(1,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}

function Check_AssignMode(formevent){//����觺�è�
	var money=document.post.salary.value;
	var position=document.post.hr_addposition.value;
	var noposition=document.post.noposition.value;  
	var hr_addradub=document.post.hr_addradub.value; 
	var year=document.post.salary_year.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	money=money.replace(',','');
	 if(noposition.length==0&&year>2547){
		errmsg="����觺�è� ������͡�Ţ�����˹�";
		errstatus=false;
		errcode='501009';
		errtype="e";
	
	}else if(money.length==0){
		errmsg="����觺�è� ������͡�Թ��͹";
		errstatus=false;
		errcode='501001';
		errtype="e";
	}else if(position.length==0){
		errmsg="����觺�è� ��������͡���˹�";
		errstatus=false;
		errcode='501011';
		errtype="e";
	}else if(hr_addradub.length==0&&year>=2547){
        errmsg="����觺�è� ��������͡�дѺ";
		errstatus=false;
		errcode='501013';
		errtype="e";
	}
	if(errtype!=""){
	   AddMessage(1,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}
function Check_TransferMode(formevent){//�͹
  	var money=document.post.salary.value;
	money=money.replace(',','');
	var position=document.post.hr_addposition.value;
	var noposition=document.post.noposition.value;
	var hr_addradub=document.post.hr_addradub.value; 
	var year=document.post.salary_year.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if(noposition==def_noposition||noposition.lenght==0){
		if(position.lenght==0&&year>2547){
			errmsg="�͹ ������͡�Ţ�����˹�";
			errstatus=false;
			errcode='507009';
			errtype="e";
	    }else{	
			if(document.post.action.value!='edit2'){
/*				errmsg="�͹ �Ţ�����˹觵�ͧ����¹";
				errstatus=true;
				errcode='507010';
				errtype="w";*/
			}
		}
	}else if(position.lenght==0){		
			errmsg="�͹ ��������͡���˹�";
			errstatus=true;
			errcode='507011';			
	}else if(hr_addradub!=def_radub||hr_addradub.length==0){
		if(hr_addradub.length==0&&year>=2547){
		        errmsg="�͹ ��������͡�дѺ";
				errstatus=false;
				errcode='507013';
				errtype="e";
		}else{
			if(def_salary==money&&(document.post.action.value!='edit2')){
				/*errmsg=" �͹ �дѺ����¹ �Թ��͹ ��ͧ����¹";
				errstatus=false;
				errcode='507014';
				errtype="e";*/
			}
		
		}
		
	  	
	}else if(hr_addradub==def_radub){
	if(def_salary!=money&&(document.post.action.value!='edit2')){
		/*errmsg="�͹ �дѺ�������¹ �Թ��͹ ��ͧ�������¹";
		errstatus=false;
		errcode='507015';
		errtype="e";*/
		}
	}
	
	
	//alert(errtype);
	
	if(errtype!=""){
	   AddMessage(7,errmsg,errcode,formevent,errtype);
	}
	return errstatus;	
}
function Check_AdjustMode(formevent){//��Ѻ������ ���. (��Ѻ����͹�ѵ���Թ��͹����)
 	var money=document.post.salary.value;
	money=money.replace(',','');	
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if(money.length==0){
	    errmsg="��Ѻ������ ���. ������͡�Թ��͹";
		errstatus=true;
		errcode='506001';	
		errtype="e";
    }else if(def_salary==money&&(document.post.action.value!='edit2')){
		errmsg="��Ѻ������ ���. �Թ��͹��ͧ����¹";
		errstatus=false;
		errcode='506003';
		errtype="e";
	}
	
	if(errtype!=""){
	   AddMessage(6,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}
function Check_DefineMode(formevent){//��á�˹����˹�
	var position=document.post.hr_addposition.value;
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
    if(position.length==0){
	    errmsg="��˹����˹� ��������͡���˹�";
		errstatus=false;
		errcode='514011';
		errtype="e"
	}else  if(position==def_position&&(document.post.action.value!='edit2')){
	    errmsg="��˹����˹� ���˹觵�ͧ����¹";
		errstatus=false;
		errcode='514012';
		errtype="e";
	}
	if(errtype!=""){
	   AddMessage(14,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}

function Check_numberPosition(formevent){//��á�˹��Ţ�����˹�  ( �Ţ�����˹� ����鹵鹴���  �  �յ���� 17 �ԧ�Ҥ� 2549  )
	var numPosition=$('#noposition').val();
	var errcode="";
	var errmsg="";
	var errstatus=true;
	var errtype="";
	if($('#hr_addposition_group').val()==strType38){
			if(numPosition.substr(0,1)=='�'){
					day=$('#salary_day').val();
					month=$('#salary_month').val();
					year=$('#salary_year').val();
					
					if((year*1)==0){
							a=1;
					}else{
							a=chkDateCompair(17,08,2549,day,month,year);
					}
					if(a=='0'){
							errmsg="�Ţ�����˹� ����鹵鹴���  �  �յ���� 17 �ԧ�Ҥ� 2549";
							errstatus=true;
							errcode='000024';
							errtype="w";
					}else{
							errmsg="�Ţ�����˹� ����鹵鹴���  �  �յ���� 17 �ԧ�Ҥ� 2549";
							errstatus=true;
							errcode='000024';
							errtype="";
					}
			}
	}
	
	if(errtype!=""){
	   AddMessage(0,errmsg,errcode,formevent,errtype);
	}
	return errstatus;
}

//  function �ӡ�����º��º�ѹ��͹��  ����դ���ҡ������ҡѺ  return 1  else  return 0
function chkDateCompair(day_static,month_static,year_static,day,month,year){
		chkDT=0;
		day_static=day_static*1;
		month_static=month_static*1;
		year_static=year_static*1;
		day=day*1;
		month=month*1;
		year=year*1;
		if(year>=year_static){
				if(year==year_static){
						if(month>=month_static){
								if(month==month_static){
										if(day>=day_static){
												chkDT=1;
										}else{
												chkDT=0;
										}
								}else{
										chkDT=1;
								}
						}else{
								chkDT=0;
						}
				}else{
						chkDT=1;
				}
		}else{
				chkDT=0;
		}
		return  chkDT;
}