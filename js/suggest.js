jQuery,keyStr="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",encode64=function(r){var t,e,n,o,a,h,c="",i=0;for(r=utf8_encode(r);i<r.length;)n=(h=r.charCodeAt(i++))>>2,o=(3&h)<<4|(t=r.charCodeAt(i++))>>4,a=(15&t)<<2|(e=r.charCodeAt(i++))>>6,h=63&e,isNaN(t)?a=h=64:isNaN(e)&&(h=64),c=c+this.keyStr.charAt(n)+this.keyStr.charAt(o)+this.keyStr.charAt(a)+this.keyStr.charAt(h);return c},utf8_encode=function(r){r=r.replace(/\r\n/g,"\n");for(var t="",e=0;e<r.length;e++){var n=r.charCodeAt(e);n<128?t+=String.fromCharCode(n):(127<n&&n<2048?t+=String.fromCharCode(n>>6|192):(t+=String.fromCharCode(n>>12|224),t+=String.fromCharCode(n>>6&63|128)),t+=String.fromCharCode(63&n|128))}return t},$(document).ready(function(){$("#suggestinput").keyup(function(){var r=encode64($(this).val());$.get("suggest.php",{q:r},function(r){$("#suggest").html(r)})})});