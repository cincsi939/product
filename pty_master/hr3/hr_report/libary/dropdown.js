// ----- Popup Control ---------------------------------------------------------

function at_display(x)
{
  win = window.open();
  for (var i in x) win.document.write(i+' = '+x[i]+'<br>');
}

// ----- Show Aux -----

function at_show_aux(parent, child)
{
  var p 		= document.getElementById(parent);
  var c 		= document.getElementById(child);

  var top  	= (c["at_position"] == "y") ? p.offsetHeight 	+2 : 0;
  var left 	= (c["at_position"] == "x") ? p.offsetWidth  	+2 : 0;

  for (; p; p = p.offsetParent)
  {
    top  		+= p.offsetTop;
    left 		+= p.offsetLeft;
  }

  c.style.position   	= "absolute";
  c.style.top        	= top+'px';
  c.style.left       		= left+'px';
  c.style.visibility 	= "visible";
}

// ----- Show -----

function at_show()
{
  p = document.getElementById(this["at_parent"]);
  c = document.getElementById(this["at_child" ]);

  at_show_aux(p.id, c.id);

  clearTimeout(c["at_timeout"]);
}

// ----- Hide -----

function at_hide()
{
  c = document.getElementById(this["at_child"]);

  c["at_timeout"] = setTimeout("document.getElementById('"+c.id+"').style.visibility = 'hidden'", 333);
}

// ----- Click -----

function at_click()
{
  p = document.getElementById(this["at_parent"]);
  c = document.getElementById(this["at_child" ]);

  if (c.style.visibility != "visible") at_show_aux(p.id, c.id);
  else c.style.visibility = "hidden";

  return false;
}

// ----- Attach -----
function at_attach(parent, child, showtype, position, cursor)
{
  p = document.getElementById(parent);
  c = document.getElementById(child);

  p["at_parent"]   	= p.id;
  c["at_parent"]     	= p.id;
  p["at_child"]      	= c.id;
  c["at_child"]      	= c.id;
  p["at_position"]   	= position;
  c["at_position"]   	= position;

  c.style.position   	= "absolute";
  c.style.visibility 	= "hidden";

  if (cursor != undefined) p.style.cursor = cursor;

  switch (showtype)
  {
    case "click":
      p.onclick     			= at_click;
      p.onmouseout 		= at_hide;
      c.onmouseover		= at_show;
      c.onmouseout  	= at_hide;
      break;
    case "hover":
      p.onmouseover	= at_show;
      p.onmouseout  	= at_hide;
      c.onmouseover 	= at_show;
      c.onmouseout  	= at_hide;
      break;
  }
}
