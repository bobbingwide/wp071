<?php
/* *
 * WordPress's config file *
                         * */

// Reminder: everything that starts with #, /* or // is a comment

/* Start editing */

// $siteurl is your blog's URL: for example, 'http://mydomain.com/wordpress' (no trailing slash !)
// $blogfilename is the name of the default file for your blog
// $blogname is the name of your blog

$siteurl = 'http://s.b/wp071'; // Double check this, it's very important.
$blogfilename = 'index.php';
$blogname = "WordPress 0.71-gold for PHP 8";
$blogdescription = "Reworking WordPress for its 20th anniversary on 27th May 2003";

// Your email (obvious eh?)
$admin_email = 'you@example.com';

// ** MySQL settings **

define('DB_NAME', 'b2');		// The name of the database
define('DB_USER', 'b2');		// Your MySQL username
define('DB_PASSWORD', 'b2');	// ...and password
define('DB_HOST', 'localhost');	// 99% chance you won't need to change this value    


// If you've finished up to here you should be able to install now.


// set this to 0 or 1, whether you want new users to be able to post entries once they registered
$new_users_can_blog = 0;


// set this to 0 or 1, whether you want to allow users to register on your blog.
$users_can_register = 1;


// day at the start of the week: 0 for Sunday, 1 for Monday, 2 for Tuesday, etc
$start_of_week = 1;



// database tables' names (change them if you want to have multiple b2's in a single database)
$tableposts = 'b2posts';
$tableusers = 'b2users';
$tablesettings = 'b2settings';
$tablecategories = 'b2categories';
$tablecomments = 'b2comments';
// tables for link manager
$tablelinks = "b2links";
$tablelinkcategories = "b2linkcategories";


// ** Post preview function **

// set this to 1 if you want to use the 'preview' function
$use_preview = 1;



// ** Text formatting options **

// these options can help you format your text without using too much html
$use_bbcode = 0;        // use BBCode, like [b]bold[/b]
$use_gmcode = 0;        // use GreyMatter-styles: **bold** \italic\ __underline__
$use_quicktags = 1;     // buttons for HTML tags (they won't work on IE Mac yet)

// IMPORTANT! set this to 0 if you are using Chinese, Japanese, Korean,
//                                           or other double-bytes languages
$use_htmltrans = 1;

// this could help balance your HTML code. if it gives bad results, set it to 0
$use_balanceTags = 1;


// ** Image upload **


// set this to 0 to disable file upload, or 1 to enable it
$use_fileupload = 1;

// enter the real path of the directory where you'll upload the pictures
//   if you're unsure about what your real path is, please ask your host's support staff
//   note that the  directory must be writable by the webserver (ChMod 766)
//   note for windows-servers users: use forwardslashes instead of backslashes
//$fileupload_realpath = '/home/your/site/b2/images';
$fileupload_realpath = '/home/example/public_html/images';

// enter the URL of that directory (it's used to generate the links to the pictures)
$fileupload_url = 'http://example.com/images';

// accepted file types, you can add to that list if you want
//   note: add a space before and after each file type
//   example: $fileupload_allowedtypes = ' jpg gif png ';
$fileupload_allowedtypes = ' jpg gif png ';

// by default, most servers limit the size of uploads to 2048 KB
//   if you want to set it to a lower value, here it is (you cannot set a higher value)
$fileupload_maxk = '96';

// you may not want all users to upload pictures/files, so you can set a minimum level for this
$fileupload_minlevel = '1';

// ...or you may authorize only some users. enter their logins here, separated by spaces
//   if you leave that variable blank, all users who have the minimum level are authorized to upload
//   note: add a space before and after each login name
//   example: $fileupload_allowedusers = ' barbara anne ';
$fileupload_allowedusers = '';



// ** RSS syndication options **

// these options are used by b2rdf.php (1.0), b2rss.php (0.92), and b2rss2.php (2.0)
//  note: if you don't want to syndicate your news, you can delete these files

// number of last posts to syndicate
$posts_per_rss = 10;

// the language of your blog ( see this: http://backend.userland.com/stories/storyReader$16 )
$rss_language = 'en';

// for b2rss.php: allow encoded HTML in <description> tag? 1=yes, 0=no
$rss_encoded_html = 0;

// length (in words) of excerpts in the RSS feed? 0=unlimited
//  note: in b2rss.php, this will be set to 0 if you use encoded HTML
$rss_excerpt_length = 50;
//use the excerpt field for rss feed.
$rss_use_excerpt = 1;


// ** Weblogs.com ping **

// set this to 1 if you want your site to be listed on http://weblogs.com when you add a new post
$use_weblogsping = 0;


// ** Blo.gs ping **

// set this to 1 if you want your site to be listed on http://blo.gs when you add a new post
$use_blodotgsping = 0;

// You shouldn't need to change this.
$blodotgsping_url = $siteurl;



// ** Trackback / PingBack **

// set this to 0 or 1, whether you want to allow your posts to be trackback'able or not
// note: setting it to zero would also disable sending trackbacks
$use_trackback = 1;

// set this to 0 or 1, whether you want to allow your posts to be pingback'able or not
// note: setting it to zero would also disable sending pingbacks
$use_pingback = 1;



// ** Comments options **

// set this to 1 to require e-mail and name, or 0 to allow comments without e-mail/name
$require_name_email = 0;

// here is a list of the tags that are allowed in the comments.
//  you can add tags to the list, just add them in the string,
//  add only the opening tag: for example, only '<a>' instead of '<a href=""></a>'

$comment_allowed_tags = '<b><i><strong><em><code><blockquote><p><br><strike><a>';

// set this to 1 to let every author be notified about comments on their posts
$comments_notify = 1;



