<?php

namespace ShotLog\DAO;

use ShotLog\Models\Session;
use ShotLog\Utils\Config;
use PDO;

class SessionDAO
{
    private $db;

    /**
     * @throws \Exception
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
                $row['user_id'],
                $row['desc'],
            );
        }

        return $results;
    }
       /**
     * Get all sessions for the given User.
     *
     * @param bool $isWettkampf
     * @return Session[]
     */
    public function getSessionByUser(string $userID): array
    {
        $query = 'SELECT * FROM session where user_id = :userid';
        $stmt = $this->db->prepare($query);
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
                $row['user_id'],
                $row['desc']
            );
        }

        return $results;
    }

    public function addSession(Session $session): bool {
        $query = 'INSERT INTO session (isWettkampf, ort, start_at, user_id, `desc`) 
                  VALUES (:isWettkampf, :ort, :start_at, :user_id, :desc)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('isWettkampf', $session->getIsWettkampf() ? 1 : 0);
        $stmt->bindValue('ort', $session->getOrt());
        $stmt->bindValue('start_at', $session->getStartAt());
        $stmt->bindValue('user_id', $_SESSION['user_id']);
        $stmt->bindValue('desc', $session->getDesc());
        return $stmt->execute();
    }
    
    public function deleteSession(int $id) {
        $query = 'DELETE FROM session where id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id', $id);
        $stmt->execute();
    }

    public function updateSession(Session $session) {
        $query = 'UPDATE session 
        SET isWettkampf = :isWettkampf, 
            ort = :ort, 
            start_at = :start_at, 
            `desc` = :desc 
        WHERE id = :id';

        $stmt = $this->db->prepare($query);

        // Bind parameters from the Session object
        $stmt->bindValue('isWettkampf', $session->getIsWettkampf() ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue('ort', $session->getOrt(), PDO::PARAM_STR);
        $stmt->bindValue('start_at', $session->getStartAt(), PDO::PARAM_STR);
        $stmt->bindValue('desc', $session->getDesc(), PDO::PARAM_STR);
        $stmt->bindValue('id', $session->getId(), PDO::PARAM_INT);

        // Execute the query and return the result
        return $stmt->execute();

    }

    public function updateTime(string $id, string $start_at): bool
    {
        $query = 'UPDATE session 
        SET start_at = :start_at
        WHERE id = :id';

        $stmt = $this->db->prepare($query);

        // Bind parameters from the Session object
        $stmt->bindValue('start_at', $start_at);
        $stmt->bindValue('id', $id);

        // Execute the query and return the result
        return $stmt->execute();

    }

    public function lastInsertId(): bool|string
    {
        return $this->db->lastInsertId();
    }

    public function getSessionById($sessionId): ?Session
    {
        $query = "SELECT * FROM session WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $sessionId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $session = new Session();
                $session->setId($row['id']);
                $session->setOrt($row['Ort']);
                $session->setStartAt($row['start_at']);
                $session->setIsWettkampf((bool) $row['isWettkampf']);
                $session->setInsertedAt($row['inserted_at']);
                $session->setUserId($row['user_id']);
                $session->setDesc($row['desc']);

                return $session;
            }
        }

        return null;
    }

    public function clearCurrentSession($sessionID)
    {
        //get all series from session
        $query = "SELECT id FROM serie WHERE sessionId = :sID";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':sID', $sessionID);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                //remove all shots from series
                $query = "DELETE FROM schuss WHERE serienId = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id', $row['id']);
                $stmt->execute();

                //remove serie itself
                $query = "DELETE FROM serie WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':id', $row['id']);
                $stmt->execute();

            }
        }
    }


}
