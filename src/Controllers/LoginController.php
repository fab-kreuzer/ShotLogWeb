<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\UserDAO;

class LoginController extends Controller {

    public function enter() {
        $this->render("login");
    }

    public function login() {
        session_start();
        // Get the username and password from the form
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate input (e.g., check if empty)
        if (empty($username) || empty($password)) {
            // Handle invalid input (e.g., redirect back with an error message)
            $this->addNotification('error', 'Benutzername oder Password dürfen nicht leer sein');
            echo 'empty username';
            header('Location: /login');
            exit;
        }

        // Check the credentials (this could be a call to a database or service)
        $userDAO = new UserDAO();
        $user = $userDAO->getUserByUsername($username);
        // If user is found and the password matches
        if ($user && $user->password == hash('sha256', $password)) {
            
            // Set the session variable to indicate the user is logged in
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['isAdmin'] = $user->isAdmin;
            $_SESSION['isDev'] = $user->isDev;

            // Redirect to a protected page, e.g., the dashboard or home page
            header('Location: /');
            exit;
        } else {
            // Handle invalid login (wrong username or password)
            $this->addNotification('error', 'Ungültiger Benutzername oder Passwort!');
            header('Location: /login');
        }
    }
}