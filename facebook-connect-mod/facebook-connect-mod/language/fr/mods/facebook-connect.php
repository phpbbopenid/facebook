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
	'LOGIN_EXPLAIN_FACEBOOK' => 'Vous devez vous identifier sur le forum pour associer votre compte du forum avec votre compte facebook. Si vous n\'êtes pas inscrit sur le forum, vous devez vous inscrire.',
	'FACEBOOK_NOT_LINKED' => 'Il semble que votre compte sur le forum ne soit pas encore associé à votre compte facebook.<br /><a href="facebook_linking.php">Je suis déjà inscrit sur le forum, je veux associer mon compte facebook au forum</a><br /><a href="ucp.php?mode=register">Je veux m\'inscrire sur le forum</a>',
	'FACEBOOK_CONFIRM_LINKING' => 'Voulez vous vraiment associer le compte forum <b>%1$s</b> avec le compte facebook <b>%2$s</b> ?',
	'FACEBOOK_CONFIRM_UNLINKING' => 'Voulez vous vraiment défaire l\'association du compte forum <b>%1$s</b> avec le compte facebook <b>%2$s</b> ?',
	'FACEBOOK_ACCOUNT_LINKED' => 'Compte associé  avec succés !',
	'FACEBOOK_ACCOUNT_UNLINKED' => 'Association défaite avec succés !',
	'FACEBOOK_ACCOUNT_ALREADY_LINKED' => 'Votre compte est déjà associé à facebook.',
	'FACEBOOK_LINKING_CONFLICT' => 'Un conflit entre comptes a été détecté, votre compte a été déconnecté, veuillez vous reconnecter au forum.',
));

?>
