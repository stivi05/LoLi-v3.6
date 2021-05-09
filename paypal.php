<?php require_once("include/bittorrent.php");dbconn(true);gzip();
// read the post from PayPal system and add 'cmd'
if(!mkglobal("item_name:item_number:payment_status:mc_gross:mc_currency:txn_id:receiver_email:payer_email:custom")){?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value){
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";}
// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$paypal_email = 'email@gmail.com'; #Your Paypal email address here. Same in paypal.php
$clid = $_POST['custom'];
if(!$fp){?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?
}else{fputs ($fp, $header . $req);
while(!feof($fp)){
$res = fgets ($fp, 1024);
if(strcmp ($res, "VERIFIED") == 0){
if ($receiver_email == $paypal_email && $payment_status == "Completed"){
if ($payment_amount == 5){$donb = 5368709120;$invites = 1;}
elseif ($payment_amount == 10){$donb = 10737418240;$invites = 1;}
elseif ($payment_amount == 20){$donb = 21474836480;$invites = 2;}
elseif ($payment_amount == 30){$donb = 32212254720;$invites = 3;}
elseif ($payment_amount == 40){$donb = 42949672960;$invites = 4;}
elseif ($payment_amount == 50){$donb = 53687091200;$invites = 5;}
elseif ($payment_amount == 100){$donb = 161061273600;$invites = 10;}
else{$donb = 1073741824*$payment_amount;$invites = 0;}
if($payment_amount == 5 || $payment_amount == 10 || $payment_amount == 20 || $payment_amount == 30 || $payment_amount == 40 || $payment_amount == 50){
$class = 7;/// class VIP - 7, kakoy u vas smotrite sami!
$query = "UPDATE users SET donated = donated + '$payment_amount', class=$class, warned ='no', invites = invites + $invites, uploaded = uploaded + $donb WHERE id='$clid'";
$result = mysql_query($query);}}
}elseif(strcmp ($res, "INVALID") == 0){header("Refresh: 3;url=user_$clid");}}fclose ($fp);}?>