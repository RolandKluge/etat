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

    public function getAll() {
        $sql = "SELECT * FROM books";
        $books = array();
        foreach ($this->createStatement($sql) as $row) {
            $book = BookMapper::createBook($row);
            $books[$book->getId()] = $book;
        }
        return $books;
    }

    public function getBook($id) {
        $sql = "SELECT * FROM books WHERE id=" . (int) $id;
        $row = $this->createStatement($sql)->fetch();
        if (!$row) {
            return NULL;
        } else {
            $book = BookMapper::createBook($row);
            return $book;
        }
    }

    private function createStatement($sql) {
        $statement = Database::getDatabase()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            Database::throwDbError($this->getDatabase()->errorInfo());
        }
        return $statement;
    }

}
