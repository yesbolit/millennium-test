<?php declare(strict_types=1);

use PDO;
use PDOException;

class PDOConnection
{
    private static $instance;

    private function __construct() {}

    public static function getInstance()
    {
        if (!self::$instance) {
            try {
                $dsn = 'mysql:host=mysql;dbname=millennium';
                $user = 'root';
                $password = 'someRootPassword123';

                self::$instance = new PDO($dsn, $user, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}