<?php
function myCurl($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode;
}
myCurl("http://www.google.com/webmasters/sitemaps/ping?sitemap=https://oxcakmak.com/sitemap.xml");
myCurl("http://www.bing.com/webmaster/ping.aspx?siteMap=https://oxcakmak.com/sitemap.xml");
echo "Completed at ".date('Y-m-d H:i:s')."\n";
?>