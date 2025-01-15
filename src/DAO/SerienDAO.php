<?php

namespace ShotLog\DAO;

use Exception;
use ShotLog\Models\Serie;
use ShotLog\Models\User;
use ShotLog\Utils\Config;
use PDO;

class SerienDAO
{
    private PDO $db;

    /**
     * @throws Exception
     */
    public function __construct(){
        $host = Config::getFromDBProperties("db.host");
        $dbname = Config::getFromDBProperties("db.name");
        $username = Config::getFromDBProperties("db.username");
        $password = Config::getFromDBProperties("db.password");

        try {
            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function saveSerie(Serie $serie): bool
    {
        $query = "INSERT INTO serie (sessionId, isTest)
                VALUES (:sessionId, :isTest)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':sessionId', $serie->getSessionId());
        $stmt->bindValue(':isTest', $serie->getIsTest());
        return $stmt->execute();
    }

    public function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }
}