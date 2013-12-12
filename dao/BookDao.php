<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BookDao
 *
 * @author roland
 */
include('mapping/BookMapper.php');
include('dao/Database.php');

final class BookDao {

    private $db = null;

    public function getAll() {
        $sql = "SELECT * FROM books";
        $books = array();
        foreach ($this->createStatement($sql) as $row) {
            $book = BookMapper::createBook($row);
            $books[$book->getId()] = $book;
        }
        return $books;
    }

    private function createStatement($sql) {
        $statement = Database::getDatabase()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            Database::throwDbError($this->getDatabase()->errorInfo());
        }
        return $statement;
    }

}
