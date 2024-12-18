<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\UserDAO;

class UserManagementController extends Controller {

    public function enter() {
        $userDAO = new UserDAO();
        $users = $userDAO->getAllUsers();
        $this->render("usermanagement", ['users' => $users]);
    }

    public function addUser() {
        $username = $_POST['user_name'];
        $password = $_POST['password'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $isAdmin = $_POST['isAdmin'];
        $isDev = $_POST['isDev'];

        $userDAO = new UserDAO();
        if (!$userDAO->isUsernameExisting($username)) {
            $userDAO->addUser($username, $password, $vorname, $nachname, $isAdmin, $isDev);
        }
        $users = $userDAO->getAllUsers();
        $this->render("usermanagement", ['users' => $users]);

    }

    public function removeUser() {
        $userid = $_POST['user_id'];
        $currentUserId = $_POST['current_user_id'];

        $userDAO = new UserDAO();
        $userDAO->deleteUser($userid);

        if ($currentUserId == $userid) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        $users = $userDAO->getAllUsers();
        $this->render("usermanagement", ['users' => $users]);
    }

    public function updateUser() {
        $userId = $_POST['user_id'];
        $userName = $_POST['user_name'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $isAdmin = $_POST['isAdmin'];
        $isDev = $_POST['isDev'];
    
        $userDAO = new UserDAO();
        $userDAO->updateUser($userId, $userName, $vorname, $nachname, $isAdmin, $isDev);
    
        $users = $userDAO->getAllUsers();
        $this->render("usermanagement", ['users' => $users]);
    }
    
}