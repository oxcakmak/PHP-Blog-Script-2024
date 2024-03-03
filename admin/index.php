<?php
require_once('../config.php');
include("partial.php");

/* If Localhost url+1 */
if($url){
	if(empty($url[1])){ include("dashboard.php"); }else{
		$pageFile = @$url[1].".php";
		if(file_exists($pageFile)){
			include($pageFile);
		}else{
			@include("../index/404.php");
		}
	}
}else{ include("dashboard.php"); }
?>