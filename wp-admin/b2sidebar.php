<?php
/* <Sidebar> */

$mode = "sidebar";

$standalone = 1;
require_once("b2header.php");

get_currentuserinfo();

// just your usual browser thing because we're still too far from standards
$is_gecko = preg_match("/Gecko/",$HTTP_USER_AGENT);
$is_winIE = ((preg_match("/MSIE/",$HTTP_USER_AGENT)) && (preg_match("/Win/",$HTTP_USER_AGENT)));
$is_macIE = ((preg_match("/MSIE/",$HTTP_USER_AGENT)) && (preg_match("/Mac/",$HTTP_USER_AGENT)));
$is_IE    = (($is_macIE) || ($is_winIE));

if ($user_level == 0)
	die ("Cheatin' uh ?");

$request = " SELECT * FROM $tablesettings ";
$result = mysqli_query( $wpdb->dbh,$request);
while($row = mysqli_fetch_object($result)) {
	$time_difference=$row->time_difference;
}

if ($a=="b") {

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="b2.css" type="text/css" />
</head>
<body>
<br />
<table cellspacing="0" cellpadding="15" width="90%" border="0" style="border-color: #cccccc; border-width:1; border-style: solid;" align="center">
	<td>
	<p>Posted !</p>
	<p><a href="b2sidebar.php">Click here</a> to post again.</p>
	</td>
</table>
</body>
</html><?php

} else {

?><html>
<head>
<title>WordPress > sidebar</title>
<link rel="stylesheet" href="b2.css" type="text/css">

<style type="text/css">
<!--
body {
	background-image: url('../b2-img/wpminilogo.png');
	background-repeat: no-repeat;
	background-position: 50px 90px;
	padding: 3px;
}
textarea,input,select {
	font-family: arial,helvetica,sans serif;
	font-size: 12px;
	background-color: transparent;
<?php if ($is_gecko || $is_macIE) { ?>
	background-image: url('../b2-img/bgbookmarklet3.gif');
<?php } elseif ($is_winIE) { ?>
	background-color: #dddddd;
	filter: alpha(opacity:80);
<?php } ?>
	border-width: 1px;
	border-color: #cccccc;
	border-style: solid;
	padding: 2px;
	margin: 1px;
}
<?php if (!$is_gecko) { ?>
.checkbox {
	background-color: #ffffff;
	border-width: 0px;
	padding: 0px;
	margin: 0px;
}
<?php } ?>
-->
</style>
</head>
<body>
<form name="post" action="b2edit.php" method="POST" accept-charset="iso-8859-1">
<input type="hidden" name="action" value="post" />
<input type="hidden" name="user_ID" value="<?php echo $user_ID ?>" />
<input type="hidden" name="mode" value="sidebar" />

<input type="text" name="post_title" size="20" tabindex="1" style="width: 100%;" value="Title" onFocus="if (this.value=='Title') { this.value='';}" onBlur="if (this.value=='') {this.value='Title';}" />

<?php dropdown_categories(); ?>

<textarea rows="8" cols="12" style="width: 100%" name="content" tabindex="2" class="postform" wrap="virtual" onFocus="if (this.value=='Post') { this.value='';}" onBlur="if (this.value=='') {this.value='Post';}">Post</textarea>

<?php if ($use_pingback) { ?>
<input type="checkbox" class="checkbox" name="post_pingback" value="1" checked="checked" tabindex="5" id="pingback" /><label for="pingback"> PingBack</label>
<?php } ?>

<input type="submit" name="submit" value="Blog this !" class="search" tabindex="3" /> 

<?php
if ($use_trackback) { ?>
<br /><label for="trackback"><b>TrackBack</b> an URL:</label><br /><input type="text" name="trackback_url" style="width: 100%" id="trackback" tabindex="7" />
<?php } ?>

<script language="JavaScript">
<!--
//				document.blog.post_content.focus();
//-->
</script>
</td>
</tr>
</table>
</div>

</form>


</body>
</html><?php
}
?>
