<?php

namespace Geovendas\StoreX\Connections;

use \PDO;
use \PDOException;

class ConnPDO
{
    public static function connect(): PDO
    {
        try {
            $dbHost = 'localhost';
            $dbName = 'teste_geovendas';
            $dbUser = 'root';
            $dbPassword = '';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $conn = new PDO("mysql:host=$dbHost; dbname=$dbName", $dbUser, $dbPassword, $options);
            $conn->exec("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
            return $conn;
        } catch (PDOException $e) {
            $e->getMessage();
            echo "Não foi possível se conectar, tente novamente mais tarde. error:($e)";
            exit();
        }
    }
}
