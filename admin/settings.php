<?php include('partial.php');
if(empty($_SESSION['session'])){ include("login.php"); exit; }
$tpl['meta'] = '<title>'.$l['settings'].' - OXCAKMAK</title>';
$tpl['body'] = '
<div class="row align-items-center justify-content-center">
	<div class="col-xl-8">
		<div class="card">
			<div class="card-body">
                <h4 class="card-title mb-3">'.$l['settings'].'</h4>
                <!-- TAB: PASSWORD -->
                <div class="row">
                    <div class="form-floating col-md-4 mb-3">
                        <input type="password" class="form-control pwLast" id="flinpwLast" placeholder="'.$l['password_last'].'">
                        <label for="flinpwLast">'.$l['password_last'].'</label>
                    </div>
                    <div class="form-floating col-md-4 mb-3">
                        <input type="password" class="form-control pwNew" id="flinpwNew" placeholder="'.$l['password_new'].'">
                        <label for="flinpwNew">'.$l['password_new'].'</label>
                    </div>
                    <div class="form-floating col-md-4 mb-3">
                        <input type="password" class="form-control pwRenew" id="flinpwRenew" placeholder="'.$l['password_renew'].'">
                        <label for="flinpwRenew">'.$l['password_renew'].'</label>
                    </div>
                    <div class="col-md-12 text-center d-grid gap-2"><button class="btn btn-success btn-lg gap-2 w-sm waves-effect waves-light updatePasswordBtn">'.$l['update'].'</button></div>
                </div>
			</div>
		</div>
	</div>
</div>
</div></div>';
$tpl['script'] .= '<script>
/* PASSWORD */
$(".updatePasswordBtn").click(function(e){
    e.preventDefault();
    $(".updatePasswordBtn").prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "'.$config['ajax'].'",
        data: {pwLast: $(".pwLast").val(), pwNew: $(".pwNew").val(), pwRenew: $(".pwRenew").val(), action:"updatePassword"},
        dataType: "json",
        success: function(r){
            alert(r.title, r.content, r.type);
            /* If status not 1 then remove button disable status and if status 1 then clear all inputs */
            if(r.type!=1){ $(".updatePasswordBtn").prop("disabled", null); }
            /* If status 1 then clear all inputs */
            if(r.type==1){ $("input").val(""); }
            /* If redirect and interval exists than redirect */
            if(r.interval){
                setInterval(function(){
                    location.reload();
                }, r.interval);
            }
        }
    });
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