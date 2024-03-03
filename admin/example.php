<?php include('partial.php');
if(empty($_SESSION['session'])){ include("login.php"); exit; }
if(isset($_SESSION['session'])){ include("login.php"); exit; }

$tpl['meta'] = '<title>'.$l['home'].' - OXCAKMAK</title>';
$tpl['body'] = 'DENEME_PAGE';
$tpl['script'] = 'DENEME_PAGE';

$hc->rwc($part["header"]);
$hc->rwc($part["headerMeta"]);
$hc->rwc($tpl['meta']);
$hc->rwc($part["headBody"]);
$hc->rwc('<div id="layout-wrapper">');
$hc->rwc($part["navbar"]);
$hc->rwc('<div class="main-content"><div class="page-content"><div class="container">');
$hc->rwc($tpl['body']);
$hc->rwc('</div></div>');
$hc->rwc($part["footer"]);
$hc->rwc('</div></div>');
$hc->rwc($part["script"]);
$hc->rwc($tpl['script']);
$hc->rwc($part["end"]);
?>