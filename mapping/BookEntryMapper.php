<?php

include('model/BookEntry.php');

/**
 *
 * @author Roland Kluge
 */
class BookEntryMapper {

    public static function map(array $row, Book $book, User $user) {
        $entry = new BookEntry();
        $entry->setId($row['id']);
        $entry->setAmount($row['amount']);
        $entry->setDate($row['date']);
        $entry->setDescription($row['description']);
        $entry->setBook($book);
        $entry->setUser($user);
        return $entry;
    }

}
