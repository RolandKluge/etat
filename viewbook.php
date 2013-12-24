<?php
include_once('view_utils/viewbook_utils.php');

$bookId = get_param("book");

$bookDao = new BookDao();
$user = $bookDao->get($bookId);

$smarty = new Smarty();
$smarty->assign("homeLinkLabel", "Zurück zur Übersicht");
if($user)
{
    $smarty->assign("title", "Einträge in " . $user->getName());
}
else {
    $smarty->assign("title", "Unbekanntes Buch!");
}
$smarty->display("viewbook.tpl");
