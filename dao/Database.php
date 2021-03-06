<?php

/**
 *
 * @author Roland Kluge
 */
class Database {

    private static $db = null;

    /**
     * @return PDO the database
     * @throws Exception
     */
    public static function getDatabase() {
        if (self::$db == null) {
            try {
                self::$db = new PDO(DB, DB_USER, DB_PASSWORD);
                self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (Exception $ex) {
                throw new Exception('DB connection error: ' . $ex->getMessage());
            }
        }
        return self::$db;
    }
    
    
    public static function createStatement($sql) {
        $statement = Database::getDatabase()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            Database::throwDbError(Database::getDatabase()->errorInfo());
        }
        return $statement;
    }

    public static function throwDbError(array $errorInfo) {
        throw new Exception('DB error [' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }

}
