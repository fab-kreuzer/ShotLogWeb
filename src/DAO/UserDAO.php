<?php

namespace ShotLog\DAO;

use ShotLog\Models\User;
use ShotLog\Utils\Config;
use PDO;

class UserDAO
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
     * @return User
     */
    public function getUserByUserName(string $username): User|false
    {
        $query = 'SELECT * FROM users WHERE user_name = :username';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return false;
        }

        $result = new User(
            $row['user_id'],
            $row['user_name'],
            $row['user_password'],
            (bool)$row['vorname'],
            $row['nachname'],
            $row['isDev'],
            $row['isAdmin']
        );

        return $result;
    }

    /**
     * Get all users from the database.
     *
     * @return User[]
     */
    public function getAllUsers(): array
    {
        $query = 'SELECT * FROM users';
        $stmt = $this->db->query($query);
        
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['user_id'],
                $row['user_name'],
                $row['user_password'],
                $row['vorname'],
                $row['nachname'],
                (bool)$row['isDev'],
                (bool)$row['isAdmin'],
                $row['created_at'],
            );
        }

        return $users;
    }

    /**
     * Add a new user to the database.
     *
     * @param string $userName
     * @param string $password (hashed)
     * @param string $vorname
     * @param string $nachname
     * @param bool $isAdmin
     * @param bool $isDev
     * @return bool True if the user was added successfully, false otherwise.
     */
    public function addUser(string $userName, string $password, string $vorname, string $nachname, bool $isAdmin, bool $isDev): bool
    {
        $query = "INSERT INTO users (user_name, user_password, vorname, nachname, isAdmin, isDev, created_at)
                VALUES (:user_name, :user_password, :vorname, :nachname, :isAdmin, :isDev, NOW())";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':user_name', $userName);
        $stmt->bindValue(':user_password', hash('sha256', $password));
        $stmt->bindValue(':vorname', $vorname);
        $stmt->bindValue(':nachname', $nachname);
        $stmt->bindValue(':isAdmin', $isAdmin, PDO::PARAM_BOOL);
        $stmt->bindValue(':isDev', $isDev, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    /**
     * Check if a username already exists in the database.
     *
     * @param string $userName
     * @return bool True if the username exists, false otherwise.
     */
    public function isUsernameExisting(string $userName): bool
    {
        $query = "SELECT COUNT(*) FROM users WHERE user_name = :user_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_name', $userName);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public function deleteUser(string $userId) {
        $query = 'delete from users where user_id = :userid';
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['userid'=> $userId]);
    }
    public function updateUser(int $userId, string $userName, string $vorname, string $nachname, bool $isAdmin, bool $isDev): bool
{
    // Check if the user is trying to change their username to an existing one
    $query = 'SELECT COUNT(*) FROM users WHERE user_name = :user_name AND user_id != :user_id';
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':user_name', $userName);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        // Username already exists for another user
        return false;
    }

    // Proceed with the update if username is unique
    $query = 'UPDATE users 
              SET user_name = :user_name, vorname = :vorname, nachname = :nachname, isAdmin = :is_admin, isDev = :is_dev 
              WHERE user_id = :user_id';
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':user_name', $userName);
    $stmt->bindValue(':vorname', $vorname);
    $stmt->bindValue(':nachname', $nachname);
    $stmt->bindValue(':is_admin', $isAdmin, PDO::PARAM_BOOL);
    $stmt->bindValue(':is_dev', $isDev, PDO::PARAM_BOOL);

    // Execute the update query
    $result = $stmt->execute();

    // If the user is updating their own details (based on userId), update the session variables
    if ($result && $userId == $_SESSION['user_id']) {
        $_SESSION['username'] = $userName;
        $_SESSION['isDev'] = $isDev;
        $_SESSION['isAdmin'] = $isAdmin;
    }

    return $result; 
}        
    
}