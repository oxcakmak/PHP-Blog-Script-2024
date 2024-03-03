<?php
require_once('config.php');
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>'.$config["url"].'</loc><lastmod>'.date("Y-m-d\TH:i:s+03:00").'</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url><url><loc>'.$config["url"].'blog</loc><lastmod>'.date("Y-m-d\TH:i:s+03:00").'</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>';
$db->orderBy("id", "ASC");
foreach($db->get("article") as $article){ echo '<url><loc>'.$config["url"].$article['slug'].'</loc><lastmod>'.date("Y-m-d\TH:i:s+03:00", strtotime($article['modifyTime'])).'</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>'; }
$db->orderBy("id", "ASC");
foreach($db->get("page") as $page){ echo '<url><loc>'.$config["url"].$page['slug'].'</loc><lastmod>'.date("Y-m-d\TH:i:s+03:00", strtotime($page['modifyTime'])).'</lastmod><changefreq>weekly</changefreq><priority>0.5</priority></url>'; }
echo '</urlset>';
?>