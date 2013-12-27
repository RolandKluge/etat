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

    public function getEntryCount(Book $book) {
        $sql = "SELECT COUNT(*) as count FROM entries WHERE book_id = :book_id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->execute(array(":book_id" => $book->getId()));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        return $count;
    }

    public function getEntries(Book $book, $limitFrom, $limitTo) {
        $bookEntryMapper = new BookEntryMapper();
        $userDao = new UserDao();

        $sql = "SELECT * FROM entries WHERE book_id = :book_id "
                . " ORDER BY date DESC "
                . " LIMIT :limit_from, :limit_to";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindValue(":limit_from", $limitFrom, PDO::PARAM_INT);
        $stmt->bindValue(":limit_to", $limitTo, PDO::PARAM_INT);
        $stmt->bindParam(":book_id", $book->getId());
        $stmt->execute();

        $result = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $user = $userDao->get($row['user_id']);
            $entry = $bookEntryMapper->map($row, $book, $user);

            array_push($result, $entry);
        }

        // uasort($result, 'BookEntry::compareByDateRevers');

        return $result;
    }

    public function getRecentDescriptions(Book $book, $limit) {
        
        $sql = "SELECT DISTINCT description, date FROM entries WHERE book_id = :book_id "
                . " ORDER BY date DESC "
                . " LIMIT 0, :limit_to";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindParam(":book_id", $book->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":limit_to", $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultSet = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $desc = $row['description'];
            if ($desc != '') {
                $resultSet[$desc] = 1;
            }
        }

        return array_keys($resultSet);
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
