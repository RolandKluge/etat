<?php

/**
 * Description of BookDao
 *
 * @author Roland Kluge
 */
include_once('mapping/UserMapper.php');
include_once('dao/Database.php');

final class UserDao {

    public function getAll() {
        $sql = "SELECT * FROM users";
        $users = array();
        foreach (Database::createStatement($sql) as $row) {
            $user = UserMapper::map($row);
            $users[$user->getId()] = $user;
        }
        return $users;
    }

    public function getMultiple($userIds) {
        $sql = "SELECT * FROM users";
        $users = array();
        foreach (Database::createStatement($sql) as $row) {
            $user = UserMapper::map($row);
            if (in_array($user->getId(), $userIds)) {
                $users[$user->getId()] = $user;
            }
        }
        return $users;
    }

    public function get($id) {
        $sql = "SELECT * FROM users WHERE id=" . (int) $id;
        $row = Database::createStatement($sql)->fetch();
        if (!$row) {
            return NULL;
        } else {
            $user = UserMapper::map($row);
            return $user;
        }
    }

    public function save(User $user) {
        if ($user->getId()) {
            $this->update($user);
        } else {
            $this->create($user);
        }
    }

    private function create(User $user) {
        $sql = "INSERT INTO users (name, is_real) VALUES (:name, :is_real)";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":name", $user->getName());
        $statement->bindParam(":is_real", $user->isReal());
        $statement->execute();
        $user->setId(Database::getDatabase()->lastInsertId());
    }

    private function update(User $user) {
        $sql = "UPDATE users SET name = :name WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->bindParam(":id", $user->getId());
        $statement->bindParam(":name", $user->getName());
        $statement->execute();
    }

    public function drop($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $statement = Database::getDatabase()->prepare($sql);
        $statement->execute(array(":id" => $id));
    }

}
