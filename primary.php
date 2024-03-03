<?php
require_once('config.php');

/* If Localhost url+1 */
if($url){
    $contentType = "";
	$slug = $url[0];
	$row = "";
	$pageFile = "";
	if($slug == "blog"){
		$pageFile = "index/blog.php";
	}else if(dbCheckData("slug", $slug, "article")){
		$contentType = "article";
		$row = dbGetOne("slug", $slug, "article");
		$pageFile = "index/content.php";
	}else if(dbCheckData("slug", $slug, "page")){
		$contentType = "page";
		$row = dbGetOne("slug", $slug, "page");
		$pageFile = "index/content.php";
	}else if(!dbCheckData("slug", $slug, "article") || !dbCheckData("slug", $slug, "page")){
        include("index/404.php"); exit;
    }else{
		$pageFile = "index/".$slug.".php";
	}
    if(file_exists($pageFile)){
        include($pageFile);
    }else{
        include("index/404.php"); exit;
    }
}else{ include("index/index.php"); }
?>