function $(e){return"string"==typeof e&&(e=document.getElementById(e)),e}function collect(e,t){for(var n=[],o=0;o<e.length;o++){var c=t(e[o]);null!=c&&n.push(c)}return n}ajax={x:function(){try{return new ActiveXObject("Msxml2.XMLHTTP")}catch(e){try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(e){return new XMLHttpRequest}}}},ajax.serialize=function(t){function n(e){return e.name?encodeURIComponent(e.name)+"="+encodeURIComponent(e.value):""}var e=function(e){return t.getElementsByTagName(e)},o=collect(e("input"),function(e){if("radio"!=e.type&&"checkbox"!=e.type||e.checked)return n(e)}),c=collect(e("select"),n),e=collect(e("textarea"),n);return o.concat(c).concat(e).join("&")},ajax.send=function(e,t,n,o){var c=ajax.x();c.open(n,e,!0),c.onreadystatechange=function(){4==c.readyState&&t(c.responseText)},"POST"==n&&c.setRequestHeader("Content-type","application/x-www-form-urlencoded"),c.send(o)},ajax.get=function(e,t){ajax.send(e,t,"GET")},ajax.gets=function(e){var t=ajax.x();return t.open("GET",e,!1),t.send(null),t.responseText},ajax.post=function(e,t,n){ajax.send(e,t,"POST",n)},ajax.update=function(e,t){var n=$(t);ajax.get(e,function(e){n.innerHTML=e})},ajax.submit=function(e,t,n){var o=$(t);ajax.post(e,function(e){o.innerHTML=e},ajax.serialize(n))};var pos=0,count=0;function noenter(e){return suggcont=document.getElementById("suggcontainer"),"block"!=suggcont.style.display||(13!=e||(choiceclick(document.getElementById(pos)),!1))}function suggest(e,n){38==e?goPrev():40==e?goNext():13!=e&&(3<n.length?(t=new Date,ajax.get("users_suggest.php?q="+n+"&bla="+t.getTime(),update)):update(""))}function update(e){if(arr=new Array,arr=e.split("\r\n"),count=10<arr.length?10:arr.length,suggdiv=document.getElementById("suggestions"),suggcont=document.getElementById("suggcontainer"),0<arr[0].length)for(suggcont.style.display="block",suggdiv.innerHTML="",suggdiv.style.height=20*count,i=1;i<=count;i++)novo=document.createElement("div"),suggdiv.appendChild(novo),novo.id=i,novo.style.height="14px",novo.style.padding="3px",novo.onmouseover=function(){select(this,!0)},novo.onmouseout=function(){unselect(this,!0)},novo.onclick=function(){choiceclick(this)},novo.innerHTML=arr[i-1];else suggcont.style.display="none",count=0}function select(e,t){e.style.backgroundColor="#3399ff",e.style.color="#ffffff",t&&unselectAllOther(pos=e.id)}function unselect(e,t){e.style.backgroundColor="#ffffff",e.style.color="#000000",t&&(pos=0)}function goNext(){pos<=count&&0<count&&(document.getElementById(pos)&&unselect(document.getElementById(pos)),pos++,document.getElementById(pos)?select(document.getElementById(pos)):pos=0)}function goPrev(){0<count&&(document.getElementById(pos)?(unselect(document.getElementById(pos)),pos--,document.getElementById(pos)?select(document.getElementById(pos)):pos=0):(pos=count,select(document.getElementById(count))))}function choiceclick(e){document.getElementById("searchinput").value=e.innerHTML,pos=count=0,suggcont=document.getElementById("suggcontainer"),suggcont.style.display="none",document.getElementById("searchinput").focus()}function closechoices(){suggcont=document.getElementById("suggcontainer"),"block"==suggcont.style.display&&(pos=count=0,suggcont.style.display="none")}function unselectAllOther(e){for(i=1;i<=count;i++)i!=e&&(document.getElementById(i).style.backgroundColor="#ffffff",document.getElementById(i).style.color="#000000")}document.onclick=function(){closechoices()};