<?php

/**
 * Description of BookDao
 *
 * @author Roland Kluge
 */
include_once('mapping/BookMapper.php');
include_once('dao/Database.php');

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

    public function save($book) {
        if ($book->getId()) {
            $this->updateBook($book);
        } else {
            $this->createBook($book);
        }
    }

    private function createBook(Book $book) {
        $sql = "INSERT INTO books (name, description) VALUES (:name, :description)";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":name", $book->getName());
        $statement->bindParam(":description", $book->getDescription());
        $statement->execute();
        $book->setId(Database::getDatabase()->lastInsertId());
    }

    private function updateBook(Book $book) {
        $sql = "UPDATE books SET name = :name, description = :description WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":id", $book->getId());
        $statement->bindParam(":name", $book->getName());
        $statement->bindParam(":description", $book->getDescription());
        $statement->execute();
    }

    public function dropBook($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->execute(array(":id" => $id));
    }

    private function createStatement($sql) {
        $statement = Database::getDatabase()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            Database::throwDbError($this->getDatabase()->errorInfo());
        }
        return $statement;
    }

}
