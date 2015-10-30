<div id="waitDiv" style="position:absolute; visibility:hidden; right:474px; top:177px;" align="center">
<img id="waitIMG" src="images/web/loading.gif" width="24" height="24" align="absmiddle">&nbsp;<font class="normal_blue">Loading...</font>
</div>
<script language="javascript">
<!-- -------------------------------------------------------Loading Page -->
function windowwidth() {
     if (navigator.userAgent.indexOf("MSIE") > 0) w=document.body.clientWidth;
     else w=window.outerWidth;
     return w;
}
function windowheight() {
     if (navigator.userAgent.indexOf("MSIE") > 0) h=document.body.clientHeight;
     else h= window.outerHeight;
     return h;
}
var DHTML = (document.getElementById || document.all || document.layers);
if (DHTML) {
     var obj=document.getElementById("waitDiv");
     obj.style.left=(windowwidth()-waitIMG.width)/2;
     obj.style.top=(windowheight()-waitIMG.height)/2;
}
function ap_getObj(name) { 
     if (document.getElementById) { 
          return document.getElementById(name).style; 
     } else if (document.all) { 
          return document.all[name].style; 
     } else if (document.layers) { 
          return document.layers[name]; 
     } 
} 
function ap_showWaitMessage(div, flag)  { 
     if (!DHTML) return; 
     var x = ap_getObj(div); x.visibility = (flag) ? 'visible':'hidden'
} 
<!-- --------------------------------------------------End Loading Page -->
ap_showWaitMessage('waitDiv', 1);
</script>