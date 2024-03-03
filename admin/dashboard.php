<?php include('partial.php');
if(empty($_SESSION['session'])){ include("login.php"); exit; }
$tpl['meta'] = '<title>'.$l['home'].' - OXCAKMAK</title>';
$tpl['body'] = '
<div class="row align-items-center justify-content-center">
	<div class="col-xl-8">
		<div class="card">
			<div class="card-body">
				<!-- <h4 class="card-title">Social Source</h4> -->
				<div class="text-center">
					<p class="text-muted mt-2 mb-1">'.$l['welcome'].'</p>
					<h5>'.$user['username'].'</h5>
				</div>
				<hr>
				<div class="row">
					<div class="col-4">
						<div class="social-source text-center mt-3">
							<p class="text-muted mb-1">'.$db->getValue("article", "COUNT(*)").'</p>
							<h5 class="font-size-15">'.$l['article'].'</h5>
						</div>
					</div>
					<div class="col-4">
						<div class="social-source text-center mt-3">
							<p class="text-muted mb-1">'.$db->getValue("page", "COUNT(*)").'</p>
							<h5 class="font-size-15">'.$l['page'].'</h5>
						</div>
					</div>
					<div class="col-4">
						<div class="social-source text-center mt-3">
							<p class="text-muted mb-1">'.$db->getValue("upload", "COUNT(*)").'</p>
							<h5 class="font-size-15">'.$l['uploaded_file'].'</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>';
$tpl['script'] = '
<script>
$(document).ready(function(){
	
});
</script>';

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