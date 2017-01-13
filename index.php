<?php
/*
 * Author: Roland Kluge
 */
include_once('view/common.php');

function sortUsers(array &$users)
{
    usort($users, "compareUsers");
}

function compareUsers(User $userA, User $userB)
{
    if ($userA->isReal() && !$userB->isReal())
    {
        return -1;
    } else {
        return strcmp($userA->getName(), $userB->getName());
    }       
}

$bookDao = new BookDao();
$books = $bookDao->getAll();
$bookToUsers = $bookDao->getBookToUsersMapping($books);

$userDao = new UserDao();
$users = $userDao->getAll();
$userToBooks = $bookDao->getUserToBooksMapping($users);
sortUsers($users);

$smarty = new Smarty();

markNoErrors($smarty);
assignTitle("Übersicht", $smarty);
assignLinks(array(), $smarty);

$smarty->assign("books", $books);
$smarty->assign("bookToUsers", $bookToUsers);
$smarty->assign("userToBooks", $userToBooks);

$smarty->assign("users", $users);

$smarty->display("index.tpl");
