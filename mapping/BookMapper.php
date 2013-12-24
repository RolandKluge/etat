<?php

include('model/Book.php');

/**
 *
 * @author Roland Kluge
 */
class BookMapper {

    public static function createBook($row) {
        $book = new Book();
        $book->setId($row['id']);
        $book->setName($row['name']);
        $book->setDescription($row['description']);
        return $book;
    }

}
