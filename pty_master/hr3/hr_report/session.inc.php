<?
// ============================================================
// @1/8/2550 ให้ php จัดการ session ผ่านทาง url แทน cookie
// ============================================================
@ini_set("session.use_trans_sid", "1"); 
//@ini_set("session.use_cookies", "Off"); 
@ini_set("url_rewriter.tags", "a=href,area=href,frame=src,fieldset=");
// ============================================================
?>