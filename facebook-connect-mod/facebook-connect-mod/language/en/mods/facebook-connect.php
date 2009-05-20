<?php
/**
*
* common [French]
*
* @package language
* @version $Id: common.php 9162 2008-12-03 11:18:31Z acydburn $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” … É À
//

$lang = array_merge($lang, array(
	'LOGIN_EXPLAIN_FACEBOOK' => 'You have to login before linking your account with your facebook account. If you are not registered, you have to register before linking your account.',
	'FACEBOOK_NOT_LINKED' => 'It seems your account on the forum hasn\'nt been linked yet.<br /><a href="facebook_linking.php">I am already registerd on the forum, I want to login.</a><br /><a href="ucp.php?mode=register">I want to register on this board</a>',
	'FACEBOOK_CONFIRM_LINKING' => 'Do you really want to <u>link</u> the board account <b>%1$s</b> with the facebook account <b>%2$s</b> ?',
	'FACEBOOK_CONFIRM_UNLINKING' => 'Do you really want to <u>unlink</u> the board account <b>%1$s</b> with the facebook account <b>%2$s</b> ?',
	'FACEBOOK_ACCOUNT_LINKED' => 'Account successfully linked !',
	'FACEBOOK_ACCOUNT_UNLINKED' => 'Account successfully unlinked !',
	'FACEBOOK_ACCOUNT_ALREADY_LINKED' => 'Your account already linked.',
	'FACEBOOK_LINKING_CONFLICT' => 'An account conflict has happened. Please login again to the forum.',
));

?>
