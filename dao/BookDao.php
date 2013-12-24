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
        foreach (Database::createStatement($sql) as $row) {
            $book = BookMapper::createBook($row);
            $books[$book->getId()] = $book;
        }
        return $books;
    }

    public function get($id) {
        $sql = "SELECT * FROM books WHERE id=" . (int) $id;
        $row = Database::createStatement($sql)->fetch();
        if (!$row) {
            return NULL;
        } else {
            $book = BookMapper::createBook($row);
            return $book;
        }
    }

    public function save($book) {
        if ($book->getId()) {
            $this->update($book);
        } else {
            $this->create($book);
        }
    }

    private function create(Book $book) {
        $sql = "INSERT INTO books (name, description) VALUES (:name, :description)";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":name", $book->getName());
        $statement->bindParam(":description", $book->getDescription());
        $statement->execute();
        $book->setId(Database::getDatabase()->lastInsertId());
    }

    private function update(Book $book) {
        $sql = "UPDATE books SET name = :name, description = :description WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":id", $book->getId());
        $statement->bindParam(":name", $book->getName());
        $statement->bindParam(":description", $book->getDescription());
        $statement->execute();
    }

    public function drop($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->execute(array(":id" => $id));
    }

}
