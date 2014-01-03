<?php
/*
 * Author: Roland Kluge
 */
include_once('view/common.php');


$bookDao = new BookDao();
$books = $bookDao->getAll();
$bookToUsers = $bookDao->getBookToUsersMapping($books);

$userDao = new UserDao();
$users = $userDao->getAll();

$smarty = new Smarty();

markNoErrors($smarty);
assignTitle("Übersicht", $smarty);
assignLinks(array(), $smarty);

$smarty->assign("books", $books);
$smarty->assign("bookToUsers", $bookToUsers);

$smarty->assign("users", $users);

$smarty->display("index.tpl");

