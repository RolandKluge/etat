<?php
include('view_utils/common.php');

$bookId = get_param("book");

$bookDao = new BookDao();
$book = $bookDao->getBook($bookId);

$smarty = new Smarty();
$smarty->assign("homeLinkLabel", "Zurück zur Übersicht");
if($book)
{
    $smarty->assign("title", "Einträge in " . $book->getName());
}
else {
    $smarty->assign("title", "Unbekanntes Buch!");
}
$smarty->display("viewbook.tpl");
