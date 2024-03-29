<?php $title = "Profile";
/* <Profile | My Profile> */

function add_magic_quotes($array) {
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$array[$k] = add_magic_quotes($v);
		} else {
			$array[$k] = addslashes($v);
		}
	}
	return $array;
}
if ( !function_exists('get_magic_quotes_gpc') ) {
    function get_magic_quotes_gpc()
    {
        return false;
    }
}

if (!get_magic_quotes_gpc()) {
	$_GET    = add_magic_quotes($_GET);
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$b2varstoreset = array('action','standalone','redirect','profile','user');
for ($i=0; $i<count($b2varstoreset); $i += 1) {
	$b2var = $b2varstoreset[$i];
	if (!isset($$b2var)) {
		if (empty($_POST["$b2var"])) {
			if (empty($_GET["$b2var"])) {
				$$b2var = '';
			} else {
				$$b2var = $_GET["$b2var"];
			}
		} else {
			$$b2var = $_POST["$b2var"];
		}
	}
}

require_once('../b2config.php');
require_once($abspath.$b2inc.'/b2functions.php');

switch($action) {

case 'update':
	
	require_once('b2verifauth.php');

	get_currentuserinfo();

	/* checking the nickname has been typed */
	if (empty($_POST["newuser_nickname"])) {
		die ("<strong>ERROR</strong>: please enter your nickname (can be the same as your login)");
		return false;
	}

	/* if the ICQ UIN has been entered, check to see if it has only numbers */
	if (!empty($_POST["newuser_icq"])) {
		if ((ereg("^[0-9]+$",$_POST["newuser_icq"]))==false) {
			die ("<strong>ERROR</strong>: your ICQ UIN can only be a number, no letters allowed");
			return false;
		}
	}

	/* checking e-mail address */
	if (empty($_POST["newuser_email"])) {
		die ("<strong>ERROR</strong>: please type your e-mail address");
		return false;
	} else if (!is_email($_POST["newuser_email"])) {
		die ("<strong>ERROR</strong>: the email address isn't correct");
		return false;
	}

	if ($_POST["pass1"] == "") {
		if ($_POST["pass2"] != "")
			die ("<strong>ERROR</strong>: you typed your new password only once. Go back to type it twice.");
		$updatepassword = "";
	} else {
		if ($_POST["pass2"] == "")
			die ("<strong>ERROR</strong>: you typed your new password only once. Go back to type it twice.");
		if ($_POST["pass1"] != $_POST["pass2"])
			die ("<strong>ERROR</strong>: you typed two different passwords. Go back to correct that.");
		$newuser_pass = $_POST["pass1"];
		$updatepassword = "user_pass='$newuser_pass', ";
		setcookie("wordpresspass",md5($newuser_pass),time()+31536000);
	}

	$newuser_firstname=addslashes($_POST["newuser_firstname"]);
	$newuser_lastname=addslashes($_POST["newuser_lastname"]);
	$newuser_nickname=addslashes($_POST["newuser_nickname"]);
	$newuser_icq=addslashes($_POST["newuser_icq"]);
	$newuser_aim=addslashes($_POST["newuser_aim"]);
	$newuser_msn=addslashes($_POST["newuser_msn"]);
	$newuser_yim=addslashes($_POST["newuser_yim"]);
	$newuser_email=addslashes($_POST["newuser_email"]);
	$newuser_url=addslashes($_POST["newuser_url"]);
	$newuser_idmode=addslashes($_POST["newuser_idmode"]);

	$query = "UPDATE $tableusers SET user_firstname='$newuser_firstname', ".$updatepassword."user_lastname='$newuser_lastname', user_nickname='$newuser_nickname', user_icq='$newuser_icq', user_email='$newuser_email', user_url='$newuser_url', user_aim='$newuser_aim', user_msn='$newuser_msn', user_yim='$newuser_yim', user_idmode='$newuser_idmode' WHERE ID = $user_ID";
	$result = $wpdb->query($query);
	if (!$result) {
		die ("<strong>ERROR</strong>: couldn't update your profile... please contact the <a href=\"mailto:$admin_email\">webmaster</a> !<br /><br />$query<br /><br />".mysqli_error());
	}

	?>
	<html>
	<body onload="window.close();">
		Profile updated!<br />
		If this window doesn't close itself, close it yourself :p
	</body>
	</html>
	<?php

break;

case 'viewprofile':

	require_once('b2verifauth.php');

	$profiledata = get_userdata($user);
	if ($_COOKIE['wordpressuser'] == $profiledata->user_login)
		header ('Location: b2profile.php');
	
	$profile = 1;
	include('b2header.php');
	?>

<h1 id="wphead"><a href="http://wordpress.org" rel="external"><span>WordPress</span></a></h1> 

<h2>View Profile &#8220;
  <?php
	switch($profiledata->user_idmode) {
		case 'nickname':
			$r = $profiledata->user_nickname;
			break;
		case 'login':
			$r = $profiledata->user_login;
			break;
		case 'firstname':
			$r = $profiledata->user_firstname;
			break;
		case 'lastname':
			$r = $profiledata->user_lastname;
			break;
		case 'namefl':
			$r = $profiledata->user_firstname.' '.$profiledata->user_lastname;
			break;
 		case 'namelf':
			$r = $profiledata->user_lastname.' '.$profiledata->user_firstname;
			break;
	}
	echo $r;
	?>
  &#8221;</h2>
	  
  <div id="profile">
<p> 
  <strong>Login</strong> <?php echo $profiledata->user_login ?>
  | <strong>User #</strong> <?php echo $profiledata->ID ?> | <strong>Level</strong> 
  <?php echo $profiledata->user_level ?> | <strong>Posts</strong> 
  <?php
	$posts = get_usernumposts($user);
	echo $posts;
	?>
</p>

<p> <strong>First:</strong> <?php echo $profiledata->user_firstname ?> </p>
  
<p> <strong>Last:</strong> <?php echo $profiledata->user_lastname ?> </p>
  
<p> <strong>Nickname:</strong> <?php echo $profiledata->user_nickname ?> </p>
  
<p> <strong>Email:</strong> <?php echo make_clickable($profiledata->user_email) ?> 
</p>
  
<p> <strong>URL:</strong> <?php echo $profiledata->user_url ?> </p>
  
<p> <strong>ICQ:</strong> 
  <?php if ($profiledata->user_icq > 0) { echo make_clickable("icq:".$profiledata->user_icq); } ?>
</p>
  
<p> <strong>AIM:</strong> <?php echo make_clickable("aim:".$profiledata->user_aim) ?> 
</p>
  
<p> <strong>MSN IM:</strong> <?php echo $profiledata->user_msn ?> </p>
  
<p> <strong>Yahoo IM:</strong> <?php echo $profiledata->user_yim ?> </p>
  
</div>

	<?php

break;


case 'IErightclick':

	$profile = 1;
	include ('b2header.php');

	$bookmarklet_tbpb  = ($use_trackback) ? '&trackback=1' : '';
	$bookmarklet_tbpb .= ($use_pingback)  ? '&pingback=1'  : '';
	$bookmarklet_height= ($use_trackback) ? 340 : 300;

	?>

	<div class="menutop">&nbsp;IE one-click bookmarklet</div>

	<table width="100%" cellpadding="20">
	<tr><td>

	<p>To have a one-click bookmarklet, just copy and paste this<br />into a new text file:</p>
	<?php
	$regedit = "REGEDIT4\r\n[HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\MenuExt\Post To &WP : ".$blogname."]\r\n@=\"javascript:doc=external.menuArguments.document;Q=doc.selection.createRange().text;void(btw=window.open('".$siteurl."/wp-admin/b2bookmarklet.php?text='+escape(Q)+'".$bookmarklet_tbpb."&popupurl='+escape(doc.location.href)+'&popuptitle='+escape(doc.title),'b2bookmarklet','scrollbars=no,width=480,height=".$bookmarklet_height.",left=100,top=150,status=yes'));btw.focus();\"\r\n\"contexts\"=hex:31\"";
	?>
	<pre style="margin: 20px; background-color: #cccccc; border: 1px dashed #333333; padding: 5px; font-size: 12px;"><?php echo $regedit; ?></pre>
	<p>Save it as wordpress.reg, and double-click on this file in an Explorer<br />
	window. Answer Yes to the question, and restart Internet Explorer.<br /><br />
	That's it, you can now right-click in an IE window and select <br />
	'Post to WP' to make the bookmarklet appear. :)</p>

	<p align="center">
		<form>
		<input class="search" type="button" value="1" name="Close this window" />
		</form>
	</p>
	</td></tr>
	</table>
	<?php

break;


default:

	$profile = 1;
	include ('b2header.php');
	$profiledata=get_userdata($user_ID);

	$bookmarklet_tbpb  = ($use_trackback) ? '&trackback=1' : '';
	$bookmarklet_tbpb .= ($use_pingback)  ? '&pingback=1'  : '';
	$bookmarklet_height= ($use_trackback) ? 340 : 300;

	?>
<h1 id="wphead"><a href="http://wordpress.org" rel="external"><span>WordPress</span></a></h1> 
<form name="profile" id="profile" action="b2profile.php" method="post">
	<h2>Edit Your Profile</h2>
  <p>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
  </p>
  <p><strong>User ID:</strong> <?php echo $profiledata->ID ?> | <strong>Level:</strong> 
    <?php echo $profiledata->user_level ?> | <strong>Posts:</strong> 
    <?php
	$posts = get_usernumposts($user_ID);
	echo $posts;
	?>
    | <strong>Login:</strong> <?php echo $profiledata->user_login ?></p>
  <div class="left">
  <p>
    <label for="newuser_firstname">First:</label>
    <input type="text" name="newuser_firstname" id="newuser_firstname" value="<?php echo $profiledata->user_firstname ?>" />
  </p>
  <p>
    <label for="">Last:</label>
    <input type="text" name="newuser_lastname" id="newuser_lastname" value="<?php echo $profiledata->user_lastname ?>" />
  </p>
  <p>
    <label for="newuser_nickname">Nickname:</label> 
    <input type="text" name="newuser_nickname" id="newuser_nickname" value="<?php echo $profiledata->user_nickname ?>" />
  </p>
  <p>
    <label for="newuser_email">Email:</label> 
    <input type="text" name="newuser_email" id="newuser_email" value="<?php echo $profiledata->user_email ?>" />
  </p>
  <p>
    <label for="newuser_url">URL:</label>
    <input type="text" name="newuser_url" id="newuser_url" value="<?php echo $profiledata->user_url ?>" />
  </p>
  <p>
    <label for="newuser_icq">ICQ:</label> 
    <input type="text" name="newuser_icq" id="newuser_icq" value="<?php if ($profiledata->user_icq > 0) { echo $profiledata->user_icq; } ?>" />
  </p>
  <p>
    <label for="newuser_aim">AIM:</label>
    <input type="text" name="newuser_aim" id="newuser_aim" value="<?php echo $profiledata->user_aim ?>" />
  </p>
  <p>
    <label for="newuser_msn">MSN IM:</label>
    <input type="text" name="newuser_msn" id="newuser_msn" value="<?php echo $profiledata->user_msn ?>" />
  </p>
  <p>
    <label for="newuser_yim">Yahoo IM:</label> 
    <input type="text" name="newuser_yim" id="newuser_yim" value="<?php echo $profiledata->user_yim ?>" />
  </p>
  </div>
  <div class="right">
  <p><strong>Identity</strong> on the blog: 
    <select name="newuser_idmode">
      <option value="nickname"<?php
	if ($profiledata->user_idmode == 'nickname')
	echo " selected"; ?>><?php echo $profiledata->user_nickname ?></option>
      <option value="login"<?php
	if ($profiledata->user_idmode=="login")
	echo " selected"; ?>><?php echo $profiledata->user_login ?></option>
      <option value="firstname"<?php
	if ($profiledata->user_idmode=="firstname")
	echo " selected"; ?>><?php echo $profiledata->user_firstname ?></option>
      <option value="lastname"<?php
	if ($profiledata->user_idmode=="lastname")
	echo " selected"; ?>><?php echo $profiledata->user_lastname ?></option>
      <option value="namefl"<?php
	if ($profiledata->user_idmode=="namefl")
	echo " selected"; ?>><?php echo $profiledata->user_firstname." ".$profiledata->user_lastname ?></option>
      <option value="namelf"<?php
	if ($profiledata->user_idmode=="namelf")
	echo " selected"; ?>><?php echo $profiledata->user_lastname." ".$profiledata->user_firstname ?></option>
    </select>
  </p>
  <p> <br />
    New <strong>Password</strong> (Leave blank to stay the same.)<br />
    <input type="password" name="pass1" size="16" value="" />
    <input type="password" name="pass2" size="16" value="" />
  </p>
  <p><strong>Bookmarklet</strong><br />
    add the link to your Favorites/Bookmarks<br />
    <?php
if ($is_NS4 || $is_gecko) {
?>
    <a href="javascript:Q=document.selection?document.selection.createRange().text:document.getSelection();void(window.open('<?php echo $path ?>/wp-admin/b2bookmarklet.php?text='+escape(Q)+'<?php echo $bookmarklet_tbpb ?>&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'b2 bookmarklet','scrollbars=no,width=480,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));">WordPress 
    - <?php echo $blogname ?></a> 
    <?php
} else if ($is_winIE) {
?>
    <a href="javascript:Q='';if(top.frames.length==0)Q=document.selection.createRange().text;void(btw=window.open('<?php echo $path ?>/wp-admin/b2bookmarklet.php?text='+escape(Q)+'<?php echo $bookmarklet_tbpb ?>&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'b2bookmarklet','scrollbars=no,width=480,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));btw.focus();">WordPress 
    - <?php echo $blogname ?></a> 
    <script type="text/javascript" language="JavaScript">
<!--
function oneclickbookmarklet(blah) {
	window.open ("b2profile.php?action=IErightclick", "oneclickbookmarklet", "width=500, height=450, location=0, menubar=0, resizable=0, scrollbars=1, status=1, titlebar=0, toolbar=0, screenX=120, left=120, screenY=120, top=120");
}
// -->
</script>
    <br />
    <br />
    One-click bookmarklet:<br />
    <a href="javascript:oneclickbookmarklet(0);">click here</a> 
    <?php
} else if ($is_opera) {
?>
    <a href="javascript:void(window.open('<?php echo $path ?>/wp-admin/b2bookmarklet.php?popupurl='+escape(location.href)+'&popuptitle='+escape(document.title)+'<?php echo $bookmarklet_tbpb ?>','b2bookmarklet','scrollbars=no,width=480,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));">WordPress 
    - <?php echo $blogname ?></a> 
    <?php
} else if ($is_macIE) {
?>
    <a href="javascript:Q='';if(top.frames.length==0);void(btw=window.open('<?php echo $path ?>/wp-admin/b2bookmarklet.php?text='+escape(document.getSelection())+'&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title)+'<?php echo $bookmarklet_tbpb ?>','b2bookmarklet','scrollbars=no,width=480,height=<?php echo $bookmarklet_height ?>,left=100,top=150,status=yes'));btw.focus();">WordPress 
    - <?php echo $blogname ?></a> 
    <?php
}
?>
    <?php if ($is_gecko) { ?>
    <br />
    <br />
    <script language="JavaScript" type="text/javascript">
function addPanel()
        {
          if ((typeof window.sidebar == "object") && (typeof window.sidebar.addPanel == "function"))
            window.sidebar.addPanel("WordPress Post: <?php echo $blogname ?>","<?php echo $siteurl ?>/wp-admin/b2sidebar.php","");
          else
            alert('No Sidebar found!  You must use Mozilla 0.9.4 or later!');
        }
</script>
    <strong>SideBar</strong><br />
    Add the <a href="#" onclick="addPanel()">WordPress Sidebar</a>! 
    <?php } elseif (($is_winIE) || ($is_macIE)) { ?>
    <br />
    <br />
    <strong>SideBar</strong><br />
    Add this link to your favorites:<br />
    <a href="javascript:Q='';if(top.frames.length==0)Q=document.selection.createRange().text;void(_search=open('<?php echo $siteurl ?>/wp-admin/b2sidebar.php?text='+escape(Q)+'&popupurl='+escape(location.href)+'&popuptitle='+escape(document.title),'_search'))">WordPress 
    Sidebar</a>. 
    <?php } ?>
  </p>
  <p>
    <input class="search" type="submit" value="Update and Close Window" name="submit" /></p>
	</div>
  </form>

	<?php

break;
}

/* </Profile | My Profile> */
include('b2footer.php') ?>