
<!--
ie4 = ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4 ))
			
ns4 = ((navigator.appName == "Netscape") &&	(parseInt(navigator.appVersion) >= 4 ))

function openwin( urlpage, width, height,newwin) {
        center = 1;                                
        xpos=0; ypos=0;
        if ((parseInt(navigator.appVersion) >= 4 ) && (center)){
                xpos = (screen.width - width) / 2;
                ypos = (screen.height - height) / 2;
        }
        arg = "width=" + width + "," 
        + "height=" + height + "," 
        + "location=0"	// address bar
        + "menubar=0,"
        + "resizable=no,"
        + "scrollbars=no,"
        + "status=0," 
        + "toolbar=0,"
        + "screenx=" + xpos + ","  // Netscape
        + "screeny=" + ypos + ","  // Netscape
        + "left=" + xpos + ","     // IE
        + "top=" + ypos;           // IE

        window.open( urlpage,'newwin',arg );
}
//  �á  <script src="inc/javaopenwin.js" type="text/javascript" language="javascript"></script>
//  ���������ҧ tag <head> �Ѻ </head> ���� 	****** ���ѧ**** �ç src ��ҧ���� File and path ���١��ͧ
//  �͹���¡��� html 㪁ECode �ѧ�ՁE   ==> <a href ='#' onclick="openwin('detail.php?id=1',300,200)">xxx</a>
//-->
function openwin2( urlpage, width, height,newwin) {
        center = 1;                                
        xpos=0; ypos=0;
        if ((parseInt(navigator.appVersion) >= 4 ) && (center)){
                xpos = (screen.width - width) / 2;
                ypos = (screen.height - height) / 2;
        }
        arg = "width=" + width + "," 
        + "height=" + height + "," 
        + "location=0"	// address bar
        + "menubar=0,"
        + "resizable=yes,"
        + "status=0," 
        + "toolbar=0,"
        + "screenx=" + xpos + ","  // Netscape
        + "screeny=" + ypos + ","  // Netscape
        + "left=" + xpos + ","     // IE
        + "top=" + ypos;           // IE

        window.open( urlpage,'newwin',arg );
}
function openwin3( urlpage, width, height,newwin) {
        center = 1;                                
        xpos=0; ypos=0;
        if ((parseInt(navigator.appVersion) >= 4 ) && (center)){
                xpos = (screen.width - width) / 2;
                ypos = (screen.height - height) / 2;
        }
        arg = "width=" + width + "," 
        + "height=" + height + "," 
        + "location=0"	// address bar
        + "menubar=0,"
        + "resizable=yes,"
        + "scrollbars=yes,"		
        + "status=0," 
        + "toolbar=1,"
        + "screenx=" + xpos + ","  // Netscape
        + "screeny=" + ypos + ","  // Netscape
        + "left=" + xpos + ","     // IE
        + "top=" + ypos;           // IE
//alert ("newwin");
        window.open( urlpage,newwin,arg );
}