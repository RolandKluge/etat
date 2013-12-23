<?php
/*
 * Author: Roland Kluge
 */
include('config/configure.php');

include('dao/BookDao.php');
require_once(SMARTY_DIR . 'Smarty.class.php');

$smarty = new Smarty();

$bookDao = new BookDao();
$books = $bookDao->getAll();

$smarty->assign("title", "Alle Bücher");
$smarty->assign("books", $books);
$smarty->display("index.tpl");

