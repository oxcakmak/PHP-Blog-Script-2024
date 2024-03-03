<?php require_once('config.php');

/* CHECK POST OR GET REQUEST */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = array();
    if(isset($_SESSION['session'])){
        /* UPDATE PASSWORD */
        if($_POST['action']=="updatePassword"){
            $pwLast = $hc->sclr($_POST['pwLast']);
            $pwNew = $hc->sclr($_POST['pwNew']);
            $pwRenew = $hc->sclr($_POST['pwRenew']);
            $passwordHashed = $hc->hsct($pwNew);
            if(!$pwLast || !$pwNew || !$pwRenew){
                $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0);
            }else if($hc->hsct($pwLast)!=$user['password']){
                $hc->ctJsons($l['warning'], $l['not_match_password_last'], 2);
            }else if($pwNew!==$pwRenew){
                $hc->ctJsons($l['warning'], $l['password_not_equal'], 2);
            }else{
                $db->where("username", $user['username']);
                if($db->update("user", ['password' => $passwordHashed])){
                    $hc->ctJsons($l['successful'], $l['password_updated'], 1, '/', 2);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }
        }

        /* UPLOADS */
        if($_POST['action']=="uploads"){
            header('Content-Type: application/json');
            $v = -1;
            $db->orderBy("id", "DESC");
            foreach($db->get("upload") as $row){ $v++;
                $data[]["id"] = $v; /* Add array to number (Ordering) */
                $data[$v]['file'] = '<a href="javascript:void(0);" class="px-3 text-success" onclick="view(\''.$row['link'].'\')"><i class="mdi mdi-image-outline font-size-18"></i></a>';
                $data[$v]['link'] = '<!-- <a href="'.$row['link'].'" target="_blank" class="px-3 text-danger"><i class="mdi mdi-eye-outline font-size-18"></i></a>--><a href="javascript:void(0);" class="px-3 text-brand" onclick="copy(\''.$row['link'].'\')"><i class="mdi mdi-content-copy font-size-18"></i></a>';
                $data[$v]['process'] = '<a class="px-3 text-success" href="'.$row['link'].'" target="_blank"><i class="mdi mdi-eye-outline font-size-18"></i></a><a href="javascript:void(0);" class="px-3 text-danger removeBtn" onclick="remove(\''.$row['id'].'\', \''.$row['location'].'\')"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
            }
            echo json_encode($data);
        }

        /* UPLOAD FILE */
        if($_POST['action']=="upload"){
            if(isset($_FILES['file'])){
                $fileName = $_FILES['file']['name'];
                $fileSize = $_FILES['file']['size'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileType = $_FILES['file']['type'];
                $fileExtensions = ['jpeg', 'jpg', 'png'];
                $fileExtension = @strtolower(end(explode(".", $fileName)));
                $fileNameHash = hash("sha1", basename($fileName)."-".bin2hex(openssl_random_pseudo_bytes(32)));
                $fileNameEncoded = $fileNameHash.".".$fileExtension;
                $uploadDirName = "assets/uploads/".date("Ymd")."/";
                $safePath = $uploadDirName.$fileNameEncoded;
                $fileLink = $config['url'].$safePath;
                if(!in_array($fileExtension, $fileExtensions)){
                    $hc->ctJsons($l['attention'], str_replace("%x", (string)$fileExtensions, $l['upload_file_only_x_have_extensions']), 2);
                }else if($fileSize > (5 * 1000000)){
                    $hc->ctJsons($l['attention'], str_replace("%x", 5, $l['upload_file_less_only_x']), 2);
                }
                if(!file_exists($uploadDirName)){ mkdir($uploadDirName); }
                if(move_uploaded_file($fileTmpName, $safePath)){
                    dbInsertUpload($safePath, $fileLink, $hc->ccflsz($fileSize));
                    $hc->ctJsons($l['successful'], $l['file_uploaded'], 1, '/', 2);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }else{ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }
        }

        /* DELETE FILE */
        if($_POST['action']=="remove"){
            $id = $hc->sclr($_POST['id']);
            $path = $hc->sclr($_POST['path']);
            if(!$id || !$path){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                $db->where("id", $id);
                if($db->delete("upload") && unlink($path)){
                    $hc->ctJsons($l['successful'], $l['file_deleted'], 1, "/", 1);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }
        }

        /* PAGES */
        if($_POST['action']=="pages"){
            header('Content-Type: application/json');
            $v = -1;
            $db->orderBy("id", "DESC");
            foreach($db->get("page") as $row){ $v++;
                $data[]["id"] = $v; /* Add array to number (Ordering) */
                $data[$v]['title'] = $row['title'];
                $data[$v]['nav'] = '<span class="badge rounded-pill bg-'.(($row['nav']=='main')?'primary':'warning').'">'.$l['menu_'.$row['nav']].'</span>';
                $data[$v]['createTime'] = $row['createTime'];
                $data[$v]['modifyTime'] = $row['modifyTime'];
                $data[$v]['process'] = '
                <a href="'.$config['url'].$row['slug'].'" class="px-1 text-primary" target="_blank"><i class="mdi mdi-eye-outline font-size-18"></i></a>
                <a href="'.$config['admin'].'pages/edit/'.$row['id'].'" class="px-1 text-warning"><i class="mdi mdi-pencil-outline font-size-18"></i></a>
                <a href="javascript:void(0);" class="px-1 text-danger removeBtn" onclick="remove(\''.$row['id'].'\', \''.$row['title'].'\')"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
            }
            echo json_encode($data);
        }

        /* ADD PAGE */
        if($_POST['action']=="addPage"){
            $title = $hc->sclr($_POST['title']);
            $slug = $hc->slugs($title);
            $nav = $hc->sclr($_POST['nav']);
            $content = $_POST['content'];
            $description = $hc->sclr($_POST['description']);
            if(!$title || !$nav || !$content || !$description){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                if(dbCheckData("slug", $slug, "page") || dbCheckData("slug", $slug, "article")){ $hc->ctJsons($l['attention'], $l['page_exists'], 2); }else{
                    $data = [
                        'slug' => $slug,
                        'title' => $title,
                        'content' => $content,
                        'description' => $description,
                        'nav' => $nav,
                        'createTime' => $hc->ldtm(),
                        'modifyTime' => $hc->ldtm(),
                    ];
                    if($db->insert("page", $data)){
                        $hc->ctJsons($l['successful'], $l['page_created'], 1, $config['admin']."pages", 2);
                    }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
                }
            }
        }

        /* EDIT PAGE */
        if($_POST['action']=="editPage"){
            $id = $hc->sclr($_POST['id']);
            $title = $hc->sclr($_POST['title']);
            $slug = $hc->slugs($title);
            $nav = $hc->sclr($_POST['nav']);
            $content = $_POST['content'];
            $description = $hc->sclr($_POST['description']);
            if(!$title || !$nav || !$content || !$description){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                if(!dbCheckData("id", $id, "page")){ $hc->ctJsons($l['attention'], $l['page_not_exists'], 2); }else{
                    $data = [
                        'slug' => $slug,
                        'title' => $title,
                        'content' => $content,
                        'description' => $description,
                        'nav' => $nav,
                        'modifyTime' => $hc->ldtm(),
                    ];
                    $db->where("id", $id);
                    if($db->update("page", $data)){
                        $hc->ctJsons($l['successful'], $l['page_updated'], 1, $config['admin']."pages", 2);
                    }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
                }
            }
        }

        /* DELETE PAGE */
        if($_POST['action']=="deletePage"){
            $id = $hc->sclr($_POST['id']);
            if(!dbCheckData("id", $id, "page")){ $hc->ctJsons($l['attention'], $l['page_not_exists'], 0); }else{
                $db->where("id", $id);
                if($db->delete("page")){
                    $hc->ctJsons($l['successful'], $l['page_deleted'], 1, "/", 1);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }
        }

        /* ARTICLES */
        if($_POST['action']=="articles"){
            header('Content-Type: application/json');
            $v = -1;
            $db->orderBy("id", "DESC");
            foreach($db->get("article") as $row){ $v++;
                $data[]["id"] = $v; /* Add array to number (Ordering) */
                $data[$v]['title'] = $row['title'];
                $data[$v]['createTime'] = $row['createTime'];
                $data[$v]['modifyTime'] = $row['modifyTime'];
                $data[$v]['process'] = '
                <a href="'.$config['url'].$row['slug'].'" class="px-1 text-primary" target="_blank"><i class="mdi mdi-eye-outline font-size-18"></i></a>
                <a href="'.$config['admin'].'articles/edit/'.$row['id'].'" class="px-1 text-warning"><i class="mdi mdi-pencil-outline font-size-18"></i></a>
                <a href="javascript:void(0);" class="px-1 text-danger removeBtn" onclick="remove(\''.$row['id'].'\', \''.$row['title'].'\')"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
            }
            echo json_encode($data);
        }

        /* ADD ARTICLE */
        if($_POST['action']=="addArticle"){
            $title = $hc->sclr($_POST['title']);
            $slug = $hc->slugs($title);
            $thumbnail = $hc->sclr($_POST['thumbnail']);
            $content = $_POST['content'];
            $description = $hc->sclr($_POST['description']);
            if(!$title || !$thumbnail || !$content || !$description){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                if(dbCheckData("slug", $slug, "article") || dbCheckData("slug", $slug, "page")){ $hc->ctJsons($l['attention'], $l['article_exists'], 2); }else{
                    $data = [
                        'thumbnail' => $thumbnail,
                        'slug' => $slug,
                        'title' => $title,
                        'content' => $content,
                        'description' => $description,
                        'createTime' => $hc->ldtm(),
                        'modifyTime' => $hc->ldtm(),
                    ];
                    if($db->insert("article", $data)){
                        $hc->ctJsons($l['successful'], $l['article_created'], 1, $config['admin']."articles", 2);
                    }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
                }
            }
        }

        /* EDIT ARTICLE */
        if($_POST['action']=="editArticle"){
            $id = $hc->sclr($_POST['id']);
            $title = $hc->sclr($_POST['title']);
            $slug = $hc->slugs($title);
            $content = $_POST['content'];
            $description = $hc->sclr($_POST['description']);
            if(!$title || !$content || !$description){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                if(!dbCheckData("id", $id, "article")){ $hc->ctJsons($l['attention'], $l['article_not_exists'], 2); }else{
                    $thumbnail = (isset($_POST['thumbnail'])?$hc->sclr($_POST['thumbnail']):dbGetOneVal("id", $id, "article", "thumbnail"));
                    $data = [
                        'thumbnail' => $thumbnail,
                        'slug' => $slug,
                        'title' => $title,
                        'content' => $content,
                        'description' => $description,
                        'modifyTime' => $hc->ldtm(),
                    ];
                    $db->where("id", $id);
                    if($db->update("article", $data)){
                        $hc->ctJsons($l['successful'], $l['article_updated'], 1, $config['admin']."articles", 2);
                    }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
                }
            }
        }

        /* DELETE ARTICLE */
        if($_POST['action']=="deleteArticle"){
            $id = $hc->sclr($_POST['id']);
            if(!dbCheckData("id", $id, "article")){ $hc->ctJsons($l['attention'], $l['article_not_exists'], 0); }else{
                $db->where("id", $id);
                if($db->delete("article")){
                    $hc->ctJsons($l['successful'], $l['article_deleted'], 1, "/", 1);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }
        }
    }else{

        /* LOGIN ACTION */
        if($_POST['action']=="login"){
            $user = $hc->sclr(strtolower($_POST['user']));
            $password = $hc->sclr($_POST['password']);
            $passwordHashed = $hc->hsct($password);
            if(!$user || !$password){
                $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0);
            }else{
                if(!filter_var($user, FILTER_VALIDATE_EMAIL)){
                    $db->where("username", $user);
                }else{
                    $db->where("email", $user);
                }
                $row = $db->getOne("user", ["username", "password"]);
                if(isset($row['username'])){
                    if($passwordHashed==$row['password']){
                        $_SESSION['session'] = true;
                        $_SESSION['username'] = $row['username'];
                        $hc->ctJsons($l['successful'], $l['login_success_redirecting'], 1, $config['panelUrl']."dashboard", 2);
                    }else{ $hc->ctJsons($l['attention'], $l['wrong_username_password'], 2); }
                }else{ $hc->ctJsons($l['warning'], $l['user_not_found'], 2); }
            }
        }

        /* FORGOT ACTION */
        if($_POST['action']=="forgot"){
            $user = $hc->sclr(strtolower($_POST['user']));
            if(!$user){ $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0); }else{
                if(!filter_var($user, FILTER_VALIDATE_EMAIL)){
                    $db->where("username", $user);
                }else{
                    $db->where("email", $user);
                }
                $row = $db->getOne("user", ["username", "password"]);
                if(isset($row['username'])){
                    /* IF Mail Send Success than 
                    if($db->update("user", ['password' => $hc->hsct($hc->gntrds(10))])){
                        $hc->ctJsons($l['successful'], $l['reset_password_link_sent_success'], 1);
                    }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
					*/
					$hc->ctJsons($l['successful'], $l['reset_password_link_sent_success'], 1);
                }else{ $hc->ctJsons($l['warning'], $l['user_not_found'], 2); }
            }
        }

        /* RESET ACTION */
        if($_POST['action']=="reset"){
            $key = $hc->sclr(strtolower($_POST['key']));
            $password = $hc->sclr($_POST['password']);
            $rePassword = $hc->sclr($_POST['rePassword']);
            $passwordHashed = $hc->hsct($password);
            if(!$key || !$password || !$rePassword){
                $hc->ctJsons($l['attention'], $l['empty_area_not_please'], 0);
            }else if(!dbGetOneVal("emailHash", $key, "user", "emailHash")){
                $hc->ctJsons($l['warning'], $l['reset_key_not_found'], 2);
            }else if($passwordHashed==dbGetOneVal("emailHash", $key, "user", "password")){
                $hc->ctJsons($l['warning'], $l['reset_password_not_same'], 2);
            }else if($password!==$rePassword){
                $hc->ctJsons($l['warning'], $l['password_not_equal'], 2);
            }else{
                $user = [
                    'emailHash' => $hc->gntrds(30),
                    'password' => $passwordHashed
                ];
                $db->where("emailHash", $key);
                if($db->update("user", $user)){
                    $hc->ctJsons($l['successful'], $l['reset_password_success'], 1, $config['panelUrl']."reset", 2);
                }else{ $hc->ctJsons($l['attention'], $l['error_an_occured'], 2); }
            }
        }
    }
}
?>