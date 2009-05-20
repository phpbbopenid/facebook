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
$user->session_begin();
$auth->acl($user->data);
$user->setup('mods/facebook-connect');
$module = new p_master();


// phpBB login
if (!$user->data['is_registered'])
{
	if ($user->data['is_bot'])
	{
		redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	}

	login_box('', $user->lang['LOGIN_EXPLAIN_FACEBOOK']);
}



// At this point, we are connected to both facebook and phpBB

// id facebook et user courant correspondent
// id facebook et user courant ne correspondent pas:
	// id facebook 'trusted' présent mais pour un autre compte (et le facebok id de ce compte est vide  ... ou pas)
	// le compte courant a un facebook id autre que celui annoncé



// The facebook id is in the user row ?
if ($user->data['facebook_id'])
{
	// The facebook id is registered, and owned by the user connected
	if ($user->data['facebook_id'] == $fb_uid)
	{
		meta_refresh(3, append_sid("{$phpbb_root_path}/index.$phpEx"));
		$message = $user->lang['FACEBOOK_ACCOUNT_ALREADY_LINKED'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
		trigger_error($message);
	}
	else // Conflict...
	{

		// Check who own the faceebook id
		/*
		$sql_ary = array(
			'facebook_id' => (int) $fb_uid,
		);
		$sql = 'SELECT facebook_id, user_id FROM ' . USERS_TABLE . ' WHERE ' . $db->sql_build_array('SELECT', $sql_ary);
		$result = $db->sql_query_limit($sql,1);
		$row = $db->sql_fetchrow($result);
		*/

		meta_refresh(3, append_sid("{$phpbb_root_path}/index.$phpEx"));
		$message = $user->lang['FACEBOOK_LINKING_CONFLICT'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');

		// Disconnect !
		$user->session_kill();

		trigger_error($message);
	}
}
else
{
	// Check who own the facebook id
	$sql_ary = array(
		'facebook_id' => (int) $fb_uid,
	);
	$sql = 'SELECT facebook_id, user_id FROM ' . USERS_TABLE . ' WHERE ' . $db->sql_build_array('SELECT', $sql_ary);
	$result = $db->sql_query_limit($sql,1);

	if ($db->sql_affectedrows($result)!=0)
	{
		$db->sql_freeresult($result);
		meta_refresh(3, append_sid("{$phpbb_root_path}/index.$phpEx"));
		$message = $user->lang['FACEBOOK_LINKING_CONFLICT'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');

		// Disconnect !
		$user->session_kill();

		trigger_error($message);
	}
	else
	{
		$db->sql_freeresult($result);
		// Confirm the linking
		if (confirm_box(true))
		{
			$sql_ary = array(
				'facebook_id' => (int) $fb_uid,
			);
			$sql = 'UPDATE  ' . USERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . ' WHERE user_id = ' . $user->data['user_id'];
			$db->sql_query($sql);
			$db->sql_freeresult($result);
			meta_refresh(3, append_sid("{$phpbb_root_path}/facebook/facebook_login.$phpEx"));
			$message = $user->lang['FACEBOOK_ACCOUNT_LINKED'] . '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
			trigger_error($message);
		}
		else
		{
			$user_details=$facebook->api_client->users_getInfo($fb_uid, array('last_name','first_name'));
			$name=$user_details[0]['first_name'] . ' ' . $user_details[0]['last_name'];
			$confirm_text = sprintf($user->lang['FACEBOOK_CONFIRM_LINKING'], $user->data['username'], $name);

			confirm_box(false, $confirm_text, '');
		}

		redirect(append_sid("{$phpbb_root_path}/facebook/facebook_login.$phpEx"));
	}
}
?>
