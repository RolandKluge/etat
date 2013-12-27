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
        $entry->setDate(BookEntryMapper::createDateTime($row['date']));
        $entry->setDescription($row['description']);
        $entry->setBook($book);
        $entry->setUser($user);
        return $entry;
    }

    private static function createDateTime($input) {
        // Too new, not supported before PHP 5.3
        // return DateTime::createFromFormat('Y-n-j', $input);
        $dateComponents = explode('-', $input);
        $date = new DateTime();
        $date->setDate($dateComponents[0], $dateComponents[1], $dateComponents[2]);
        return $date;
    }

}
