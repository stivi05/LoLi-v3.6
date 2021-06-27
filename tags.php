<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
stdhead("Теги");begin_frame(".:: Теги ::.");$test = (string) $_POST["test"];?>
<p><?=$SITENAME?> поддерживает большое количество <i>BB тегов</i> которые вы можете использовать для украшения ваших раздач и постов.</p>
<form method='post' action='tags.php'><textarea name='test' cols='60' rows='3'><?print($test ? htmlspecialchars_uni($test) : "")?></textarea>
<input type='submit' value="Проверить этот код!" style='height:23px;margin-left:5px'></form><?if($test != "") print("<p><hr>".format_comment($test)."<hr></p>");?>

<p class='sub'><b>Bold</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Makes the enclosed text bold.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[b]<i>Text</i>[/b]</tt></td></tr><tr valign='top'><td>Пример:</td>
<td><tt>[b]This is bold text.[/b]</tt></td></tr><tr valign='top'><td>Результат:</td><td><b>This is bold text.</b></td></tr></table>

<p class='sub'><b>Italic</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'>
<tr valign='top'><td width='25%'>Описание:</td><td>Makes the enclosed text italic.</td></tr>
<tr valign='top'><td>Синтаксис:</td><td><tt>[i]<i>Text</i>[/i]</tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[i]This is italic text.[/i]</tt></td></tr>
<tr valign='top'><td>Результат:</td><td><i>This is italic text.</i></td></tr></table>

<p class='sub'><b>Underline</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Makes the enclosed text underlined.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[u]<i>Text</i>[/u]</tt></td></tr><tr valign='top'><td>Пример:</td>
<td><tt>[u]This is underlined text.[/u]</tt></td></tr><tr valign='top'><td>Результат:</td><td><u>This is underlined text.</u></td></tr></table>

<p class='sub'><b>Color (alt. 1)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Changes the color of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[color=<i>Color</i>]<i>Text</i>[/color]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[color=blue]This is blue text.[/color]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="color: blue">This is blue text.</span></td>
</tr><tr><td>Примечание:</td><td>What colors are valid depends on the browser. If you use the basic colors (red, green, blue, yellow, pink etc) you should be safe.</td></tr></table>

<p class='sub'><b>Color (alt. 2)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Changes the color of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[color=#<i>RGB</i>]<i>Text</i>[/color]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[color=#0000ff]This is blue text.[/color]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="color: #0000ff">This is blue text.</span></td>
</tr><tr><td>Примечание:</td><td><i>RGB</i> must be a six digit hexadecimal number.</td></tr></table>

<p class='sub'><b>Size</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Sets the size of the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[size=<i>n</i>]<i>text</i>[/size]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[size=11]This is size 10.[/size]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style='font-size: 11px'>This is size 10.</span></td></tr>
<tr><td>Примечание:</td><td><i>n</i> must be an integer in the range 1 (smallest) to 20 (biggest). The default size is 11.</td></tr></table>

<p class='sub'><b>Font</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Sets the type-face (font) for the enclosed text.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[font=<i>Font</i>]<i>Text</i>[/font]</tt></td></tr><tr valign='top'>
<td>Пример:</td><td><tt>[font=Impact]Hello world![/font]</tt></td></tr><tr valign='top'><td>Результат:</td><td><span style="font-family: Impact">Hello world!</span></td></tr>
<tr><td>Примечание:</td><td>You specify alternative fonts by separating them with a comma.</td></tr></table>

<p class='sub'><b>Hyperlink (alt. 1)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Inserts a hyperlink.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[url]<i>URL</i>[/url]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[url]<?=$DEFAULTBASEURL?>[/url]</tt></td></tr><tr valign='top'><td>Результат:</td><td><a href="<?=$DEFAULTBASEURL?>" title="<?=$DEFAULTBASEURL?>"/><?=$DEFAULTBASEURL?></a>
</td></tr><tr><td>Примечание:</td><td>This tag is superfluous; all URLs are automatically hyperlinked.</td></tr></table>

<p class='sub'><b>Hyperlink (alt. 2)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Inserts a hyperlink.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[url=<i>URL</i>]<i>Link text</i>[/url]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[url=<?=$DEFAULTBASEURL?>]<?=$SITENAME?>[/url]</tt></td></tr><tr valign='top'><td>Результат:</td><td><a href="<?=$DEFAULTBASEURL?>" title="<?=$DEFAULTBASEURL?>"><?=$SITENAME?></a>
</td></tr><tr><td>Примечание:</td><td>You do not have to use this tag unless you want to set the link text; all URLs are automatically hyperlinked.</td></tr></table>

<p class='sub'><b>Image</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Inserts a picture.</td>
</tr><tr valign='top'><td>Синтаксис:</td><td><tt>[img]<i>URL</i>[/img]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[img]<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif[/img]</tt></td></tr><tr valign='top'><td>Результат:</td><td>
<img src="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif" border="0" alt="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif" title="<?=$DEFAULTBASEURL?>/pic/smilies/happy.gif"/>
</td></tr><tr><td>Примечание:</td><td>The URL must end with <b>.gif</b>, <b>.jpg</b> or <b>.png</b>.</td></tr></table>

<p class='sub'><b>Quote (alt. 1)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Inserts a quote.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quote]<i>Quoted text</i>[/quote]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[quote]The quick brown fox jumps over the lazy dog.[/quote]</tt></td></tr><tr valign='top'><td>Результат:</td><td><div align="center"><div style="width: 85%; overflow: auto">
<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center" class="bgcolor4"><tr bgcolor="#A9A9A9"><td><font class="block-title">Цитата</font></td></tr>
<tr class="bgcolor1"><td>The quick brown fox jumps over the lazy dog.</td></tr></table></div></div></td></tr></table>

<p class='sub'><b>Quote (alt. 2)</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td>
<td>Inserts a quote.</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[quote=<i>Author</i>]<i>Quoted text</i>[/quote]</tt></td></tr><tr valign='top'><td>Пример:</td><td>
<tt>[quote=John Doe]The quick brown fox jumps over the lazy dog.[/quote]</tt></td></tr><tr valign='top'><td>Результат:</td><td><div align="center">
<div style="width: 85%; overflow: auto"><table width="100%" cellspacing="1" cellpadding="3" border="0" align="center" class="bgcolor4"><tr bgcolor="#A9A9A9"><td>
<font class="block-title">John Doe писал</font></td></tr><tr class="bgcolor1"><td>The quick brown fox jumps over the lazy dog.</td></tr></table></div></div></td></tr></table>

<p class='sub'><b>List</b></p><table class='main' width='100%' border='1' cellspacing='0' cellpadding='5'><tr valign='top'><td width='25%'>Описание:</td><td>Inserts a list item.
</td></tr><tr valign='top'><td>Синтаксис:</td><td><tt>[li]<i>Text</i></tt></td></tr><tr valign='top'><td>Пример:</td><td><tt>[li] This is item 1 This is item 2</tt></td></tr>
<tr valign='top'><td>Результат:</td><td><li> This is item 1 This is item 2</td></tr></table>
<?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>