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
        $user = $bookDao->get($id);

        $title = $user->getName() . ' bearbeiten';

        $smarty = new Smarty();
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', $user->getName());
        $smarty->assign('description', $user->getDescription());
        $smarty->assign('id', $id);
        $smarty->display('editbook.tpl');

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $name = get_param('name');
        $description = get_param('description');

        $user = new Book();
        $user->setId($id);
        $user->setName($name);
        $user->setDescription($description);

        $bookDao->save($user);

        header('Location: viewbook.php?book=' . $user->getId(), true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('id');
        $bookDao->drop($id);
        header('Location: index.php', true, 302);
        break;
}

