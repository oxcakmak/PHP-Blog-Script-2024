<?php include('partial.php');
if(isset($_SESSION['session'])){ header("location:".$config['panelUrl']."dashboard"); }

$tpl['meta'] = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
$tpl['body'] = '
<div class="row align-items-center justify-content-center">
    <div class="col-md-4 col-lg-4 col-xl-3 mt-5">
        <div class="card">
            <div class="card-body p-4"> 
                <div class="text-center mt-2"><h1 class="text-primary">'.$l['signin'].'</h1></div>
                <div class="p-2 mt-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control user" id="flinuser" placeholder="'.$l['username_or_email'].'">
                        <label for="flinuser">'.$l['username_or_email'].'</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control password" id="flinpassword" placeholder="'.$l['password'].'">
                        <label for="flinpassword">'.$l['password'].'</label>
                    </div>
					<div class="text-center d-grid gap-2"><div class="g-recaptcha mb-3" data-sitekey="REPLACE"></div></div>
                    <div class="text-center d-grid gap-2"><button class="btn btn-primary btn-lg w-sm waves-effect waves-light loginBtn">'.$l['signin'].'</button></div>
                    <div class=" text-center"><p class="mt-4"><a href="'.$config['panelUrl'].'forgot" class="fw-medium text-primary">'.$l['forgot_password'].'</a></p></div>
                </div>
            </div>
        </div>
    </div>
</div>';
$tpl['script'] = '<script>
$("body").addClass("authentication-bg");
$(".loginBtn").click(function(e){
    e.preventDefault();
	var rcres = grecaptcha.getResponse();
	if(rcres.length){
		$(".loginBtn").prop("disabled", true);
		$.ajax({
			type: "POST",
			url: "'.$config['ajax'].'",
			data: {user: $(".user").val(), password: $(".password").val(), action:"login"},
			dataType: "json",
			success: function(r){
				alert(r.title, r.content, r.type);
				/* If status not 1 then remove button disable status and if status 1 then clear all inputs */
				if(r.type!=1){ $(".loginBtn").prop("disabled", null); }
				/* If status 1 then clear all inputs */
				if(r.type==1){ $("input").val(""); }
				/* If redirect and interval exists than redirect */
				if(r.location && r.interval){
					setInterval(function(){
						location.href = r.location;
					}, r.interval);
				}
			}
		});
	}else{ alert("'.$l['attention'].'", "'.$l['solve_captcha'].'", 2); }
});
</script>';

$hc->rwc($part["header"]);
$hc->rwc($part["headerMeta"]);
$hc->rwc($tpl['meta']);
$hc->rwc($part["headBody"]);
$hc->rwc('<div id="layout-wrapper"><div class="page-content"><div class="container-fluid">');
$hc->rwc($tpl['body']);
$hc->rwc('</div></div></div>');
$hc->rwc($part["script"]);
$hc->rwc($tpl['script']);
$hc->rwc($part["end"]);
?>