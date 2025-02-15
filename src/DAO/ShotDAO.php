<?php

namespace ShotLog\DAO;

use Exception;
use ShotLog\Models\Schuss;
use ShotLog\Models\Serie;
use ShotLog\Models\User;
use ShotLog\Utils\Config;
use PDO;

class ShotDAO
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

    public function saveShot(Schuss $schuss): bool
    {
        $query = "INSERT INTO schuss (wert, serienId)
                VALUES (:wert, :serienId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':wert', $schuss->getWert());
        $stmt->bindValue(':serienId', $schuss->getSerienId());
        return $stmt->execute();
    }

    public function lastInsertId(): bool|string
    {
        return $this->db->lastInsertId();
    }

    public function getShotsBySerieId(mixed $id): array
    {
        $query = "SELECT * FROM schuss WHERE serienId = :serienId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':serienId', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $shots = [];
            foreach ($result as $row) {
                $shot = new Schuss();
                $shot->setId($row['id']);
                $shot->setWert($row['wert']);
                $shot->setSerienId($row['serienId']);
                $shots[] = $shot;
            }

            return $shots;
        }

        return []; // Return an empty array if execution fails or no data found.
    }

    public function deleteshot(mixed $shotId): bool
    {
        $query = "DELETE FROM schuss WHERE id = :shotId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':shotId', $shotId);
        return $stmt->execute();

    }

    public function updateShot(Schuss $shot): void
    {
        $stmt = $this->db->prepare("UPDATE schuss SET wert = :value WHERE id = :id");
        $stmt->bindValue(':value', $shot->getWert());
        $stmt->bindValue(':id', $shot->getId());
        $stmt->execute();
    }
}