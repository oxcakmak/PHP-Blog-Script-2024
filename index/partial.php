<?php 
    function head(){
        global $url, $config;
        echo '<!doctype html><html class="no-js">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/bootstrap.min.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/animate.min.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/fontawesome-all.min.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/swiper-bundle.min.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/odometer.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/slick.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/default.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/style.css">
        <link rel="stylesheet" href="'.$config['indexAssets'].'css/responsive.css">
        <link rel="stylesheet" href="'.$config['vendorAssets'].'material-design-icons-7.9.5/css/materialdesignicons.min.css">
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
        <meta name="theme-color" content="#ffffff">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6113880253435669" crossorigin="anonymous"></script>
		<style>.blog-thumb-two .date { background-color: #000; color: #fff; } </style>';
    }
    function start(){
        echo '<!-- Custom-cursor
        <div class="mouseCursor cursor-outer"></div>
        <div class="mouseCursor cursor-inner"><span>Drag</span></div>
        Custom-cursor-end -->
        <!-- Scroll-top -->
        <button class="scroll-top scroll-to-target" data-target="html"><i class="fas fa-angle-up"></i></button>
        <!-- Scroll-top-end-->';
    }

    

    function menu(){
        global $url, $config, $l, $db;
        echo '<!-- header-area -->
        <header>
            <div id="sticky-header" class="menu-area'.(empty($url[0])?' menu-style-two':'').' transparent-header">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                            <div class="menu-wrap">
                                <nav class="menu-nav">
                                    <div class="logo"><a href="'.$config['url'].'">OXCAKMAK</a></div>
                                    <div class="navbar-wrap main-menu d-none d-lg-flex">
                                        <ul class="navigation">
                                            <li><a href="'.$config['url'].'">'.$l['home'].'</a></li>
                                            <li><a href="'.$config['url'].'blog">'.$l['blog'].'</a></li>';
                                            $db->where("nav", "main")
                                            ->orderBy("title", "ASC");
                                            foreach($db->get("page") as $pages){
                                                if($pages['nav']=='main'){
                                                    echo '<li><a href="'.$config['url'].$pages['slug'].'">'.$pages['title'].'</a></li>';
                                                }
                                                if($pages['nav']=='sub'){
                                                    echo '<li class="menu-item-has-children"><a href="#">'.$l['pages'].'</a><ul class="sub-menu">
                                                            <li><a href="'.$config['url'].$pages['slug'].'">'.$pages['title'].'</a></li>
                                                        </ul></li>';
                                                }
                                            }
                                            if(dbCheckData("nav", "sub", "page")){
                                                echo '<li class="menu-item-has-children"><a href="#">'.$l['pages'].'</a><ul class="sub-menu">';
                                                $db->where("nav", "sub")
                                                ->orderBy("title", "ASC");
                                                foreach($db->get("page") as $pages){
                                                    if($pages['nav']=='sub'){ 
                                                        echo '<li><a href="'.$config['url'].$pages['slug'].'">'.$pages['title'].'</a></li>';
                                                    }
                                                }
                                                echo '</ul></li>';
                                            }
                                            
                                    echo '</ul>
                                    </div>
                                    <!--
                                    <div class="header-action">
                                        <ul class="list-wrap">
                                            <li class="header-btn"><a href="#!" class="btn">Contact <span></span></a></li>
                                        </ul>
                                    </div>
                                    -->
                                </nav>
                            </div>

                            <!-- Mobile Menu  -->
                            <div class="mobile-menu">
                                <nav class="menu-box">
                                    <div class="close-btn"><i class="fas fa-times"></i></div>
                                    <div class="nav-logo"><a href="'.$config['url'].'">OXCAKMAK</a></div>
                                    <div class="menu-outer">
                                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                                    </div>
                                    <!--
                                    <div class="social-links">
                                        <ul class="clearfix list-wrap">
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                    -->
                                </nav>
                            </div>
                            <div class="menu-backdrop"></div>
                            <!-- End Mobile Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-area-end -->';
    }
    function foot(){
        global $url;
        echo '<!-- footer-area -->
        <footer>
            <div class="footer-area-two'.(isset($url[0])?' footer-area-three':'').'">
                <div class="container">
                    <div class="footer-bottom-two">
                        <div class="copyright-text">
                            <p>&copy; '.date("Y").', OXCAKMAK.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-area-end -->';
    }

    function script(){
        global $config;
        echo '<script src="'.$config['indexAssets'].'js/vendor/jquery-3.6.0.min.js"></script>
        <script src="'.$config['indexAssets'].'js/bootstrap.min.js"></script>
        <script src="'.$config['indexAssets'].'js/isotope.pkgd.min.js"></script>
        <script src="'.$config['indexAssets'].'js/imagesloaded.pkgd.min.js"></script>
        <script src="'.$config['indexAssets'].'js/jquery.magnific-popup.min.js"></script>
        <script src="'.$config['indexAssets'].'js/jquery.odometer.min.js"></script>
        <script src="'.$config['indexAssets'].'js/swiper-bundle.min.js"></script>
        <script src="'.$config['indexAssets'].'js/jquery.appear.js"></script>
        <script src="'.$config['indexAssets'].'js/slick.min.js"></script>
        <script src="'.$config['indexAssets'].'js/ajax-form.js"></script>
        <script src="'.$config['indexAssets'].'js/parallax.min.js"></script>
        <script src="'.$config['indexAssets'].'js/jquery.parallaxScroll.min.js"></script>
        <script src="'.$config['indexAssets'].'js/tween-max.js"></script>
        <script src="'.$config['indexAssets'].'js/wow.min.js"></script>
        <script src="'.$config['indexAssets'].'js/main.js"></script>';
    }
    function finish(){
        echo '</body></html>';
    }
?>