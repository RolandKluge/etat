<?php

/**
 * Description of BookDao
 *
 * @author Roland Kluge
 */
include_once('mapping/BookEntryMapper.php');
include_once('dao/UserDao.php');
include_once('dao/BookDao.php');
include_once('dao/Database.php');

final class BookEntryDao {
    
    public function get($id) {
        $sql = "SELECT * FROM entries WHERE id = :id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $userDao = new UserDao();
        $bookDao = new BookDao();
        $user = $userDao->get($row['user_id']);
        $book = $bookDao->get($row['book_id']);
        $entry = BookEntryMapper::map($row, $book, $user);
        return $entry;
    }

    public function getEntries(Book $book) {
        $bookEntryMapper = new BookEntryMapper();
        $userDao = new UserDao();

        $sql = "SELECT * FROM entries WHERE book_id = :book_id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->execute(array(":book_id" => $book->getId()));

        $result = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $user = $userDao->get($row['user_id']);
            $entry = $bookEntryMapper->map($row, $book, $user);

            array_push($result, $entry);
        }
        return $result;
    }

    public function save(BookEntry $entry) {
        if ($entry->getId()) {
            $this->update($entry);
        } else {
            $this->create($entry);
        }
    }

    private function create(BookEntry $entry) {
        $sql = 'INSERT INTO entries (amount, date, description, book_id, user_id)' .
                ' VALUES (:amount, :date, :description, :book_id, :user_id)';
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindParam(":amount", $entry->getAmount());
        $stmt->bindParam(":date", BookEntryDao::formatDateTime($entry->getDate()));
        $stmt->bindParam(":description", $entry->getDescription());
        $stmt->bindParam(":book_id", $entry->getBook()->getId());
        $stmt->bindParam(":user_id", $entry->getUser()->getId());
        $stmt->execute();
    }

    private function update(BookEntry $entry) {
        $sql = 'UPDATE entries SET amount = :amount, date = :date, description = :description, '
                . 'book_id = :book_id, user_id = :user_id '
                . 'WHERE id = :id';
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindParam(":id", $entry->getId());
        $stmt->bindParam(":amount", $entry->getAmount());
        $stmt->bindParam(":date", BookEntryDao::formatDateTime($entry->getDate()));
        $stmt->bindParam(":description", $entry->getDescription());
        $stmt->bindParam(":book_id", $entry->getBook()->getId());
        $stmt->bindParam(":user_id", $entry->getUser()->getId());
        $stmt->execute();
    }

    public function drop($id) {
        $sql = "DELETE FROM entries WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->execute(array(":id" => $id));
    }
    
    private static function formatDateTime(DateTime $date) {
        return $date->format(DateTime::ISO8601);
    }
}
