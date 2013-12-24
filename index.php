<?php
/*
 * Author: Roland Kluge
 */
include('config/configure.php');

require_once(SMARTY_DIR . 'Smarty.class.php');
include('dao/BookDao.php');

$smarty = new Smarty();

$bookDao = new BookDao();
$books = $bookDao->getAll();

$smarty->assign("title", "Alle Bücher");
$smarty->assign("books", $books);
$smarty->display("index.tpl");

