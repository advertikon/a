/**
 * JavaScript functions
 *
 * It's make your life easier =)
 *
 * @package     WordPress
 * @subpackage  RED Starter Theme
 * @since       1.0.0
 * @author      Luke Kortunov
 *
 *
 *
 * === TABLE CONTENTS ===
 *
 * @function get_cookie() - get cookie value by name
 * @function set_cookie() - set cookie with name, value and options
 * @function del_cookie() - delete cookie by name
 *
 */



function get_cookie( name ){
  var matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}



function set_cookie( name, value, options ){
  options = options || {};

  var expires = options.expires;

  if (typeof expires === "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}



function del_cookie( name ){
  set_cookie( name, "", { expires: -1 } );
}



function getChar(event) {
  if (event.which == null) {
    if (event.keyCode < 32) return null;
    return String.fromCharCode(event.keyCode)
  }

  if (event.which!=0 && event.charCode!=0) {
    if (event.which < 32) return null;
    return String.fromCharCode(event.which)
  }

  return null;
};