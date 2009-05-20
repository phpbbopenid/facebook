<?php
/**
* Facebook auth plug-in for phpBB3
*
* @package login
* @license http://opensource.org/licenses/gpl-license.php GNU GPL 3
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
   exit;
}

/**
* Login function
*/
function login_facebook(&$username, &$password)
{

	session_start();

	global $phpbb_root_path, $phpEx;
	require_once($phpbb_root_path . 'common.' . $phpEx);
	require_once($phpbb_root_path . 'includes/facebook/common.' . $phpEx);

	global $db, $config, $user;

	$fb_id  = ((int)$username);

	if (!$fb_id)
	{
		return array(
			'status'	=> LOGIN_ERROR_PASSWORD,
			'error_msg'	=> 'NO_PASSWORD_SUPPLIED',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}

	$sql = 'SELECT user_id, username, user_password, user_passchg, user_pass_convert, user_email, user_type, user_login_attempts
		FROM ' . USERS_TABLE . "
		WHERE facebook_id = '" . $fb_id . "'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!$row)
	{
		return array(
			'status'	=> LOGIN_ERROR_USERNAME,
			'error_msg'	=> 'LOGIN_ERROR_USERNAME',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}


	// User inactive...
	if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE)
	{
		return array(
			'status'		=> LOGIN_ERROR_ACTIVE,
			'error_msg'		=> 'ACTIVE_ERROR',
			'user_row'		=> $row,
		);
	}

	// Successful login... set user_login_attempts to zero...
	return array(
		'status'		=> LOGIN_SUCCESS,
		'error_msg'		=> false,
		'user_row'		=> $row,
	);

}
?>
