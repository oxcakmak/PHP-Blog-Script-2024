<?php
/* Include MysqliDb Class */
include('classes/MysqliDb.php');

/* Define Variable and Database configs */
$db = new MysqliDb([
    'type' => 'mysqli',
	'host' => 'localhost',
	'username' => 'root', 
	'password' => '',
	'db'=> 'blog',
	'charset' => 'utf8'
]);

function dbInsertUpload($path, $link, $size){
    global $db, $hc, $_SESSION;
    if(isset($_SESSION['uac'])){
        $user = $_SESSION['uac'];
    }
    $data = [
        'location' => $path,
        'link' => $link
    ];
    $db->insert("upload", $data);
}

function dbOrderVal($column, $item, $by, $type, $table, $return){
    global $db;
    $db->where($column, $item)
    ->orderBy($by, $type);
    return $db->getValue($table, $return);
}

function dbCount($column, $item, $table){
    global $db;
    $db->where($column, $item);
    return $db->getValue($table, "COUNT(*)");
}
function dbCustomCount($column, $item, $table, $what){
    global $db;
    $db->where($column, $item);
    return $db->getValue($table, "COUNT(".$what.")");
}

function dbConfigVal($what){
    global $db;
    $db->where("name", $what);
    return $db->getValue("setting", "value");
}

function dbConfigOneVal($what){
    global $db;
    $db->where("name", $what);
    return $db->getOne("setting");
}

function dbCheckData($column, $what, $table){
    global $db;
    $db->where($column, $what);
    return $db->has($table);
}

function dbGetOne($column, $what, $table){
    global $db;
    $db->where($column, $what);
    return $db->getOne($table);
}


function dbGetOneVal($column, $what, $table, $which){
    global $db;
    $db->where($column, $what);
    return $db->getValue($table, $which);
}

?>