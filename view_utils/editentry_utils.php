<?php
/*
 * Author: Roland Kluge
 */
include('view_utils/common.php');

function available_actions() {
    return array(EDIT_ACTION, NEW_ACTION, SAVE_ACTION, DROP_ACTION);
}

function is_valid_action($action) {
    return in_array($action, available_actions());
}