<?php

/*
 * Author: Roland Kluge
 */
include_once('view_utils/editentry_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    $action = 'new';
    $errorMessage = 'Unknown action or missing action: ' . get_param('action');
}

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $bookId= get_param('bookId');
        $book = $bookDao->get($bookId);
        
        $title = 'Eintrag in ' . $book->getName() . ' anlegen';

        $smarty = new Smarty();

        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);

        $smarty->assign('id', '');
        $smarty->assign('amount', '');
        $smarty->assign('date', date('d.m.Y'));
        $smarty->assign('description', '');
        $smarty->assign('book', $book);
        
        $smarty->assign('user', NULL);
        $smarty->assign('users', $bookDao->getUsers($book));

        $smarty->display('editentry.tpl');

        break;
    case EDIT_ACTION:
        $id = get_param('id');
        $entry = $entryDao->get($id);

        $title = 'Eintrag' . $entry->getId() .
                '(Buch: ' . $entry->getBook()->getName() . 
                ' bearbeiten';

        $smarty = new Smarty();

        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);

        $smarty->assign('id', $entry->getId());
        $smarty->assign('amount', $entry->getAmount());
        $smarty->assign('date', $entry->getDate());
        $smarty->assign('description', $entry->getDescription());
        $smarty->assign('book', $entry->getBook());
        
        $smarty->assign('user', $entry->getUser());
        $smarty->assign('users', $userDao->getAll());

        $smarty->display('editentry.tpl');

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $amount = get_param('amount');
        $date = get_param('date');
        $description = get_param('description');
        $userId = get_param('user');
        $bookId = get_param('book');

        $entry = new BookEntry();
        $entry->setId($id);
        $entry->setAmount($amount);
        $entry->setDate($date);
        $entry->setDescription($description);
        
        $user = $userDao->get($userId);
        $book = $bookDao->get($bookId);
        $entry->setUser($user);
        $entry->setBook($book);

        $entryDao->save($entry);

        header('Location: viewbook.php?id=' . $book->getId(), true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('id');
        $entry = $entryDao->get($id);
        $book = $entry->getBook();
        $entryDao->drop($id);
        header('Location: viewbook.php?id=' . $book->getId(), true, 302);
        break;
}

