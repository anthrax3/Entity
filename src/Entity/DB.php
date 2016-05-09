<?php namespace Entity;

/**
* Database
*/
class DB {
    protected static $connection;
    protected static $host;
    protected static $dbname;
    protected static $user;
    protected static $pass;

    public function __construct($host = null, $dbname = null, $port = null, $charset = null, $user = null, $pass = null) {

        self::$host = $host;
        self::$dbname = $dbname;
        self::$user = $user;
        self::$pass = $pass;
        if (!self::$connection->pdo instanceof PDO) {
            self::$connection = MySQL::getInstance();
        }
    }

    public static function getInstance() {
        return self::$connection;
    }
}
