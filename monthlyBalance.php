<?php

include_once('view/common.php');

function getTemplate() {
    return 'monthlyBalance.tpl';
}

function configureLinks(Smarty $smarty, Book $book) {

    $links = array(
        array('url' => './index.php', 'label' => LABEL_HOME),
        array('url' => './viewbook.php?book=' . $book->getId(),
            'label' => LABEL_OVERVIEW_OF . $book->getName()));
    assignLinks($links, $smarty);
}

$bookId = get_param("book");
$month = get_param("month");
$year = get_param("year");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$book = $bookDao->get($bookId);

if ($bookId == NULL) {
    showError("Unknown or missing book id" . $bookId, getTemplate());
}

$smarty = new Smarty();

assignTitle("Monatsstatistik von " .$book->getName() . " $month.$year", $smarty);
configureLinks($smarty, $book);

$smarty->display(getTemplate());
