<?php
/*
 * Author: Roland Kluge
 */
include_once('view_utils/editbook_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    $action = 'new';
    $errorMessage = 'Unknown action or missing action: ' . get_param('action');
}

$bookDao = new BookDao();
$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $title = 'Buch anlegen';

        $smarty = new Smarty();
        
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', '');
        $smarty->assign('description', '');
        $smarty->assign('id', '');
        $smarty->assign('users', $userDao->getAll());
        $smarty->assign('bookUsers', array());
        
        $smarty->display('editbook.tpl');

        break;
    case EDIT_ACTION:
        $id = get_param('id');
        $book = $bookDao->get($id);

        $title = $book->getName() . ' bearbeiten';

        $smarty = new Smarty();
        
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', $book->getName());
        $smarty->assign('description', $book->getDescription());
        $smarty->assign('id', $id);
        $smarty->assign('users', $userDao->getAll());
        $smarty->assign('bookUsers', $bookDao->getUsers($book));
        
        $smarty->display('editbook.tpl');

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $name = get_param('name');
        $description = get_param('description');
        $userIds = multi_get_param('users');

        $book = new Book();
        $book->setId($id);
        $book->setName($name);
        $book->setDescription($description);

        $bookDao->save($book);
        
        $users = $userDao->getMultiple($userIds);
        $bookDao->setUsers($book, $users);

        header('Location: index.php', true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('id');
        $bookDao->drop($id);
        header('Location: index.php', true, 302);
        break;
}