// ** Smilies options **

// set this to 1 to enable smiley conversion in posts
//     (note: this makes smiley conversion in ALL posts)
$use_smilies = 0;

// the directory where your smilies are (no trailing slash)
$smilies_directory = $siteurl . '/b2-img/smilies';

// here's the conversion table, you can modify it if you know what you're doing
$b2smiliestrans = array(
    ':)'        => 'icon_smile.gif',
    ':D'        => 'icon_biggrin.gif',
    ':-D'       => 'icon_biggrin.gif',
    ':grin:'    => 'icon_biggrin.gif',
    ':)'        => 'icon_smile.gif',
    ':-)'       => 'icon_smile.gif',
    ':smile:'   => 'icon_smile.gif',
    ':('        => 'icon_sad.gif',
    ':-('       => 'icon_sad.gif',
    ':sad:'     => 'icon_sad.gif',
    ':o'        => 'icon_surprised.gif',
    ':-o'       => 'icon_surprised.gif',
    ':eek:'     => 'icon_surprised.gif',
    '8O'        => 'icon_eek.gif',
    '8-O'       => 'icon_eek.gif',
    ':shock:'   => 'icon_eek.gif',
    ':?'        => 'icon_confused.gif',
    ':-?'       => 'icon_confused.gif',
    ':???:'     => 'icon_confused.gif',
    '8)'        => 'icon_cool.gif',
    '8-)'       => 'icon_cool.gif',
    ':cool:'    => 'icon_cool.gif',
    ':lol:'     => 'icon_lol.gif',
    ':x'        => 'icon_mad.gif',
    ':-x'       => 'icon_mad.gif',
    ':mad:'     => 'icon_mad.gif',
    ':P'        => 'icon_razz.gif',
    ':-P'       => 'icon_razz.gif',
    ':razz:'    => 'icon_razz.gif',
    ':oops:'    => 'icon_redface.gif',
    ':cry:'     => 'icon_cry.gif',
    ':evil:'    => 'icon_evil.gif',
    ':twisted:' => 'icon_twisted.gif',
    ':roll:'    => 'icon_rolleyes.gif',
    ':wink:'    => 'icon_wink.gif',
    ';)'        => 'icon_wink.gif',
    ';-)'       => 'icon_wink.gif',
    ':!:'       => 'icon_exclaim.gif',
    ':?:'       => 'icon_question.gif',
    ':idea:'    => 'icon_idea.gif',
    ':arrow:'   => 'icon_arrow.gif',
    ':|'        => 'icon_neutral.gif',
    ':-|'       => 'icon_neutral.gif',
    ':neutral:' => 'icon_neutral.gif',
    ':mrgreen:' => 'icon_mrgreen.gif',
);


// the weekdays and the months.. translate them if necessary

$weekday[0]='Sunday';
$weekday[1]='Monday';
$weekday[2]='Tuesday';
$weekday[3]='Wednesday';
$weekday[4]='Thursday';
$weekday[5]='Friday';
$weekday[6]='Saturday';


// the months, translate them if necessary - note: this isn't active everywhere yet
$month['01']='January';
$month['02']='February';
$month['03']='March';
$month['04']='April';
$month['05']='May';
$month['06']='June';
$month['07']='July';
$month['08']='August';
$month['09']='September';
$month['10']='October';
$month['11']='November';
$month['12']='December';



// This is the name of the include directory. No "/" allowed.
$b2inc = 'b2-include';


// ** Querystring Configuration ** (don't change if you don't know what you're doing)

$querystring_start = '?';
$querystring_equal = '=';
$querystring_separator = '&amp;';




// ** Configuration for b2mail.php ** (skip this if you don't intend to blog via email)

// mailserver settings
$mailserver_url = 'mail.example.com';
$mailserver_login = 'login@example.com';
$mailserver_pass = 'password';
$mailserver_port = 110;

// by default posts will have this category
$default_category = 1;

// subject prefix
$subjectprefix = 'blog:';

// body terminator string (starting from this string, everything will be ignored, including this string)
$bodyterminator = "___";

// set this to 1 to run in test mode
$thisisforfunonly = 0;


////// Special Configuration for some phone email services

// some mobile phone email services will send identical subject & content on the same line
// if you use such a service, set $use_phoneemail to 1, and indicate a separator string
// when you compose your message, you'll type your subject then the separator string
// then you type your login:password, then the separator, then content

$use_phoneemail = 0;
$phoneemail_separator = ':::';





/* Stop editing */


$HTTP_HOST = getenv('HTTP_HOST');  /* domain name */
$REMOTE_ADDR = getenv('REMOTE_ADDR'); /* visitor's IP */
$HTTP_USER_AGENT = getenv('HTTP_USER_AGENT'); /* visitor's browser */

$server = DB_HOST;
$loginsql = DB_USER;
$passsql = DB_PASSWORD;
$path = $siteurl;
$base = DB_NAME;


// This should get us the relative path of WordPress and the absolute path on the server. Yipee!
$relpath = '';
$url = explode('/', $siteurl);
for ($i = 3; $i < count($url); $i++) {
	$relpath .= '/'. $url[$i];
}
$abspath =  getenv('DOCUMENT_ROOT') . $relpath . '/';
$b2inc = "/$b2inc";
$pathserver = &$siteurl;
error_reporting(E_ERROR | E_WARNING |E_PARSE);
error_reporting(E_ERROR | E_PARSE);
//error_reporting( E_ALL );

if ( !function_exists('get_magic_quotes_gpc') ) {
	function get_magic_quotes_gpc()
	{
		return false;
	}
}

$debug = 1;
require_once($abspath.$b2inc.'/wp-db.php');
//print_r( $GLOBALS);
?>
