<?php namespace Entity;

class MySQL
{
    private static $instance;
    private $db;

    public static function getInstance($host = null, $dbname = null, $port = null, $charset = null, $user = null, $pass = null)
    {
        // Only one instance of this class should ever exist.
        // $instance will hold a refernce to this instance and we create and return it here.
        // (This is why the constructor has been made private below. It should not be invoked externally)
        if (MySQL::$instance === NULL)
        {
            MySQL::$instance = new MySQL();

            try {
                $dsn = 'mysql:host=' . $host .
                       ';dbname='    . $dbname .
                       ';port='      . $port .
                       ';charset='    .$charset .
                       ';connect_timeout=15';
                MySQL::$instance->db = new PDO($dsn, $user, $pass);
                MySQL::$instance->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new DatabaseErrorException($e->getMessage());
            }
        }
        return MySQL::$instance;
    }
}
