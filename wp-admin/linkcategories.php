<?php
// $Id: linkcategories.php,v 1.4 2003/06/02 22:20:27 mikelittle Exp $
//
// Links
// Copyright (C) 2002 Mike Little -- mike@zed1.com
//
// This is an add-on to b2 weblog / news publishing tool
// b2 is copyright (c)2001, 2002 by Michel Valdrighi - m@tidakada.com
//
// **********************************************************************
// Copyright (C) 2002 Mike Little
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//
// Mike Little (mike@zed1.com)
// *****************************************************************

include_once('../wp-links/links.config.php');
include_once('../wp-links/links.php');

$title = "Link Categories";

$b2varstoreset = array('action','standalone','cat', 'auto_toggle');
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

switch ($action) {
  case "addcat":
  {
      $standalone = 1;
      include_once("./b2header.php");

      if ($user_level < $minadminlevel)
          die ("Cheatin' uh ?");
    
      $cat_name=addslashes($_POST["cat_name"]);
      $auto_toggle = $_POST["auto_toggle"];
      if ($auto_toggle != 'Y') {
          $auto_toggle = 'N';
      }

      $query="INSERT INTO $tablelinkcategories (cat_id,cat_name, auto_toggle) VALUES ('0', '$cat_name', '$auto_toggle')";
      $result=mysqli_query( $wpdb->dbh,$query) or die("Couldn't add category <b>$cat_name</b>".mysqli_error());
      
      header("Location: linkcategories.php");
    break;
  } // end addcat
  case "Delete":
  {
    $standalone = 1;
    include_once("./b2header.php");

    $cat_id = $_POST["cat_id"];
    $cat_name=get_linkcatname($cat_id);
    $cat_name=addslashes($cat_name);

    if ($cat_id=="1")
        die("Can't delete the <b>$cat_name</b> link category: this is the default one");

    if ($user_level < $minadminlevel)
    die ("Cheatin' uh ?");
    
    $query="DELETE FROM $tablelinkcategories WHERE cat_id=\"$cat_id\"";
    $result=mysqli_query( $wpdb->dbh,$query) or die("Couldn't delete link category <b>$cat_name</b>".mysqli_error());
    
    $query="UPDATE $tablelinks SET link_category=1 WHERE link_category='$cat_id'";
    $result=mysqli_query( $wpdb->dbh,$query) or die("Couldn't reset category on links where category was <b>$cat_name</b>");

    header("Location: linkcategories.php");
    break;
  } // end delete
  case "Edit":
  {
    include_once ("./b2header.php");
    $cat_id = $_POST["cat_id"];
    $cat_name=get_linkcatname($cat_id);
    $cat_name=addslashes($cat_name);
    $auto_toggle=get_autotoggle($cat_id);
?>
<div class="wrap">
  <p><b>Old</b> name: <?php echo $cat_name ?></p>
  <p>
    <form name="editcat" method="post">
      <b>New</b> name:<br />
      <input type="hidden" name="action" value="editedcat" />
      <input type="hidden" name="cat_id" value="<?php echo $_POST["cat_id"] ?>" />
      <input type="text" name="cat_name" value="<?php echo $cat_name ?>" /><br />
      <input type="checkbox" name="auto_toggle" value="Y" <?php echo $auto_toggle == 'Y' ? '"checked"' : ''; ?>/> auto-toggle?<br />
      <input type="submit" name="submit" value="Edit it !" class="search" />
    </form>
  </p>
</div>
<?php
    break;
  } // end Edit
  case "editedcat":
  {
    $standalone = 1;
    include_once("./b2header.php");

    if ($user_level < $minadminlevel)
      die ("Cheatin' uh ?");
    
    $cat_name=addslashes($_POST["cat_name"]);
    $cat_id=$_POST["cat_id"];
    $auto_toggle=$_POST["auto_toggle"];

    $query="UPDATE $tablelinkcategories SET cat_name='$cat_name', auto_toggle='$auto_toggle' WHERE cat_id=$cat_id";
    $result=mysqli_query( $wpdb->dbh,$query) or die("Couldn't edit link category <b>$cat_name</b>: ".$query.mysqli_error());
    
    header("Location: linkcategories.php");
    break;
  } // end edit
  default:
  {
    $standalone=0;
    include_once ("./b2header.php");
    if ($user_level < $minadminlevel) {
      die("You have no right to edit the link categories for this blog.<br>Ask for a promotion to your <a href=\"mailto:$admin_email\">blog admin</a> :)");
    }
?>
<div class="wrap">
    <table width="" cellpadding="5" cellspacing="0" border="0">
      <tr><td><b>Link Categories:</b></td></tr>
      <tr>
        <td>
          <form name="cats" method="post">
            <b>Edit</b> a link category:<br />
<?php
$query = "SELECT cat_id, cat_name, auto_toggle FROM $tablelinkcategories ORDER BY cat_id";
$result = mysqli_query( $wpdb->dbh,$query) or die("Couldn't execute query. ".mysqli_error());
    echo "        <select name=\"cat_id\">\n";
    while($row = mysqli_fetch_object($result)) {
        echo "          <option value=\"".$row->cat_id."\"";
        if ($row->cat_id == $cat_id)
            echo ' selected';
        echo ">".$row->cat_id.": ".$row->cat_name;
        if ($row->auto_toggle == 'Y')
            echo ' (auto toggle)';
        echo "</option>\n";
    }
    echo "        </select>\n";
?>
            <br /><br />
            <input type="submit" name="action" value="Delete" class="search" />
            <input type="submit" name="action" value="Edit" class="search" />
          </form>
        </td>
        <td>
          <?php echo $blankline ?>
        </td>
        <td>
          <b>Add</b> a link category:<br />
          <form name="addcat" method="post">
            <input type="hidden" name="action" value="addcat" />
            <input type="text" name="cat_name" />&nbsp;<input type="checkbox" name="auto_toggle" value="Y" /> auto-toggle?<br /><br />
            <input type="submit" name="submit" value="Add it !" class="search" />
          </form>
        </td>
      </tr>
    </table>

</div>

<div class="wrap">
    <b>Note:</b><br />
    Deleting a link category does not delete links from that category.<br />It will
    just set them back to the default category <b><?php echo get_linkcatname(1) ?></b>.
</div>
<?php
    break;
  } // end default
} // end case
?>
</table>

<?php include('b2footer.php'); ?>
