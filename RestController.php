<?php 
require_once("SiteRestHandler.php");

$view = "";

if(isset($_GET['view'])){

	$view = $_GET['view'];
}

/**
 * RESTful service 控制器
 * URL映射
 */

// var_dump($_GET);
// exit;

switch($view){

	case "all":

		// 处理 REST url /site/list
		$siteRestHandler = new siteRestHandler();
		$siteRestHandler->getAllSites();
		break;

	case "single":

		// 处理 REST url /site/show/id/
		$siteRestHandler = new SiteRestHandler();
		$siteRestHandler->getSite($_GET['id']);
		break;

	default:

		break;

}


?>
