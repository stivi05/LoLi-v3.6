<?php if(!defined('BLOCK_FILE')) {Header("Location: ../index.php");exit;}$blocktitle = ".:: До Нового года осталось ::.";
$content=<<<BLOCKHTML
<div align="center"><img src="pic/rojdestvo.gif" alt="rojdestvo" title="rojdestvo"/><style>.lcdstyle{color:#1E90FF;font: bold 18px MS Sans Serif;padding: 3px;}</style><script>
function cdtime(e,t){document.getElementById&&document.getElementById(e)&&(this.container=document.getElementById(e),this.currentTime=new Date,this.targetdate=new Date(t),this.timesup=!1,this.updateTime())}cdtime.prototype.updateTime=function(){var t=this;this.currentTime.setSeconds(this.currentTime.getSeconds()+1),setTimeout(function(){t.updateTime()},1e3)},cdtime.prototype.displaycountdown=function(t,e){this.baseunit=t,this.formatresults=e,this.showresults()},cdtime.prototype.showresults=function(){var t=this,e=(this.targetdate-this.currentTime)/1e3;if(e<0)return this.timesup=!0,void(this.container.innerHTML=this.formatresults());var s=3600,i=86400,o=Math.floor(e/i),n=Math.floor((e-o*i)/s),r=Math.floor((e-o*i-n*s)/60),s=Math.floor(e-o*i-n*s-60*r);"hours"==this.baseunit?(n=24*o+n,o="n/a"):"minutes"==this.baseunit?(r=24*o*60+60*n+r,o=n="n/a"):"seconds"==this.baseunit&&(s=e,o=n=r="n/a"),this.container.innerHTML=this.formatresults(o,n,r,s),setTimeout(function(){t.showresults()},1e3)};function formatresults2(){var s;return 0==this.timesup?s="<span class='lcdstyle'>До нового года осталось...<br>  "+arguments[0]+" <sup>days</sup> "+arguments[1]+" <sup>hours</sup> "+arguments[2]+" <sup>minutes</sup> "+arguments[3]+" <sup>seconds</sup></span> ":(s="",alert("С новым годом!!!")),s}
</script><div id="countdowncontainer2"></div><script>
var currentyear=(new Date).getFullYear(),thischristmasyear=1<=(new Date).getMonth()&&1<(new Date).getDate()?currentyear+1:currentyear,christmas=new cdtime("countdowncontainer2","january 1, "+thischristmasyear+" 0:0:00");christmas.displaycountdown("days",formatresults2);</script></div>
BLOCKHTML;
?>