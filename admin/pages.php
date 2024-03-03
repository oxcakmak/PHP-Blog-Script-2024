<?php include('partial.php');
if(empty($_SESSION['session'])){ include("login.php"); exit; }
if(@$url[2]=='add'){
	$tpl['meta'] = '<title>'.$l['page_add_new'].' - OXCAKMAK</title><style>.ck { height: 400px; }</style>';
    $tpl['body'] = '
    <div class="row align-items-center justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">'.$l['page_add_new'].'&nbsp;<a class="btn btn-danger btn-sm waves-effect waves-light ms-2" href="'.$config['admin'].'pages">'.$l['comeback'].'</a></h4>
                    <div class="row">
                        <div class="form-floating col-md-9 mb-3">
                            <input type="text" class="form-control title" id="flintitle" placeholder="'.$l['title'].'">
                            <label for="flintitle">'.$l['title'].'</label>
                        </div>
                        <div class="form-floating col-md-3 mb-3">                            
                            <select class="form-select nav" id="flinnav">
                                <option value="" selected>'.$l['select'].'</option>
                                <option value="main">'.$l['menu_main'].'</option>
                                <option value="sub">'.$l['menu_sub'].'</option>
                            </select>
                            <label for="flinnav">'.$l['menu'].'</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <input type="text" class="form-control description" id="flindescription" placeholder="'.$l['description'].'">
                            <label for="flindescription">'.$l['description'].'</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <div id="classic-editor"></div>
                        </div>
                        <div class="col-md-12 text-center d-grid gap-2"><button class="btn btn-success btn-lg gap-2 w-sm waves-effect waves-light sendBtn">'.$l['send'].'</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div></div>';
    $tpl['script'] = '<script src="'.$config['panelAssets'].'libs/@ckeditor/ckeditor.js"></script>
    <script>
    var myEditor;
    ClassicEditor
    .create(document.querySelector("#classic-editor"))
    .then( editor => {
        myEditor = editor;
    } )
    .catch(error => {
        console.error(error);
    });
    $(".sendBtn").click(function(e){
        e.preventDefault();
        $(".sendBtn").prop("disabled", true);
        $.ajax({
            type: "POST",
            url: "'.$config['ajax'].'",
            data: {title: $(".title").val(), nav: $(".nav").val(), content: myEditor.getData(), description: $(".description").val(), action:"addPage"},
            dataType: "json",
            success: function(r){
                alert(r.title, r.content, r.type);
                /* If status not 1 then remove button disable status and if status 1 then clear all inputs */
                if(r.type!=1){ $(".sendBtn").prop("disabled", null); }
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
    });
    </script>';
}else if(@$url[2]=='edit'){
    $id = (($url[3])?$url[3]:'');
    $row = dbGetOne("id", $id, "page");
    if(!$row['id']){ header('location:'.$config['admin'].'pages'); }
	$tpl['meta'] = '<title>'.$l['page_edit'].' - OXCAKMAK</title><style>.ck { height: 400px; }</style>';
    $tpl['body'] = '
    <div class="row align-items-center justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">'.$l['page_edit'].'&nbsp;<a class="btn btn-danger btn-sm waves-effect waves-light ms-2" href="'.$config['admin'].'pages">'.$l['comeback'].'</a></h4>
                    <div class="row">
                        <div class="form-floating col-md-9 mb-3">
                            <input type="text" class="form-control title" id="flintitle" placeholder="'.$l['title'].'">
                            <label for="flintitle">'.$l['title'].'</label>
                        </div>
                        <div class="form-floating col-md-3 mb-3">                            
                            <select class="form-select nav" id="flinnav">
                                <option value="" selected>'.$l['select'].'</option>
                                <option value="main">'.$l['menu_main'].'</option>
                                <option value="sub">'.$l['menu_sub'].'</option>
                            </select>
                            <label for="flinnav">'.$l['menu'].'</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <input type="text" class="form-control description" id="flindescription" placeholder="'.$l['description'].'">
                            <label for="flindescription">'.$l['description'].'</label>
                        </div>
                        <div class="form-floating col-md-12 mb-3">
                            <div id="classic-editor">'.$row['content'].'</div>
                        </div>
                        <div class="col-md-12 text-center d-grid gap-2"><button class="btn btn-success btn-lg gap-2 w-sm waves-effect waves-light updateBtn">'.$l['update'].'</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div></div>';
    $tpl['script'] = '<script src="'.$config['panelAssets'].'libs/@ckeditor/ckeditor.js"></script>
    <script>
    
    var myEditor;
    ClassicEditor
    .create(document.querySelector("#classic-editor"))
    .then( editor => {
        myEditor = editor;
    } )
    .catch(error => {
        console.error(error);
    });
    $(".title").val(\''.$row['title'].'\');
    $(".description").val(\''.$row['description'].'\');
    $(".nav").val(\''.$row['nav'].'\');
    $(".updateBtn").click(function(e){
        e.preventDefault();
        $(".updateBtn").prop("disabled", true);
        $.ajax({
            type: "POST",
            url: "'.$config['ajax'].'",
            data: {id: '.$row['id'].', title: $(".title").val(), nav: $(".nav").val(), content: myEditor.getData(), description: $(".description").val(), action:"editPage"},
            dataType: "json",
            success: function(r){
                alert(r.title, r.content, r.type);
                /* If status not 1 then remove button disable status and if status 1 then clear all inputs */
                if(r.type!=1){ $(".updateBtn").prop("disabled", null); }
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
    });
    </script>';
}else{
    $tpl['meta'] = '<link href="'.$config['panelAssets'].'libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$config['panelAssets'].'libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="'.$config['panelAssets'].'libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<title>'.$l['pages'].' - OXCAKMAK</title>';
    $tpl['body'] = '
    <div class="row align-items-center justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">'.$l['pages'].'&nbsp;<a class="btn btn-primary btn-sm waves-effect waves-light ms-2" href="'.$config['admin'].'pages/add">'.$l['page_add_new'].'</a></h4>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>'.$l['title'].'</th>
                                    <th>'.$l['menu'].'</th>
                                    <th>'.$l['creation_date'].'</th>
                                    <th>'.$l['latest_modify'].'</th>
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
            data: {action:"pages"},
            dataSrc: ""
        },
        "stateSave": true,
        columns: [
            {"data": "id"},
            {"data": "title"},
            {"data": "nav"},
            {"data": "createTime"},
            {"data": "modifyTime"},
            {"data": "process"}
        ],
        responsive: true,
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "'.$l['view_all'].'"]]
    });
    function remove(i, p){
        $(".removeBtn").prop("disabled", true);
        Swal.fire({
            title: "'.$l['question_delete_page'].'".replace("_PAGE_", p),
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
                    data: {id: i, action:"deletePage" },
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
    </script>';
}

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