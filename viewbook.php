<?php
include('config/configure.php');

require_once(SMARTY_DIR . 'Smarty.class.php');
include('view_utils/common.php');

include('dao/BookDao.php');

$bookId = get_param("book");

$bookDao = new BookDao();
$book = $bookDao->getBook($bookId);

$smarty = new Smarty();

$smarty->assign("title", "Einträge in " . $book->getName());
$smarty->display("viewbook.tpl");
