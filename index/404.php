<?php include('index/partial.php');

$tpl['meta'] = '<title>Freelancer Web Yazılımcısı - OXCAKMAK</title>
<meta name="description" content="Web tasarım ve programlama alanın da uzman php yazılımcısı bir freelancer ile profesyonel web tasarım, profosyonel web yazılım hizmeti arıyorsanız doğru yerdesiniz">';
$tpl['body'] = '<!-- breadcrumb-area -->
<section class="breadcrumb-area breadcrumb-area-three parallax pt-150">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
					<img class="pb-30" src="'.$config['assets'].'default/404.gif" alt="404" style="width:40%;" />
                    <h2 class="title">'.$l['not_found'].'</h2>
					<h3 class="pb-30" style="color:#252541;">'.$l['not_found_description'].'</h3>
                    <a href="'.$config['url'].'" class="btn">'.$l['comeback_home'].' <span></span></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->';
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