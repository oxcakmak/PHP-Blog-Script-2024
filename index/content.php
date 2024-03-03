<?php include('index/partial.php');
if(!$slug || $slug != $row['slug']){ header('location:'.$config['url']); }
$tpl['meta'] = '<link rel="stylesheet" href="'.$config['vendorAssets'].'@EnlighterJS/enlighterjs.min.css" />
<title>'.$row['title'].' - OXCAKMAK</title>
<meta name="description" content="'.$row['description'].'">
<meta property="og:description" content="'.$row['description'].'" />
<meta property="og:locale" content="tr_TR" />
<meta property="og:site_name" content="OXCAKMAK" />
<meta property="og:url" content="'.$config['url'].$row['slug'].'" />'.(($contentType=="article")?'<meta property="og:image" content="'.$row['thumbnail'].'" />':'').'
<script type="application/ld+json">
[{
    "@context": "https://schema.org/",
    "@type": "article",
    "name": "'.$row['title'].' - OXCAKMAK",'.(($contentType=="article")?' "image": ["'.$row['thumbnail'].'"],':'').'
    "description": "'.$row['description'].'",
    "brand": {
        "@type": "OXCAKMAK",
        "name": "OXCAKMAK"
    }
}]
</script>
<style>
blockquote{
	display:block;
	background: #fff;
	padding: 10px;
	margin: 0 0 10px;
	position: relative;

	/*Font*/
	font-family: Georgia, serif;
	font-size: 16px;
	line-height: 1.2;
	color: #666;
	text-align: justify;

	/*Borders - (Optional)*/
	border-left: 10px solid #000000;

	/*Box Shadow - (Optional)*/
	-moz-box-shadow: 2px 2px 15px #ccc;
	-webkit-box-shadow: 2px 2px 15px #ccc;
	box-shadow: 2px 2px 15px #ccc;
}

blockquote::after{
	/*Reset to make sure*/
	content: "";
}

blockquote a{
	text-decoration: none;
	background: #eee;
	cursor: pointer;
	padding: 0 3px;
	color: #c76c0c;
}

blockquote a:hover{
	color: #666;
}

blockquote em{
	font-style: italic;
}
blockquote p {
	margin-bottom: 0;
}
</style>';
$tpl['body'] = '<!-- blog-details-area -->
<section class="blog-details-area pt-175 pb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="blog-details-wrap">
                    <div class="bd-content-top text-center" style="margin-bottom: 10px;">
						<!--
                        <div class="blog-meta-two">
                            <ul class="list-wrap">
                                <li class="tag"><a href="#" class="createTime">n/a</a></li>
                                <li><i class="fal fa-clock"></i>5 Min</li>
                            </ul>
                        </div>
						<div class="blog-meta-two">
                            <ul class="list-wrap">
                                <li class="tag"><a href="#" class="modifyTime">n/a</a></li>
                                <li><i class="fal fa-clock"></i>5 Min</li>
                            </ul>
                        </div>
						-->
                        <h2 class="title">'.$row['title'].'</h2>
                        <p style="margin-bottom: 15px;">'.$row['description'].'</p>';
						if($contentType=="article"){ 
                        $tpl['body'] .= '<div class="blog-meta-two bottom">
                            <ul class="list-wrap">
                                <li class="avatar">
                                    <a href="'.$config['url'].'"><!-- <img src="cdn/index/img/blog/blog_avatar01.png" alt=""> -->OXCAKMAK</a>
                                </li>
                                <li class="createTime">'.$row['createTime'].'</li>
                            </ul>
							<div class="breadcrumb-content pt-25 pb-0">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="'.$config['url'].'">'.$l['home'].'</a></li>
										<li class="breadcrumb-item"><a href="'.$config['url'].'blog/">'.$l['blog'].'</a></li>
										<li class="breadcrumb-item active" aria-current="page">'.$row['title'].'</li>
									</ol>
								</nav>
							</div>
                        </div>';
						}
                    $tpl['body'] .= '</div>
                    <hr>
                    <!-- <div class="mb-20"><img src="'.$config['indexAssets'].'img/blog/blog_details_img.jpg" alt=""></div> -->
                    <div class="bd-content" style="word-wrap:break-word;">'.$row['content'].'</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog-details-area-end -->';
$tpl['script'] = '
<script>
$("img").css("width", "auto");
$("img").css("height", "auto");
</script>';
if($contentType=="article"){
    $tpl['script'] .= '<script src="'.$config['vendorAssets'].'@EnlighterJS/enlighterjs.min.js" type="text/javascript"></script>
    <script>
    $("pre code").contents().unwrap();
    EnlighterJS.init("pre", "code", {
        indent : "tab",
        linehover: true,
        /* linenumbers: false, */
        textOverflow: "scroll",
        theme: "droide"
    });
    </script>';
}

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