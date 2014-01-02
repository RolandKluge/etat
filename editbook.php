<?php

/*
 * Author: Roland Kluge
 */
include_once('view/common.php');

function available_actions() {
    return array(EDIT_ACTION, NEW_ACTION, SAVE_ACTION, DROP_ACTION);
}

function is_valid_action($action) {
    return in_array($action, available_actions());
}

function getLinks() {
    return array(array('url' => './index.php', 'label' => LABEL_HOME));
}

function getTemplate() {
    return 'editbook.tpl';
}

/*
 * Main routine
 */

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
} else {
    showError('Unknown action or missing action: ' . get_param('action'), getTemplate());
    return;
}

$bookDao = new BookDao();
$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $title = 'Buch anlegen';

        $smarty = new Smarty();

        assignTitle($title, $smarty);
        assignLinks(getLinks(), $smarty);

        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);
        $smarty->assign('name', '');
        $smarty->assign('description', '');
        $smarty->assign('id', '');
        $smarty->assign('users', $userDao->getAll());
        $smarty->assign('bookUsers', array());

        $smarty->display(getTemplate());

        break;
    case EDIT_ACTION:
        $id = get_param('book');
        $book = $bookDao->get($id);

        if ($book == NULL) {
            showError("No book could be found for ID " . $id, getTemplate());
            return;
        }
        $title = $book->getName() . ' bearbeiten';

        $smarty = new Smarty();

        assignTitle($title, $smarty);
        assignLinks(getLinks(), $smarty);

        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);
        $smarty->assign('name', $book->getName());
        $smarty->assign('description', $book->getDescription());
        $smarty->assign('id', $id);
        $smarty->assign('users', $userDao->getAll());
        $smarty->assign('bookUsers', $bookDao->getRealUsers($book));

        $smarty->display(getTemplate());
        break;
    case SAVE_ACTION:
        $id = get_param('book');
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
        $id = get_param('book');
        $bookDao->drop($id);
        header('Location: index.php', true, 302);
        break;
}

