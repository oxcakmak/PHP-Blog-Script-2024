<?php include('index/partial.php');
$page = @intval($_GET['p']); if(!$page){ $page = 1; }
$query = @$hc->sclr($_GET['q']);
$url = "";
if($query != NULL || $query != ""){
	$rawSearch = rawWhereFilterColumn($query, array("title", "content", "description"));
	$totalDataCount = $db->rawQuery('SELECT COUNT(*) AS retval FROM article WHERE '.$rawSearch)[0]['retval'];
	$url = $config['url'].'blog?q='.$query.'&';
}else{
	$totalDataCount = $db->getValue("article", "COUNT(*)");
	$url = $config['url'].'blog?';
}
$pageLimit = 12;
$pageNumber = ceil($totalDataCount/$pageLimit);
$viewData = $page * $pageLimit - $pageLimit;
$viewPerPage = 15;
$tpl['meta'] = '<style>.pagination-wrap .page-item .page-link:hover { background: #000; border:1px solid #000; color: #ffffff; }</style><title>Freelancer Web Yazılımcısı - OXCAKMAK</title>
<meta name="description" content="Web tasarım ve programlama alanın da uzman php yazılımcısı bir freelancer ile profesyonel web tasarım, profosyonel web yazılım hizmeti arıyorsanız doğru yerdesiniz">';
$tpl['body'] = '<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-area-three parallax pt-175 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2 class="title">'.$l['blog'].'</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="'.$config['url'].'">'.$l['home'].'</a></li>
                            <li class="breadcrumb-item active" aria-current="page">'.$l['blog'].'</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb-search">
                    <form action="blog" method="GET">
                        <label for="serch"><i class="far fa-search"></i></label>
                        <input type="text" id="serch" placeholder="'.$l['keyword'].'" name="q"'.(($query != NULL || $query != "")?' value="'.$query.'"':'').'>
                        <button type="submit" class="btn">'.$l['search'].'<span></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape-wrap-two">
        <div class="parallax-shape">
            <img src="'.$config['indexAssets'].'img/images/breadcrumb_shape03.png" class="layer" data-depth="0.5" alt="img">
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->

<!-- blog-area -->
<section class="inner-blog-area pb-120">
    <div class="container">';
        if($totalDataCount > 0){
            if($query != NULL || $query != ""){
				$tpl['body'] .= '<div class="row align-items-center justify-content-center"><div class="col-70 testimonial-item-five mb-40"><div class="testimonial-content-five">
                <p>'.str_replace(array("%s", "%c"), array($query, $totalDataCount) , $l['search_x_result_x_found']).'</span></p>
            </div></div></div>
            <div class="clearfix"></div>';
			}
            $tpl['body'] .= '<div class="row">';
            foreach($db->rawQuery('SELECT * FROM article '.(($query != NULL || $query != "")?'WHERE '.@$rawSearch:'').' ORDER BY id DESC LIMIT ?, ?', [$viewData, $pageLimit]) as $article){
                $tpl['body'] .= '<div class="col-lg-4 col-md-6 col-sm-10">
					<div class="blog-item-two">
						<div class="blog-thumb-two">
							<a href="'.$config['url'].$article['slug'].'"><img src="'.$article['thumbnail'].'" alt="'.$article['title'].'"></a>
							<h5 class="date" style="width:93%;padding:10px;font-size:15px;cursor:pointer;" onclick="window.open(\''.$config['url'].$article['slug'].'\', \'_self\')">'.$article['title'].'</h5>
						</div>
						<!-- <div class="blog-content-two"><a href="blog.html" class="tag">How To Create JavaScript Vanilla Gantt Chart: Adding</a><h2 class="title"><a href="blog-details.html">How To Create JavaScript Vanilla Gantt Chart: Adding</a></h2></div> -->
					</div>
				</div>';
            }
        }else{
            $tpl['body'] .= '<div class="row align-items-center justify-content-center"><div class="col-70 testimonial-item-five mb-40"><div class="testimonial-content-five">
            <p>'.(($query != NULL || $query != "")?str_replace(array("%s", "%c"), array($query, $totalDataCount) , $l['search_x_result_x_not_found']).'</span>':'').'</p>
        </div></div></div>';
        }
        $tpl['body'] .= '';
			if($totalDataCount > 0){
                $tpl['body'] .= '<div class="pagination-wrap pt-70 align-items-center justify-content-center text-center"><ul class="pagination list-wrap"><nav aria-label="Page navigation example" style="display: flex;">';
				if($page > 1){ 
                    $tpl['body'] .= '<li class="page-item"><a class="page-link" href="'.$url.'p=1"><i class="fa fa-angle-double-left"></i></a></li>';
                    $tpl['body'] .= '<li class="page-item"><a class="page-link" href="'.$url.'p='.($page - 1).'"><i class="fa fa-angle-left"></i></a></a></li>';
                }
				for($i = $page - $viewPerPage; $i < $page + $viewPerPage +1; $i++){ 
                    if($i > 0 && $i <= $pageNumber){ 
                        if($i == $page){ 
                            $tpl['body'] .= '<li class="page-item active"><a class="page-link pab" href="'.$url.'p='.$i.'" style="background: #000; border:1px solid #000; color: #ffffff;">'.$i.'</a></li>';
                        }else{ 
                            $tpl['body'] .= '<li class="page-item"><a class="page-link" href="'.$url.'p='.$i.'">'.$i.'</a></li>';
                        } 
                    } 
                }
				if($page != $pageNumber){ 
                    $tpl['body'] .= '<li class="page-item"><a class="page-link" href="'.$url.'p='.($page + 1).'"><i class="fa fa-angle-right"></i></a></a></li>';
                    $tpl['body'] .= '<li class="page-item"><a class="page-link" href="'.$url.'p='.$pageNumber.'"><i class="fa fa-angle-double-right"></i></a></li>';
                }
				$tpl['body'] .= '</ul></nav></div>';
			}
        $tpl['body'] .= '</div>
    </div>
</section>
<!-- blog-area-end -->';
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