<?php
/*
 * Author: Roland Kluge
 */
include_once('config/configure.php');

require_once(SMARTY_DIR . 'Smarty.class.php');
include_once('dao/BookDao.php');
include_once('dao/UserDao.php');

$smarty = new Smarty();

$bookDao = new BookDao();
$books = $bookDao->getAll();
$bookToUsers = $bookDao->getBookToUsersMapping($books);

$userDao = new UserDao();
$users = $userDao->getAll();


$smarty->assign("title", "Übersicht");
$smarty->assign("books", $books);
$smarty->assign("bookToUsers", $bookToUsers);
$smarty->assign("users", $users);
$smarty->display("index.tpl");

