<?php
/*
 * Author: Roland Kluge
 */
include_once('view/common.php');

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
$smarty->assign("links", array());
$smarty->display("index.tpl");

