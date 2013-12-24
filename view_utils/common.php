<?php
/*
 * Author: Roland Kluge
 */
include('config/configure.php');

include_once('dao/BookDao.php');
require_once(SMARTY_DIR . 'Smarty.class.php');

function get_param($key) {
    return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
}

function has_get_param($key) {
    return get_param($key) != NULL;
}
