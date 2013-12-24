<?php

include_once('model/User.php');

/**
 *
 * @author Roland Kluge
 */
class UserMapper {

    public static function map(array $row) {
        $user = new User();
        $user->setId($row['id']);
        $user->setName($row['name']);
        $user->setIsReal($row['isReal']);
        return $user;
    }

}
