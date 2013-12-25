<?php

/*
 * Author: Roland Kluge
 */
include_once('view_utils/edituser_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    $action = 'new';
    $errorMessage = 'Unknown action or missing action: ' . get_param('action');
}

$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $title = 'Benutzer anlegen';

        $smarty = new Smarty();
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', '');
        $smarty->assign('id', '');
        $smarty->assign('links', array(array('url' => './index.php', 'label' => LABEL_HOME)));
        
        $smarty->display('edituser.tpl');

        break;
    case EDIT_ACTION:
        $id = get_param('id');
        $user = $userDao->get($id);

        $title = $user->getName() . ' bearbeiten';

        $smarty = new Smarty();
        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);
        $smarty->assign('name', $user->getName());
        $smarty->assign('id', $id);
        $smarty->assign('links', array(array('url' => './index.php', 'label' => LABEL_HOME)));
        
        $smarty->display('edituser.tpl');

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $name = get_param('name');

        $user = new User();
        $user->setId($id);
        $user->setName($name);
        $user->setIsReal(true);

        $userDao->save($user);

        header('Location: index.php', true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('id');
        $userDao->drop($id);
        header('Location: index.php', true, 302);
        break;
}

