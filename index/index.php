<?php include('partial.php');
$tpl['meta'] = '<style>.navbar-wrap ul li .sub-menu li a:hover { color:#f89e52; }</style>
<title>Freelancer Web Yazılımcısı - OXCAKMAK</title>
<meta name="description" content="Web tasarım ve programlama alanın da uzman php yazılımcısı bir freelancer ile profesyonel web tasarım, profosyonel web yazılım hizmeti arıyorsanız doğru yerdesiniz">';
$tpl['body'] = '<!-- banner-area 
<section class="banner-area-two">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center pt-150 pb-150">
            <div class="col-xl-12 col-lg-12">
                <div class="banner-content-two">
                    <span class="sub-title">MERHABA</span>
                    <h2 class="title">Ben, <span>OXCAKMAK</span></h2>
                    <div class="banner-content-bottom">
                        <a href="contact.html" class="btn">Contact Us <span></span></a>
                        <ul class="list-wrap">
                            <li>
                                <a href="#"><img src="'.$config['indexAssets'].'img/icon/banner_icon01.svg" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="'.$config['indexAssets'].'img/icon/banner_icon02.svg" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="'.$config['indexAssets'].'img/icon/banner_icon03.svg" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="'.$config['indexAssets'].'img/icon/banner_icon04.svg" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-shape-wrap-two">
        <img src="'.$config['indexAssets'].'img/banner/h2_banner_shape01.png" alt="" class="rotateme">
        <img src="'.$config['indexAssets'].'img/banner/h2_banner_shape02.png" alt="" class="ribbonRotate">
        <img src="'.$config['indexAssets'].'img/banner/h2_banner_shape03.png" alt="" class="ribbonRotate">
        <img src="'.$config['indexAssets'].'img/banner/h2_banner_shape04.png" alt="" class="ribbonRotate">
    </div>
</section> -->';
if(@$db->has("article")){
    $tpl['body'] .= '<!-- blog-area -->
    <section class="blog-area-two pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">';
    $db->orderBy('id', "DESC");
    foreach($db->get("article", 15) as $articles){
        $tpl['body'] .= '
        <div class="col-lg-4 col-md-6 col-sm-10">
            <div class="blog-item-two">
                <div class="blog-thumb-two">
                    <a href="'.$config['url'].$articles['slug'].'"><img src="'.$articles['thumbnail'].'" alt="'.$articles['title'].'"></a>
                    <h5 class="date" style="width:93%;padding:10px;font-size:15px;cursor:pointer;" onclick="window.open(\''.$config['url'].$articles['slug'].'\', \'_self\')">'.$articles['title'].'</h5>
                </div>
                <!-- <div class="blog-content-two"><a href="blog.html" class="tag">How To Create JavaScript Vanilla Gantt Chart: Adding</a><h2 class="title"><a href="blog-details.html">How To Create JavaScript Vanilla Gantt Chart: Adding</a></h2></div> -->
            </div>
        </div>';
    }
    $tpl['body'] .= '<div class="clearfix"></div><div class="col-lg-7 col-md-6 col-sm-10 text-center"><a class="btn" href="'.$config['url'].'blog">'.$l['view_all_articles'].' <span></span></a></div></div>
        </div>
    </section>
    <!-- blog-area-end -->';
}
$tpl['script'] = '';

head();
echo $tpl['meta'].'</head><body'.(empty($url[0])?' class="black-background"':'').'>';
start();
menu();
echo '<!-- main-area --><main>'.$tpl['body'].'</main><!-- main-area-end -->';
/* foot(); */
script();
echo $tpl['script'];
finish();
?>