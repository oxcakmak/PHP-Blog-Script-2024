<?php
if(empty($_SESSION['session'])){ header("location:".$config['admin']."login"); }
session_destroy();
header("location:".$config['admin']."login");
?>