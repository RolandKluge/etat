<?php

include_once('view_utils/viewbook_utils.php');

$defaultVisibleEntryCount = 10;

$bookId = get_param("id");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$book = $bookDao->get($bookId);

$smarty = new Smarty();
$smarty->assign("homeLinkLabel", "Zurück zur Übersicht");

if ($book) {
    $entryCount = $entryDao->getEntryCount($book);
    
    if (has_get_param('limitFrom')) {
        $limitFrom = (int) get_param('limitFrom') - 1;
    } else {
        $limitFrom = 0;
    }

    if (has_get_param('limitTo')) {
        $limitTo = (int) get_param('limitTo') - 1;
    } else {
        $limitTo = min($entryCount, $limitFrom + $defaultVisibleEntryCount) - 1;
    }
    
    if ($limitFrom > $limitTo)
    {
        $limitFrom = $limitTo;
    }
    
    $smarty->assign("title", "Einträge in " . $book->getName());
    $smarty->assign("book", $book);
    $smarty->assign("entries", $entryDao->getEntries($book, $limitFrom, $limitTo + 1));
    $smarty->assign('entryCount', $entryCount);
    $smarty->assign('limitFrom', $limitFrom + 1);
    $smarty->assign('limitTo', $limitTo + 1);
    $smarty->assign('visibleEntryCount', $defaultVisibleEntryCount);
    $smarty->assign('links', array(array('url' => './index.php', 'label' => LABEL_HOME)));
} else {
    $smarty->assign("title", "Unbekanntes Buch!");
}
$smarty->display("viewbook.tpl");
