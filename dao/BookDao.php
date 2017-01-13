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

    public function save(Book $book) {
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
        $statement->bindValue(":name", $book->getName());
        $statement->bindValue(":description", $book->getDescription());
        $statement->execute();
        $book->setId(Database::getDatabase()->lastInsertId());
    }

    private function update(Book $book) {
        $sql = "UPDATE books SET name = :name, description = :description WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindValue(":id", $book->getId());
        $statement->bindValue(":name", $book->getName());
        $statement->bindValue(":description", $book->getDescription());
        $statement->execute();
    }

    public function addUser(Book $book, User $user) {
        $sql = "INSERT INTO users_to_books (user_id, book_id) VALUES (:user_id, :book_id)";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindValue(":user_id", $user->getId(), PDO::PARAM_INT);
        $statement->bindValue(":book_id", $book->getId(), PDO::PARAM_INT);
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

    /*
     * Section on 'users and books'
     */

    private function createDefaultUser(Book $book) {
        $user = new User();
        $user->setName("Gemeinschaft");
        $user->setIsReal(false);

        $userDao = new UserDao();
        $userDao->save($user);

        $this->addUser($book, $user);
    }

    private function dropDefaultUser(Book $book) {
        $sql = "SELECT * FROM users_to_books JOIN users ON users_to_books.user_id = users.id WHERE book_id = :book_id AND NOT is_real";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindValue(":book_id", $book->getId(), PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $userDao = new UserDao();
        $userDao->drop($row['user_id']);
    }

    public function getRealUsers(Book $book) {
        $users = array();
        foreach ($this->getUsers($book) as $user) {
            if ($user->isReal()) {
                array_push($users, $user);
            }
        }
        return $users;
    }

    public function getDefaultUser(Book $book) {
        foreach ($this->getUsers($book) as $user) {
            if (!$user->isReal()) {
                return $user;
            }
        }
        //TODO rkluge: exception?
        return null;
    }

    public function getUsers(Book $book) {
        $sql = "SELECT * FROM users_to_books JOIN users ON users_to_books.user_id = users.id WHERE book_id = :book_id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindValue(":book_id", $book->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $users = array();
        $userDao = new UserDao();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $user = $userDao->get($row['user_id']);
            array_push($users, $user);
        }
        return $users;
    }
    
    public function getBooks(User $user) {
        $sql = "SELECT * FROM users_to_books JOIN users ON users_to_books.user_id = users.id WHERE user_id = :user_id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindValue(":user_id", $user->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $books = array();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $book = $this->get($row['book_id']);
            array_push($books, $book);
        }
        return $books;
    }

    public function getBookToUsersMapping(array $books) {
        $result = array();
        foreach ($books as $book) {
            $result[$book->getId()] = $this->getRealUsers($book);
        }
        return $result;
    }

    public function getUserToBooksMapping(array $users) {
        $result = array();
        foreach ($users as $user) {
            $result[$user->getId()] = $this->getBooks($user);
        }
        return $result;
    }

    public function setUsers(Book $book, array $users) {
        $this->removeRealUsers($book);
        foreach ($users as $user) {
            $this->addUser($book, $user);
        }
    }

    public function removeRealUsers(Book $book) {
        foreach ($this->getUsers($book) as $user) {
            if ($user->isReal()) {
                $this->removeUser($book, $user);
            }
        }
    }

    public function removeUser(Book $book, User $user) {
        $sql = "DELETE FROM users_to_books WHERE book_id = :book_id AND user_id = :user_id";
        $stmt = Database::getDatabase()->prepare($sql);
        $stmt->bindValue(":book_id", $book->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $user->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

}
