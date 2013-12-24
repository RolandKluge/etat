<?php

/**
 * Description of BookDao
 *
 * @author Roland Kluge
 */
include_once('mapping/BookMapper.php');
include_once('dao/UserDao.php');
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
            $this->createDefaultUser($book);
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

    public function addUserToBook(User $user, Book $book) {
        $sql = "INSERT INTO users_to_books (user_id, book_id) VALUES (:user_id, :book_id)";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":user_id", $user->getId());
        $statement->bindParam(":book_id", $book->getId());
        $statement->execute();
    }

    public function drop($id) {
        $book = $this->get($id);
        if ($book) {
            $this->dropDefaultUser($book);

            $sql = "DELETE FROM books WHERE id = :id";
            $statement = Database::getDatabase()->prepare($sql);
            $statement->execute(array(":id" => $id));
        }
    }

    private function createDefaultUser(Book $book) {
        $user = new User();
        $user->setName("Gemeinschaft");
        $user->setIsReal(false);

        $userDao = new UserDao();
        $userDao->save($user);

        $this->addUserToBook($user, $book);
    }
    
    private function dropDefaultUser(Book $book) {
        $sql = "SELECT * FROM users_to_books JOIN users ON users_to_books.user_id = users.id WHERE book_id = :book_id AND NOT isReal";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":book_id", $book->getId());
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        
        $userDao = new UserDao();
        $userDao->drop($row['user_id']);
    }

}
