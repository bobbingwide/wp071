<?php
$title = "Template(s) &amp; file editing";
/* <Template> */

if ( !function_exists('get_magic_quotes_gpc') ) {
    function get_magic_quotes_gpc()
    {
        return false;
    }
}

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

if (!get_magic_quotes_gpc()) {
	$_GET    = add_magic_quotes($_GET);
	$_POST   = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$b2varstoreset = array('action','standalone','redirect','profile','error','warning','a','file');
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

switch($action) {

case 'update':

	$standalone = 1;
	require("b2header.php");

	if ($user_level < 3) {
		die('<p>You have no right to edit the template for this blog.<br />Ask for a promotion to your <a href="mailto:$admin_email">blog admin</a>. :)</p>');
	}

	$newcontent = stripslashes($_POST["newcontent"]);
	$file = $_POST["file"];
	$f = fopen($file, 'w+');
	fwrite($f, $newcontent);
	fclose($f);

	$file = str_replace('../', '', $file);
	header("Location: b2template.php?file=$file&a=te");
	exit();

break;

default:

	require('b2header.php');

	if ($user_level <= 3) {
		die('<p>You have no right to edit the template for this blog.<br>Ask for a promotion to your <a href="mailto:$admin_email">blog admin</a>. :)</p>');
	}

	if ('' == $file) {
		if ('' != $blogfilename) {
			$file = $blogfilename;
		} else {
			$file = 'index.php';
		}
	}
	
	if ('..' == substr($file,0,2))
		die ('Sorry, can&#8217;t edit files with ".." in the name. If you are trying to edit a file in your WordPress home directory, you can just type the name of the file in.');
	
	if (':' == substr($file,1,1))
		die ('Sorry, can&#8217;t call files with their real path.');

	if ('/' == substr($file,0,1))
		$file = '.' . $file;
	
	$file = stripslashes($file);
	$file = '../' . $file;
	
	if (!is_file($file))
		$error = 1;

	if ((substr($file,0,2) == 'b2') and (substr($file,-4,4) == '.php') and ($file != 'b2.php'))
		$warning = ' &#8212; this is a WordPress file, be careful when editing it!';
	
	if (!$error) {
		$f = fopen($file, 'r');
		$content = fread($f, filesize($file));
		$content = htmlspecialchars($content);
//		$content = str_replace("</textarea","&lt;/textarea",$content);
	}

	?>
<div class="wrap">
	<?php
	echo "Listing <strong>$file</strong> $warning";
	if ('te' == $a)
		echo "<em>File edited successfully.</em>";
	
	if (!$error) {
	?>
		<form name="template" action="b2template.php" method="post">
		<textarea cols="80" rows="20" style="width:100%" name="newcontent" tabindex="1"><?php echo $content ?></textarea>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="file" value="<?php echo $file ?>" />
		<br />
		<?php
		if (is_writeable($file)) {
			echo "<input type=\"submit\" name=\"submit\" class=\"search\" value=\"update template !\" tabindex=\"2\" />";
		} else {
			echo "<input type=\"button\" name=\"oops\" class=\"search\" value=\"(you cannot update that file/template: must make it writable, e.g. CHMOD 766)\" tabindex=\"2\" />";
		}
		?>
		</form>
	<?php
	} else {
		echo '<p>Oops, no such file exists! Double check the name and try again, merci.</p>';
	}
	?>
</div>

<div class="wrap"> 
  <p>You can also edit the <a href="b2template.php?file=b2comments.php">comments 
    template</a> or the <a href="b2template.php?file=b2commentspopup.php">popup 
    comments template</a>, or edit any other file (provided it&#8217;s writable by 
    the server, e.g. CHMOD 766).</p>
    <p>To edit a file, type its name here:</p>
  <form name="file" action="b2template.php" method="get">
	<input type="text" name="file" />
	<input type="submit" name="submit"  class="search" value="go" />
	</form>
	
  <p>Note: of course, you can also edit the files/templates in your text editor 
    and upload them. This online editor is only meant to be used when you don't 
    have access to a text editor.</p>
</div>
	

	<?php

break;
}

/* </Template> */
include("b2footer.php") ?>