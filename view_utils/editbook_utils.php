<?php
/*
 * Author: Roland Kluge
 */

include('view_utils/common.php');

define(NEW_ACTION, "new");
define(EDIT_ACTION, "edit");
define(SAVE_ACTION, "save");

function available_actions() {
    return array(EDIT_ACTION, NEW_ACTION, SAVE_ACTION);
}

function is_valid_action($action) {
    return in_array($action, available_actions());
}