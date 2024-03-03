<?php require_once("config.php");
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
	<channel>
		<title>Freelancer Web Yazılımcısı - OXCAKMAK</title>
		<link>'.$config['url'].'</link>
		<description>Web tasarım ve programlama alanın da uzman php yazılımcısı bir freelancer ile profesyonel web tasarım, profosyonel web yazılım hizmeti arıyorsanız doğru yerdesiniz.</description>
		<language>tr</language>
		<copyright>OXCAKMAK</copyright>
		<image>
			<url>'.$config['assets'].'favicons/android-icon-192x192.png</url>
			<title>OXCAKMAK</title>
			<link>'.$config['url'].'</link>
		</image>';
$feedArr = array();
$db->orderBy("id", "ASC");
foreach($db->get("article") as $row){ 
	echo '<item>
			<title>'.$row['title'].'</title>
			<link>'.$config['url'].$row['slug'].'</link>
			<category>Bilim ve Teknoloji</category>
			<description>'.$row['description'].'</description>
			<pubDate>'.date("D, d M Y H:i:s \G\M\T", strtotime($row['createTime'])).'</pubDate>
			<enclosure url="'.$row['thumbnail'].'" type="image/jpeg" length="0" />
		</item>
		';
}
echo '</channel>
</rss>';
?>