<?php

/*
 * Author: Roland Kluge
 */
include('view_utils/editbook_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    $action = 'new';
    $errorMessage = 'Unknown action or missing action: ' . get_param('action');
}

printf($errorMessage);

$bookDao = new BookDao();

switch ($action) {
    case NEW_ACTION:
        $title = 'Buch anlegen';

        $smarty = new Smarty();
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->display('editbook.tpl');

        break;
    case EDIT_ACTION:
        $id = get_param('id');
        $book = $bookDao->getBook($id);

        $title = $book->getName() . ' bearbeiten';

        $smarty = new Smarty();
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', $book->getName());
        $smarty->assign('description', $book->getDescription());
        $smarty->assign('id', $id);
        $smarty->display('editbook.tpl');

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $name = get_param('name');
        $description = get_param('description');

        $book = new Book();
        $book->setId($id);
        $book->setName($name);
        $book->setDescription($description);

        $bookDao->save($book);

        header('Location: viewbook.php?book=' . $book->getId(), true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('id');
        $bookDao->dropBook($id);
        header('Location: index.php', true, 302);
        break;
}

