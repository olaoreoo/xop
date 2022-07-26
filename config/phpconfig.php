<?php
if ((function_exists('session_status')
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
}
require_once "dbconfig.php";
require_once "class.user.php";
// security access
$user = new USER();
$db = getDB();
//
//echo $forPrevUrl;

try {
    $stmt = $user->runQuery("SELECT * FROM tbl_settings");
    $stmt->execute(array());
    $settingsRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $settings['SiteUrl'] =$settingsRow['siteUrl'];
    //echo json_encode($settings);siteTel
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

//
$baseuri="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$basepage=$_SERVER['REQUEST_URI']; //echo $basepage;
$baseurl="http://".$_SERVER['SERVER_NAME'];
$hr="<hr />"; // horizontal rule
//
date_default_timezone_set('Africa/Lagos');

//$_SESSION['time_zone'] = date_default_timezone_set('Africa/Lagos');
?>
