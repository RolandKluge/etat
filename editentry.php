<?php

/*
 * Author: Roland Kluge
 */
include_once('view/common.php');

function available_actions()
{
    return array(EDIT_ACTION, NEW_ACTION, SAVE_ACTION, DROP_ACTION);
}

function is_valid_action($action)
{
    return in_array($action, available_actions());
}

function configureLinks(Smarty $smarty, Book $book)
{

    $links = array(
        array('url' => './index.php', 'label' => LABEL_HOME),
        array('url' => './viewbook.php?book=' . $book->getId(),
            'label' => LABEL_OVERVIEW_OF . $book->getName()));
    assignLinks($links, $smarty);
}

function getTemplate()
{
    return 'editentry.tpl';
}

/*
 * Main routine 
 */

if (has_get_param('action') && is_valid_action(get_param('action')))
{
    $action = get_param('action');
}
else
{
    showError('Unknown action or missing action: ' . get_param('action'), getTemplate());
    return;
}

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$userDao = new UserDao();

switch ($action)
{
    case NEW_ACTION:
        $bookId = get_param('book');
        $book = $bookDao->get($bookId);

        $smarty = new Smarty();

        markNoErrors($smarty);
        assignTitle('Eintrag anlegen', $smarty);
        configureLinks($smarty, $book);

        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);

        $smarty->assign('id', '');
        $smarty->assign('amount', '');
        $smarty->assign('date', date('Y-m-d'));
        $smarty->assign('description', '');
        $smarty->assign('descriptionSuggestions', $entryDao->getRecentDescriptions($book, 6));
        $smarty->assign('book', $book);

        $smarty->assign('user', NULL);
        $smarty->assign('users', $bookDao->getUsers($book));


        $smarty->display(getTemplate());

        break;
    case EDIT_ACTION:
        $id = get_param('entry');
        $entry = $entryDao->get($id);

        if ($entry == NULL)
        {
            showError("Cannot find an entry with ID " . $id, getTemplate());
            return;
        }

        $book = $entry->getBook();

        $smarty = new Smarty();

        markNoErrors($smarty);
        assignTitle('Eintrag ' . $entry->getId() . ' bearbeiten', $smarty);
        configureLinks($smarty, $book);

        $smarty->assign('currentAction', $action);
        $smarty->assign('submitAction', SAVE_ACTION);

        $smarty->assign('id', $entry->getId());
        $smarty->assign('amount', $entry->getAmount());
        $smarty->assign('formattedDate', $entry->getFormattedDate());
        $smarty->assign('description', $entry->getDescription());
        $smarty->assign('descriptionSuggestions', $entryDao->getRecentDescriptions($book, 6));
        $smarty->assign('book', $book);

        $smarty->assign('user', $entry->getUser());
        $smarty->assign('users', $bookDao->getUsers($book));


        $smarty->display(getTemplate());

        break;
    case SAVE_ACTION:
        $id = get_param('entry');
        $amount = get_param('amount');
        $amount = str_replace(",", ".", $amount);
        $formattedDate = get_param('date');
        $description = get_param('description');
        $userId = get_param('user');
        $bookId = get_param('book');
        $afterSaveAction = get_param('afterSaveAction');

        // Contains the date in the German format: d.m.y
        $dateComponents = explode('-', $formattedDate);
        $date = new DateTime();
        $date->setDate($dateComponents[0], $dateComponents[1], $dateComponents[2]);

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

        if ($afterSaveAction == 'new')
        {
            header('Location: editentry.php?action=' . NEW_ACTION . '&book=' . $book->getId(), true, 302);
        }
        else
        {
            header('Location: viewbook.php?book=' . $book->getId(), true, 302);
        }

        break;
    case DROP_ACTION:
        $id = get_param('entry');
        $entry = $entryDao->get($id);
        $book = $entry->getBook();
        $entryDao->drop($id);
        header('Location: viewbook.php?book=' . $book->getId(), true, 302);
        break;
}
