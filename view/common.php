<?php

/*
 * Author: Roland Kluge
 */
include('config/configure.php');

include_once('dao/BookDao.php');
include_once('dao/BookEntryDao.php');
include_once('dao/UserDao.php');
require_once(SMARTY_DIR . 'Smarty.class.php');

define("NEW_ACTION", "new");
define("EDIT_ACTION", "edit");
define("SAVE_ACTION", "save");
define("DROP_ACTION", "drop");

function get_param($key) {
    return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
}

function multi_get_param($key) {
    $result = array();

    $query = get_query_string();
    foreach (explode('&', $query) as $pair) {
        $keyValue = explode('=', $pair);
        if ($keyValue[0] === $key) {
            array_push($result, $keyValue[1]);
        }
    }
    return $result;
}

function get_query_string() {
    return filter_var(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : NULL, FILTER_DEFAULT);
}

function has_get_param($key) {
    return filter_has_var(INPUT_GET, $key);
}

function assignTitle($title, Smarty $smarty) {
    $smarty->assign('title', $title);
}

function assignLinks(array $links, Smarty $smarty) {
    $smarty->assign('links', $links);
}

function markNoErrors(Smarty $smarty){
    $smarty->assign('hasErrors', false);
}

function showError($errorMessage, $template) {
    $smarty = new Smarty();
    assignTitle(LABEL_ERROR, $smarty);
    assignLinks(getLinks(), $smarty);
    $smarty->assign('hasErrors', true);
    $smarty->assign('errorMessage', $errorMessage);
    $smarty->display($template);
}
