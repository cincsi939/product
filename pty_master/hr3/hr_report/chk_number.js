function Filter_Keyboard() {
  var keycode = window.event.keyCode;
  if( keycode >=37 && keycode <=40 ) return true;  // arrow left, up, right, down  
  if( keycode >=48 && keycode <=57 ) return true;  // key 0-9
  if( keycode >=96 && keycode <=105 ) return true;  // numpad 0-9
  if( keycode ==110 || keycode ==190  ) return true;  // dot
  if( keycode ==8  ) return true;  // backspace
  if( keycode ==9 ) return true;  // tab
  if( keycode ==45 ||  keycode ==46 || keycode ==35 || keycode ==36) return true;  // insert, del, end, home
  return false;
}