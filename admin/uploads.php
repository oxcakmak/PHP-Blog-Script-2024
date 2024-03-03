<?php include('partial.php');
if(empty($_SESSION['session'])){ include("login.php"); exit; }
$tpl['meta'] = '<link href="'.$config['panelAssets'].'libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="'.$config['panelAssets'].'libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="'.$config['panelAssets'].'libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<title>'.$l['upload_files'].' - OXCAKMAK</title>';
$tpl['body'] = '
<div class="row align-items-center justify-content-center">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-body">
                <h4 class="card-title mb-3">'.$l['upload_files'].'&nbsp;<button class="btn btn-primary btn-sm waves-effect waves-light ms-2" data-bs-toggle="modal" data-bs-target=".modalUpload">'.$l['upload_file'].'</button></h4>
                <div class="modal fade modalUpload" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title modalTitle">'.$l['upload_file'].'</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body"><input type="file" class="form-control mb-1 file"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success waves-effect" data-bs-dismiss="modal">'.$l['cancel'].'</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light uploadBtn">'.$l['send'].'</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>'.$l['file'].'</th>
                                <th>'.$l['file_link'].'</th>
                                <th>'.$l['process'].'</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>
</div></div>';
$tpl['script'] = '
<div class="modal fade modalView" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitle">'.$l['file'].'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"><img class="img-fluid mvi" /></div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-danger waves-effect" data-bs-dismiss="modal">'.$l['close'].'</button></div>
        </div>
    </div>
</div>
<!-- Required datatable js -->
<script src="'.$config['panelAssets'].'libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="'.$config['panelAssets'].'libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
$.fn.dataTable.ext.errMode = "none";

$("#dataTable").DataTable({
    language: {
        info: "'.$l['datatable_info'].'",
        infoEmpty: "'.$l['datatable_info_empty'].'",
        loadingRecords: "'.$l['datatable_loading_records'].'",
        lengthMenu: "'.$l['datatable_length_menu'].'",
        zeroRecords: "'.$l['datatable_zero_records'].'",
        search: "'.$l['datatable_search'].'",
        infoFiltered: "'.$l['datatable_info_filtered'].'",
        paginate: {
            first: "'.$l['datatable_paginate_first'].'",
            previous: "'.$l['datatable_paginate_previous'].'",
            next: "'.$l['datatable_paginate_next'].'",
            last: "'.$l['datatable_paginate_last'].'"
        },
    },
    "ajax": {
        url: "'.$config['ajax'].'",
        type: "POST",
        data: {action:"uploads"},
        dataSrc: ""
    },
    "stateSave": true,
    columns: [
        {"data": "id"},
        {"data": "file"},
        {"data": "link"},
        {"data": "process"}
    ],
    responsive: true,
    "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "'.$l['view_all'].'"]]
});
$(".uploadBtn").click(function(e){
    e.preventDefault();
    var fd = new FormData();
    fd.append("file", $(".file").prop("files")[0]);
    fd.append("action", "upload");
    $(".uploadBtn").prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "'.$config['ajax'].'",
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        dataType: "json",
        success: function(r){
            alert(r.title, r.content, r.type);
            /* If status not 1 then remove button disable status and if status 1 then clear all inputs */
            if(r.type!=1){ $(".uploadBtn").prop("disabled", null); }
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
function remove(i, p){
    $(".removeBtn").prop("disabled", true);
    Swal.fire({
        title: "'.$l['file_delete_question'].'".replace("_ID_", i),
        icon: "question",
        showDenyButton: true,
        showCancelButton: true,
        customClass: {
            confirmButton: "btn btn-success btn-lg waves-effect waves-light",
            cancelButton: "btn btn-danger btn-lg waves-effect waves-light ms-2"
        },
        buttonsStyling: false,
        confirmButtonText: "'.$l['yes_sure'].'",
        cancelButtonText: "'.$l['no'].'",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "'.$config['ajax'].'",
                data: {id: i, path: p, action:"remove" },
                dataType: "json",
                success: function(r){
                    alert(r.title, r.content, r.type);
                    /* If status not 1 then remove button disable status and if status 1 then clear all inputs */
                    if(r.type!=1){ $(".removeBtn").prop("disabled", null); }
                    /* If status 1 then clear all inputs */
                    if(r.type==1){ $(".blitem").val(""); }
                    /* If redirect and interval exists than redirect */
                    if(r.interval){
                        setInterval(function(){
                            location.reload();
                        }, r.interval);
                    }
                }
            });
        }else if(result.isDenied) {
            alert("'.$l['attention'].'", "'.$l['file_delete_canceled'].'", 3);
        }
    });
}
function view(p){
    $(".mvi").attr("src", p);
    $(".mvi").attr("alt", "'.$l['file'].'");
    $(".modalView").modal("show");
}
function fallbackCopyTextToClipboard(text) {
	var textArea = document.createElement("textarea");
	textArea.value = text;

	// Avoid scrolling to bottom
	textArea.style.top = "0";
	textArea.style.left = "0";
	textArea.style.position = "fixed";

	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();

	try {
		var successful = document.execCommand("copy");
		var msg = successful ? "successful" : "unsuccessful";
		console.log("Fallback: Copying text command was " + msg);
	} catch (err) {
		console.error("Fallback: Oops, unable to copy", err);
	}

	document.body.removeChild(textArea);
}

function copy(t) {
	if (!navigator.clipboard) {
		fallbackCopyTextToClipboard(t);
		return;
	}
	navigator.clipboard.writeText(t).then(function() {
		alert("'.$l['successful'].'", "'.$l['file_link_copied'].'", 1);
		console.log("Async: Copying to clipboard was successful!");
	}, function(err) {
		console.error("Async: Could not copy text: ", err);
	});
}
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