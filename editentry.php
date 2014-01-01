<?php

/*
 * Author: Roland Kluge
 */
include_once('view_utils/editentry_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
    $errorMessage = '';
} else {
    showError('Unknown action or missing action: ' . get_param('action'), getTemplate());
    return;
}

$bookDao = new BookDao();
$entryDao = new BookEntryDao();
$userDao = new UserDao();

switch ($action) {
    case NEW_ACTION:
        $bookId = get_param('bookId');
        $book = $bookDao->get($bookId);

        $title = 'Eintrag anlegen';

        $smarty = new Smarty();

        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);

        $smarty->assign('id', '');
        $smarty->assign('amount', '');
        $smarty->assign('date', date('d.m.Y'));
        $smarty->assign('description', '');
        $smarty->assign('descriptionSuggestions', $entryDao->getRecentDescriptions($book, 6));
        $smarty->assign('book', $book);

        $smarty->assign('user', NULL);
        $smarty->assign('users', $bookDao->getUsers($book));

        configureLinks($smarty, $book);

        $smarty->display(getTemplate());

        break;
    case EDIT_ACTION:
        $id = get_param('id');
        $entry = $entryDao->get($id);
        
        if ($id == NULL)
        {
            showError("Cannot find an entry with ID " . $id, getTemplate());
        }
        
        $book = $entry->getBook();

        $title = 'Eintrag ' . $entry->getId() . ' bearbeiten';

        $smarty = new Smarty();

        $smarty->assign('title', $title);
        $smarty->assign('action', SAVE_ACTION);

        $smarty->assign('id', $entry->getId());
        $smarty->assign('amount', $entry->getAmount());
        $smarty->assign('date', $entry->getFormattedDate());
        $smarty->assign('description', $entry->getDescription());
        $smarty->assign('descriptionSuggestions', $entryDao->getRecentDescriptions($book, 6));
        $smarty->assign('book', $book);

        $smarty->assign('user', $entry->getUser());
        $smarty->assign('users', $bookDao->getUsers($book));

        configureLinks($smarty, $book);

        $smarty->display(getTemplate());

        break;
    case SAVE_ACTION:
        $id = get_param('id');
        $amount = get_param('amount');
        $formattedDate = get_param('date');
        $description = get_param('description');
        $userId = get_param('user');
        $bookId = get_param('book');

        // Contains the date in the German format: d.m.y
        $dateComponents = explode('.', $formattedDate);
        $date = new DateTime();
        $date->setDate($dateComponents[2], $dateComponents[1], $dateComponents[0]);

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

function configureLinks(Smarty $smarty, Book $book) {

    $links = array(
        array('url' => './index.php', 'label' => LABEL_HOME),
        array('url' => './viewbook.php?id=' . $book->getId(),
            'label' => LABEL_OVERVIEW_OF . $book->getName()));
    assignLinks($links, $smarty);
}

function getTemplate() {
    return 'editentry.tpl';
}