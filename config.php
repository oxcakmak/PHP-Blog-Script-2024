<?php
/* DEFAULT */

ob_start();
//ob_start();
session_start();
setlocale(LC_ALL, "tr_TR_.UTF-8", "tr_TR", "tr", "turkish");
date_default_timezone_set("Europe/Istanbul");
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(~0);

/* FIRST */
$config = array();
$config['schema'] = 'http://';
$config['url'] = 'http://localhost/';
$config['admin'] = 'http://localhost/admin/';
$config['ajax'] = 'http://localhost/ajax';
$config['assets'] = 'http://localhost/assets/';
$config['indexUrl'] = 'http://localhost/';
$config['indexAssets'] = 'http://localhost/assets/index/';
$config['panelUrl'] = 'http://localhost/admin/';
$config['panelAssets'] = 'http://localhost/assets/panel/assets/';
$config['vendorAssets'] = 'http://localhost/assets/vendor/';
$slash = '/';


/* TEMPLATE DEFINE */
$tpl = [
    /* Meta Tags (Link, css, title etc.) */
    'meta' => '',
    /* Breadcrumb */
    'body' => '',
    /* Script (Files, code blocks etc.) */
    'script' => ''    
];

/* PARTIAL */
$part = array();

/* AUTOLOAD */
require('core/autoload.php');

/* LANGUAGE */
include('core/language/tr_TR.php');

/* DEFINE USER VAR */
$user = array();
if(isset($_SESSION['session'])){
    $db->where("username", $_SESSION['username']);
    $user = $db->getOne("user");
}

/* SQL SEARCH IMPLODE FUNCTION */
function rawWhereFilterColumn($filter, $search_columns)
{
  $search_terms = explode(' ', $filter);
  $search_condition = "";

  for ($i = 0; $i < count($search_terms); $i++) {
    $term = $search_terms[$i];

    for ($j = 0; $j < count($search_columns); $j++) {
      if ($j == 0) $search_condition .= "(";
      $search_field_name = $search_columns[$j];
      $search_condition .= "$search_field_name LIKE '%" . $term . "%'";
      if ($j + 1 < count($search_columns)) $search_condition .= " OR ";
      if ($j + 1 == count($search_columns)) $search_condition .= ")";
    }
    if ($i + 1 < count($search_terms)) $search_condition .= " AND ";
  }
  return $search_condition;
}
?>