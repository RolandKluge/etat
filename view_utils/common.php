<?php
/*
 * Author: Roland Kluge
 */

function get_param($key) {
    return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
}

function has_get_param($key) {
    return get_param($key) != NULL;
}
