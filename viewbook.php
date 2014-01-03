<?php

include_once('view/common.php');

function getTemplate() {
    return "viewbook.tpl";
}

$defaultVisibleEntryCount = 10;

$bookId = get_param("book");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$book = $bookDao->get($bookId);

$smarty = new Smarty();

if ($book == NULL) {
    showError("Unknown or missing book: " . $bookId, getTemplate());
    return;
}

$entryCount = $entryDao->getEntryCount($book);

if (has_get_param('limitFrom')) {
    $limitFrom = max(0, (int) get_param('limitFrom') - 1);
} else {
    $limitFrom = 0;
}

if (has_get_param('limitTo')) {
    $limitTo = min($entryCount, (int) get_param('limitTo')) - 1;
} else {
    $limitTo = min($entryCount, $limitFrom + $defaultVisibleEntryCount) - 1;
}

if ($limitFrom > $limitTo) {
    $limitFrom = $limitTo;
}

assignTitle("Einträge in " . $book->getName(), $smarty);
assignLinks(array(array('url' => './index.php', 'label' => LABEL_HOME)), $smarty);

$smarty->assign("hasErrors", false);
$smarty->assign("book", $book);
$smarty->assign("entries", $entryDao->getEntries($book, $limitFrom, $limitTo + 1));
$smarty->assign('entryCount', $entryCount);
$smarty->assign('limitFrom', $limitFrom + 1);
$smarty->assign('limitTo', $limitTo + 1);
$smarty->assign('years', $entryDao->getEntryYears($book));
$smarty->assign('visibleEntryCount', $defaultVisibleEntryCount);
$smarty->display(getTemplate());

