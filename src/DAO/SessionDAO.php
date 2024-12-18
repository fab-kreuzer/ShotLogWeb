<?php

namespace ShotLog\DAO;

use ShotLog\Models\Session;
use ShotLog\Utils\Config;
use PDO;

class SessionDAO
{
    private $db;

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

    /**
     * Get all sessions where isWettkampf matches the given parameter.
     *
     * @param bool $isWettkampf
     * @return Session[]
     */
    public function getSessionByUserAndType(bool $isWettkampf, string $userID): array
    {
        $query = 'SELECT * FROM session WHERE isWettkampf = :isWettkampf and user_id = :userid';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':isWettkampf', $isWettkampf, PDO::PARAM_BOOL);
        $stmt->bindValue(':userid', $userID);
        $stmt->execute();

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Session(
                $row['id'],
                $row['Ort'],
                $row['start_at'],
                (bool)$row['isWettkampf'],
                $row['inserted_at'],
                $row['user_id']
            );
        }

        return $results;
    }
}
