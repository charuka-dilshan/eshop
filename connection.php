<?php

class Database
{
    public static $connection;

    public static function setUpConnection()
    {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "Charuka@2004", "eshop", 3306);
        }
    }

    public static function iud($q) //INSERT UPDATE DELETE
    {
        Database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q)
    {
        Database::setUpConnection();
        $resulset = Database::$connection->query($q);
        return $resulset;
    }
}
