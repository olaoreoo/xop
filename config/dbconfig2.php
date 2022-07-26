<?php
//if (!isset($_SESSION)) { session_start(); }
if ((function_exists('session_status')
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
}

class Database
{
    private $host = "localhost";
    private $db_name = "xop";
    private $username = "bdsx99";
    private $password = "o4c35x";
    public $conn;
    public $charset = 'utf8mb4';
    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //echo "Connection Success: " ;
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
//
// Used by login process
//session_start();
/* DATABASE CONFIGURATION */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'bdsx99');
define('DB_PASSWORD', 'o4c35x');
define('DB_DATABASE', 'xop');
define("BASE_URL", "http://xxvonpoint/"); // Eg. http://yourwebsite.com
function getDB()
{
    $dbhost=DB_SERVER;
    $dbuser=DB_USERNAME;
    $dbpass=DB_PASSWORD;
    $dbname=DB_DATABASE;
    try {
        $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbConnection->exec("set names utf8");
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
