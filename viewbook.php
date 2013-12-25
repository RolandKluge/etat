<?php
include_once('view_utils/viewbook_utils.php');

$bookId = get_param("id");

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$book = $bookDao->get($bookId);

$smarty = new Smarty();
$smarty->assign("homeLinkLabel", "Zurück zur Übersicht");
if($book)
{
    $smarty->assign("title", "Einträge in " . $book->getName());
    $smarty->assign("book", $book);
    $smarty->assign("entries", $entryDao->getEntries($book));
    $smarty->assign('links', array(array('url' => './index.php', 'label' => LABEL_HOME)));
}
else {
    $smarty->assign("title", "Unbekanntes Buch!");
}
$smarty->display("viewbook.tpl");
