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
include_once($phpbb_root_path . 'includes/functions_module.' . $phpEx);

// MOD includes
require_once($phpbb_root_path . 'includes/facebook/config.' . $phpEx);
require_once($phpbb_root_path . 'includes/facebook/common.' . $phpEx);


// Get the facebook user id
//$fb_uid = $facebook->get_loggedin_user();
$fb_uid = $facebook->require_login();

if (!$fb_uid)
	exit();


// Start session management
// In fact, we don't bother if the user is identified on the forum, we just want to unlink the facebook account...
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/facebook-connect');
$module = new p_master();


// Check if the user is already linked
// Check who own the facebook id
$sql_ary = array(
	'facebook_id' => (int) $fb_uid,
);
$sql = 'SELECT facebook_id, user_id, username FROM ' . USERS_TABLE . ' WHERE ' . $db->sql_build_array('SELECT', $sql_ary);
$result = $db->sql_query_limit($sql,1);
$row = $db->sql_fetchrow($result);

if ($db->sql_affectedrows($result)==0)
{
	$db->sql_freeresult($result);
	trigger_error($user->lang['FACEBOOK_NOT_LINKED']);
}
else
{
	$db->sql_freeresult($result);

	// Confirm the unlinking
	if (confirm_box(true))
	{
		$sql_ary = array(
			'facebook_id' => NULL,
		);
		$sql = 'UPDATE  ' . USERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . ' WHERE facebook_id = ' . ((int) $fb_uid);
		$result = $db->sql_query($sql);
		
		if ($db->sql_affectedrows($result)==0)
		{
			$db->sql_freeresult($result);
			trigger_error($user->lang['FACEBOOK_NOT_LINKED']);
		}
		else
		{
			$db->sql_freeresult($result);
			meta_refresh(3, append_sid("{$phpbb_root_path}facebook_login.$phpEx"));
			$message = $user->lang['FACEBOOK_ACCOUNT_UNLINKED'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
			trigger_error($message);
		}

	}
	else
	{
		$user_details=$facebook->api_client->users_getInfo($fb_uid, array('last_name','first_name'));
		$name=$user_details[0]['first_name'] . ' ' . $user_details[0]['last_name'];
		$confirm_text = sprintf($user->lang['FACEBOOK_CONFIRM_UNLINKING'], $row['username'], $name);

		confirm_box(false, $confirm_text, '');
	}

	redirect(append_sid("{$phpbb_root_path}/facebook/facebook_login.$phpEx"));
}
?>
