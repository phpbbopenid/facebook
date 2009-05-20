<?php
/**
* Facebook auth plug-in for phpBB3
*
* @package facebook-connect
* @copyright (c) 2008 Mathieu Pellegrin (http://mathedit.dyndns.org)
* @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// phpBB includes
include_once($phpbb_root_path . 'common.' . $phpEx);

// MOD includes
require_once($phpbb_root_path . 'includes/facebook/config.' . $phpEx);
require_once($phpbb_root_path . 'includes/facebook/common.' . $phpEx);


// Get the facebook user id
$fb_uid = $facebook->get_loggedin_user();


if (!$fb_uid)
{
	redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	exit();
}
else
{
	// Make authentication token
	$user->session_begin();
	$auth->login($fb_uid,'');

	// Kill phpBB session
	$user->session_kill();
	
	// Kill facebook session
	// Remove user's Facebook cookies
	$cookies = array('user', 'session_key', 'expires', 'ss');
	foreach ($cookies as $name)
	{
		setcookie($appapikey . '_' . $name);
		unset($_COOKIE[$appapikey . '_' . $name]);
	}
	setcookie($appapikey);
	unset($_COOKIE[$appapikey]);

	redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	exit();
}
?>
