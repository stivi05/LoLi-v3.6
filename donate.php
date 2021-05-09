<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$nick = $CURUSER['username'];
/*$nick = ($CURUSER ? $CURUSER['username'] : ('Guest' . rand(1000, 9999)));*/
stdhead('Donate');begin_frame('.:: Donate ::.');
$currencytype = 'Euro'; #For Fonts
$currencytype2 = '&euro;'; #For Sign
$currencytype3 = 'EUR'; #Main Currency for Donations
$DONATEMAIL = 'email@gmail.com'; #Your Paypal email address here. Same in paypal.php
$siteurl = $DEFAULTBASEURL;
//////////
$user_id = $CURUSER['id'];?>
<table width='98%' style="border:0;" align='center' cellspacing='0' cellpadding='0'>
<tr><td style="border:0;" colspan="4" align='center'>
<center>Thank You for visiting Donations page <b><?=get_user_class_color($CURUSER["class"], $CURUSER['username'])?></b>!<br/>
.:: <? echo date('F');?> Special Offers ::.</center><hr></td></tr>
<tr><td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>5</strong></u></b></font></center><br/>
Donate <b>5</b> <?=$currencytype?> and receive:
<li><b>5GB</b> Upload Credits</li>
<li><b>1</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='amount' value='5'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;" align='center'>
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>10</strong></u></b></font></center><br/>
Donate <b>10</b> <?=$currencytype?> and receive:
<li><b>10GB</b> Upload Credits</li>
<li><b>1</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='10.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>20</strong></u></b></font></center><br/>
Donate <b>20</b> <?=$currencytype?> and receive:
<li><b>20GB</b> Upload Credits</li>
<li><b>2</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='20.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>30</strong></u></b></font></center><br/>
Donate <b>30</b> <?=$currencytype?> and receive:
<li><b>30GB</b> Upload Credits</li>
<li><b>3</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='30.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td></tr>
<tr><td style="border:0;" colspan="4" align='center'><hr></td></tr>
<tr><td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>40</strong></u></b></font></center><br/>
Donate <b>40</b> <?=$currencytype?> and receive:
<li><b>40GB</b> Upload Credits</li>
<li><b>4</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='40.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>50</strong></u></b></font></center><br/>
Donate <b>50</b> <?=$currencytype?> and receive:
<li><b>50GB</b> Upload Credits</li>
<li><b>5</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='50.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Donate <?=$currencytype2?>100</strong></u></b></font></center><br/>
Donate <b>100</b> <?=$currencytype?> and receive:
<li><b>150GB</b> Upload Credits</li>
<li><b>10</b> Invites</li> 
<li><b>VIP</b> Class</li>
<li>Custom Title</li>
<li>Acces to V.I.P Torrents</li>
<li>Donor Sign</li><br/><?if(get_user_class() >= UC_MODERATOR && get_user_class() != UC_SYSOP){}else{?>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='amount' value='100.00'>
<input type='hidden' name='business' value='<?=$DONATEMAIL;?>'>
<input type='hidden' name='item_name' value='V.I.P Account for <?=$nick;?>'>
<input type='hidden' name='item_number' value='1'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='<?=$currencytype3;?>'>
<input type='hidden' name='tax' value='0'>
<input type='hidden' name='no_shipping' value='1'>
<input type='hidden' name='custom' value='$user_id'>
<input type='hidden' name='notify_url' value='paypal.php'>
<div align='bottom'>
<center><input type='image' src='pic/donate2.gif' border='0' name='submit' alt='Donate'></center>
</div></form><?}?></td></tr></tbody></table></td>
<td style="border:0;align:center;">
<table cellpadding='5' border='2px' align='center' cellspacing='0' height='229' width='170'>
<tbody style="border:0;" align='center'><tr><td style="border:0;" align='center'>
<center><font color='red'><b><u><strong>Default for All Donations</strong></u></b></font></center><br/>
When you Donate you get
<li><b>Custom Title</b></li>
<li><b>No Ads</b></li>
<li><b>Donor Sign</b></li>
<li><b>Invites</b></li>
<li>Access to <?=$SITENAME?><br> <b>VIP</b> torrents.</li>
<li><b>No wait time restrictions,<br> regardless your ratio</b></li>
<li><b>Immunity to the auto-ban<br> because of low ratio</b></li>
</td></tr></tbody></table></td></tr>
<tr><td style="border:0;" colspan="4" align='center'><hr></td></tr>
<tr><td style="border:0;align:center;" colspan="4">
<table width='100%' style="border:0;" cellspacing='1' cellpadding='5'>
<tr><td align='left' style="border:0;" width='98%'><b>IMPORTANT NOTES:</b></td></tr>
<tr><td align='left' style="border:0;">
<li>Donations <b>DO NOT</b> exempt you from the rules or from being banned.</li>
<li>Donations will increase your ratio, but normal ratio rules will still apply.</li>
<li>If Age system for torrents is active & your age is under torrents request u can`t download thats torrents</li> 
<b>If you have any problems with your donation or you have not recieved proper credit, send to 
<a href="#" onclick="javascript:window.open('sendpm_1', 'Отправить PM', 'width=650, height=465');return false;" title="Отправить ЛС">
<img src='pic/button_pm.gif' border='0' title='PM'></a> Administrator.</b></font>
<br/><br/><b><font color='red'>All donations will be processed with Paypal IPN, 
this means that right after you will complete the donation process, it will instantly credit your account.</font></b>
</td></tr></table></td></tr></table><?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>