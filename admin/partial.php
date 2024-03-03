<?php
$part['header'] = '<!doctype html><html><head>';
$part['headerMeta'] = '<meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="'.$config['panelAssets'].'css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<link href="'.$config['panelAssets'].'css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link href="'.$config['panelAssets'].'css/icons.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="'.$config['vendorAssets'].'material-design-icons-7.9.5/css/materialdesignicons.min.css">
<link rel="stylesheet" href="'.$config['vendorAssets'].'sweetalert2/dist/sweetalert2.css">
<link rel="apple-touch-icon" sizes="57x57" href="'.$config['assets'].'default/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="'.$config['assets'].'default/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="'.$config['assets'].'default/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="'.$config['assets'].'default/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="'.$config['assets'].'default/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="'.$config['assets'].'default/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="'.$config['assets'].'default/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="'.$config['assets'].'default/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="'.$config['assets'].'default/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="'.$config['assets'].'default/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="'.$config['assets'].'default/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="'.$config['assets'].'default/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="'.$config['assets'].'default/favicons/favicon-16x16.png">
<link rel="manifest" href="'.$config['assets'].'default/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="'.$config['assets'].'default/favicons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">';
$part['headBody'] = '</head><body>';
$part['navbar'] = '<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index-2.html" class="logo logo-dark">
                    <span class="logo-sm"><img src="'.$config['panelAssets'].'images/logo-sm.png" alt="" height="22"></span>
                    <span class="logo-lg"><img src="'.$config['panelAssets'].'images/logo-dark.png" alt="" height="20"></span>
                </a>
                <a href="index-2.html" class="logo logo-light">
                    <span class="logo-sm"><img src="'.$config['panelAssets'].'images/logo-sm.png" alt="" height="22"></span>
                    <span class="logo-lg"><img src="'.$config['panelAssets'].'images/logo-light.png" alt="" height="20"></span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn"><i class="fa fa-fw fa-bars"></i></button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="'.$config['assets'].'default/avatar.png" alt="'.@$user['username'].'">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">'.@$user['username'].'</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">View Profile</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-wallet font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">My Wallet</span></a>
                    <a class="dropdown-item d-block" href="#"><i class="uil uil-cog font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Settings</span> <span class="badge bg-soft-success rounded-pill mt-1 ms-2">03</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-lock-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Lock screen</span></a>
                    <a class="dropdown-item" href="#"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index-2.html" class="logo logo-dark">
            <span class="logo-sm"><img src="'.$config['panelAssets'].'images/logo-sm.png" alt="" height="22"></span>
            <span class="logo-lg"><img src="'.$config['panelAssets'].'images/logo-dark.png" alt="" height="20"></span>
        </a>
        <a href="index-2.html" class="logo logo-light">
            <span class="logo-sm"><img src="'.$config['panelAssets'].'images/logo-sm.png" alt="" height="22"></span>
            <span class="logo-lg"><img src="'.$config['panelAssets'].'images/logo-light.png" alt="" height="20"></span>
        </a>
    </div>
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn"><i class="fa fa-fw fa-bars"></i></button>
    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- DASHBOARD -->
                <li class="menu-title">'.$l['menu'].'</li>
                <li><a href="'.$config['panelUrl'].'dashboard" class="waves-effect"><i class="mdi mdi-home"></i><span>'.$l['home'].'</span></a></li>
                <li><a href="'.$config['panelUrl'].'articles" class="waves-effect"><i class="mdi mdi-newspaper-variant-outline"></i><span>'.$l['articles'].'</span></a></li>
                <li><a href="'.$config['panelUrl'].'pages" class="waves-effect"><i class="mdi mdi-file-document-outline"></i><span>'.$l['pages'].'</span></a></li>
                <li><a href="'.$config['panelUrl'].'uploads" class="waves-effect"><i class="mdi mdi-file-upload-outline"></i><span>'.$l['upload_files'].'</span></a></li>
                <li><a href="'.$config['panelUrl'].'settings" class="waves-effect"><i class="mdi mdi-cog"></i><span>'.$l['settings'].'</span></a></li>
                <li><a href="'.$config['panelUrl'].'logout" class="waves-effect"><i class="mdi mdi-logout"></i><span>'.$l['logout'].'</span></a></li>               
                <!--
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-location-point"></i>
                        <span>Maps</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="maps-google.html">Google</a></li>
                        <li><a href="maps-vector.html">Vector</a></li>
                        <li><a href="maps-leaflet.html">Leaflet</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-share-alt"></i>
                        <span>Multi Level</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);">Level 1.1</a></li>
                        <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                -->
            </ul>
        </div>
    </div>
</div>';
$part['footer'] = '<footer class="footer"><div class="container-fluid">&copy; Minible.</div></footer>';
$part['script'] = '<script src="'.$config['panelAssets'].'libs/jquery/jquery.min.js"></script>
<script src="'.$config['panelAssets'].'libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="'.$config['panelAssets'].'libs/metismenu/metisMenu.min.js"></script>
<script src="'.$config['panelAssets'].'libs/simplebar/simplebar.min.js"></script>
<script src="'.$config['panelAssets'].'libs/node-waves/waves.min.js"></script>
<script src="'.$config['panelAssets'].'libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="'.$config['panelAssets'].'libs/moment/moment.js"></script>
<script src="'.$config['panelAssets'].'libs/moment/locale/tr.js"></script>
<script src="'.$config['panelAssets'].'js/app.js"></script>
<script src="'.$config['vendorAssets'].'base64js/base64.js"></script>
<script src="'.$config['vendorAssets'].'sweetalert2/dist/sweetalert2.min.js"></script>
<script>function alert(title, text, type){ 
	swal.fire({
		title: title,
		text: text,
		icon: ((type==0)?"error":((type==1)?"success":((type==2)?"warning":((type==3)?"info":"info")))),
		confirmButtonText: "'.$l['ok'].'"
	});
}</script>';
$part['end'] = '</body></html>';

/*
part("header");
part("headerMeta");
part("headBody");
part("navbar");
part("footer");
part("script");
part("end");
*/
?>