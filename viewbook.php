<?php

include_once('view/common.php');
include_once('model/time.php');

function getTemplate() {
    return "viewbook.tpl";
}

function getLinks() {
    return array(array('url' => './index.php', 'label' => LABEL_HOME));
}


$defaultVisibleEntryCount = 50;

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

$visibleEntryCount = $defaultVisibleEntryCount;

if (has_get_param('limitFrom')) {
    $firstEntry = max(1, (int) get_param('limitFrom'));
} else {
    $firstEntry = 1;
}

if (has_get_param('limitTo')) {
    $lastEntry = min($entryCount, (int) get_param('limitTo'));
} else {
    $lastEntry = min($entryCount, $firstEntry + $visibleEntryCount - 1);
}

if ($firstEntry > $lastEntry) {
    $firstEntry = $lastEntry;
}

$entries = $entryDao->getEntries($book, $firstEntry, $lastEntry);

$months = TimeUtils::getMonths();

$suggestedMonth = TimeUtils::getPreviousMonthId();
$suggestedYear = TimeUtils::getCurrentYear();

assignTitle("Einträge in " . $book->getName(), $smarty);
assignLinks(getLinks(), $smarty);

$smarty->assign('hasErrors', false);
$smarty->assign('book', $book);
$smarty->assign('entries', $entries);
$smarty->assign('entryCount', $entryCount);
$smarty->assign('limitFrom', $firstEntry);
$smarty->assign('limitTo', $lastEntry);

$smarty->assign('months', $months);
$smarty->assign('suggestedMonth', $suggestedMonth);
$smarty->assign('suggestedYear', $suggestedYear);

$smarty->assign('years', $entryDao->getEntryYears($book));
$smarty->assign('visibleEntryCount', $defaultVisibleEntryCount);
$smarty->display(getTemplate());

