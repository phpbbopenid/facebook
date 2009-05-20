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

require_once($phpbb_root_path . 'includes/facebook/facebook-platform/client/facebook.' . $phpEx);
require_once($phpbb_root_path . 'includes/facebook/config.' . $phpEx);

$config['auth_method'] = "facebook";

$facebook = new Facebook($appapikey, $appsecret);
?>
