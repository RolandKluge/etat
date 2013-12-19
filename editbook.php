<?php
/*
 * Author: Roland Kluge
 */
include('view_utils/editbook_utils.php');

if (has_get_param('action') && is_valid_action(get_param('action'))) {
    $action = get_param('action');
} else {
    $action = 'new';
}

switch ($action) {
    case NEW_ACTION:
        $title = 'Buch anlegen';
        break;
    case EDIT_ACTION:
        $title = 'Buch bearbeiten';
        $id = get_param('id');
        break;
    case SAVE_ACTION:
        // TODO rkluge: write save code
        header('Location: index.php', true, 302);
        break;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1><?php echo $title; ?></h1>
        <form id="editBookForm" method="get" action="editbook.php">
            <label for="name">Name</label>
            <input name="name" type="text" size="40"></input>
            <input name="action" type="hidden" value="<?php echo SAVE_ACTION; ?>"></input>
            <button type="submit">Speichern</button>
        </form>
    </body>
</html>
