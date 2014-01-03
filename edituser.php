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
    return 'edituser.tpl';
}

/*
 * Main routine
 */

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    showError('Unknown action or missing action: ' . get_param('action'), getTemplate());
    return;
}
$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $title = 'Benutzer anlegen';

        $smarty = new Smarty();
        
        markNoErrors($smarty);
        assignTitle($title, $smarty);
        assignLinks(getLinks(), $smarty);
        
        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);
        $smarty->assign('name', '');
        $smarty->assign('id', '');
        
        $smarty->display(getTemplate());

        break;
    case EDIT_ACTION:
        $id = get_param('user');
        $user = $userDao->get($id);
        
        if ($user == NULL) {
            showError("No book could be found for ID " . $id, getTemplate());
            return;
        }

        $title = 'Benutzer ' . $user->getId() . ' bearbeiten';

        $smarty = new Smarty();
        
        markNoErrors($smarty);
        assignTitle($title, $smarty);
        assignLinks(getLinks(), $smarty);
        
        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);
        $smarty->assign('name', $user->getName());
        $smarty->assign('id', $id);
        
        $smarty->display(getTemplate());

        break;
    case SAVE_ACTION:
        $id = get_param('user');
        $name = get_param('name');

        $user = new User();
        $user->setId($id);
        $user->setName($name);
        $user->setIsReal(true);

        $userDao->save($user);

        header('Location: index.php', true, 302);
        break;
    case DROP_ACTION:
        $id = get_param('user');
        $userDao->drop($id);
        header('Location: index.php', true, 302);
        break;
}
