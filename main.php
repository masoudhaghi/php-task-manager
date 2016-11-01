<?php
/**
 * PHPTaskManager
 * PHP Version 5
 * @package PHPTaskManager
 * @link https://github.com/masoudhaghi/PHPTaskManager/ The PHP Task Manager GitHub project
 * @author Masoud Haghi (masoudhaghi) <info@masoudhaghi.com>
 * @copyright 2016 Masoud Haghi (@masoudhaghi)
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
 
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}

// turn on error reporting
error_reporting(E_ALL ^ E_NOTICE);

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 

// start the session
session_start();

// connect to database
$server = "localhost";
$user = "root";
$password = "";
$dbname = "taskmanager";
$db_connect_id = @mysql_connect($server, $user, $password);
mysql_set_charset('utf8', $db_connect_id);

if ($db_connect_id && $dbname != '')
{
    if (@mysql_select_db($dbname))
    {
        $connect_id = $db_connect_id;
    }
}

// page management
$page = array();
$page['current'] = isset($_GET['pagenum']) && $_GET['pagenum'] != "" && is_numeric($_GET['pagenum']) ? $_GET['pagenum'] : 1;
$page['next'] = $page['current'] + 1;
$page['previous'] = $page['current'] - 1;
$page['limit'] = 20;
$page['start'] = ($page['current'] - 1) * $page['limit'];

// functions
function redirect($url) {
    $type = preg_match('/IIS|Microsoft|WebSTAR|Xitami/', $_SERVER['SERVER_SOFTWARE']) ? 'Refresh: 0; URL=' : 'Location: ';
	$url = str_replace('&amp;', "&", $url);
    header($type . $url);
    exit;
}
function getStatus($status = 0) {
    switch ($status) {
        case 0:
            return "IN PROGRESS";
            break;
        case 1:
            return "DONE";
            break;
        case 2:
            return "COMPLETE";
            break;
    }
}
function message($type, $message) {
	$html = "";

	switch ($type) {
		default:
		case "info":
		$html .= "<div class=\"alert alert-info\"><strong>Info!</strong> {$message}</div>";
		break;
		
		case "error":
		$html .= "<div class=\"alert alert-danger\"><strong>Error!</strong> {$message}</div>";
		break;
		
		case "warning":
		$html .= "<div class=\"alert alert-warning\"><strong>Warning!</strong> {$message}</div>";
		break;
		
		case "success":
		$html .= "<div class=\"alert alert-success\"><strong>Done!</strong> {$message}</div>";
		break;
	}
	
	echo $html;
}
?>