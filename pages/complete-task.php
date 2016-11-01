<?php
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}

$id = isset($_GET['id']) && $_GET['id'] != null && is_numeric($_GET['id']) ? $_GET['id'] : null;
if ($id == null) redirect("index.php");
if (mysql_query("UPDATE `tasks` SET `status`='1' WHERE `id`='{$id}'")) {
    redirect("index.php");
} else {
    message("error", "Unable to mark this task as complete. Please try again.");
}
?>