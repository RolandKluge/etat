<?php

include_once('view/common.php');

function getTemplate() {
    return 'monthlyBalance.tpl';
}

function getLinks() {
    //TODO rkluge: hack
    return array(
        array('url' => './index.php', 'label' => LABEL_HOME)
    );
}

function configureLinks(Smarty $smarty, Book $book) {

    assignLinks(array(
        array('url' => './index.php', 'label' => LABEL_HOME),
        array('url' => './viewbook.php?book=' . $book->getId(),
            'label' => LABEL_OVERVIEW_OF . $book->getName())
            ), $smarty);
}

$bookId = get_param("book");
$month = get_param("month");
$year = get_param("year");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$userDao = new UserDao();
$book = $bookDao->get($bookId);

if ($book == NULL) {
    showError("Unknown or missing book id" . $bookId, getTemplate());
    return;
}

if (!preg_match('/^\d?\d$/', $month) || (int) $month < 1 || (int) $month > 12) {
    showError("Invalid month: " . $month, getTemplate());
    return;
}

if (!preg_match('/^\d\d\d\d$/', $year)) {
    showError("Invalid year: " . $year, getTemplate());
    return;
}

$month = (int) $month;
$year = (int) $year;

# TODO rkluge: validate month and year

$entries = $entryDao->getEntriesByMonth($book, $month, $year);
$amountSum = BookEntry::getAmountSum($entries);
$users = $bookDao->getUsers($book);
$userToAmount = $entryDao->getUserToExpensesByMonth($book, $month, $year);
$defaultUser = $bookDao->getDefaultUser($book);

$averageExpensesPerRealUser = ($amountSum - $userToAmount[$defaultUser->getId()]) / (count($users) - 1);

$smarty = new Smarty();

assignTitle("Monatsstatistik von " . $book->getName() . sprintf(" %02d.%2d", $month, $year)
        , $smarty);

configureLinks($smarty, $book);
$smarty->assign('hasErrors', false);
$smarty->assign('book', $book);
$smarty->assign('entryCount', count($entries));
$smarty->assign('amountSum', $amountSum);
$smarty->assign('averageExpensesPerRealUser', $averageExpensesPerRealUser);
$smarty->assign('users', $users);
$smarty->assign('userToExpenses', $userToAmount);

$smarty->display(getTemplate());
