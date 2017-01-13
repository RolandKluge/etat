<?php

include_once('view/common.php');
include_once('model/time.php');

function getTemplate() {
    return 'yearlyBalance.tpl';
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
$yearStr = get_param("year");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$userDao = new UserDao();
$book = $bookDao->get($bookId);

if ($book == NULL) {
    showError("Unknown or missing book id" . $bookId, getTemplate());
    return;
}

if (!preg_match('/^\d\d\d\d$/', $yearStr)) {
    showError("Invalid year: " . $yearStr, getTemplate());
    return;
}

$year = (int) $yearStr;

$entries = $entryDao->getEntriesByYear($book, $year);
$amountSum = BookEntry::getAmountSum($entries);
$users = $bookDao->getUsers($book);
$userToAmount = $entryDao->getUserToExpensesByYear($book, $year);
$defaultUser = $bookDao->getDefaultUser($book);
$defaultUserExpenses = $defaultUser != null ? $userToAmount[$defaultUser->getId()] : 0;
$userCountWithoutDefaultUser = count($users) - ($defaultUser != null ? 1 : 0);

$averageExpensesPerRealUser = ($amountSum - $defaultUserExpenses) / $userCountWithoutDefaultUser;

$smarty = new Smarty();

assignTitle("Jahresstatistik von " . $book->getName() . " für $year", $smarty);

configureLinks($smarty, $book);
$smarty->assign('hasErrors', false);
$smarty->assign('book', $book);
$smarty->assign('year', $year);
$smarty->assign('entryCount', count($entries));
$smarty->assign('entries', $entries);
$smarty->assign('amountSum', $amountSum);
$smarty->assign('averageExpensesPerRealUser', $averageExpensesPerRealUser);
$smarty->assign('users', $users);
$smarty->assign('userToExpenses', $userToAmount);

$smarty->display(getTemplate());
