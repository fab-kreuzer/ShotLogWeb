<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;
use ShotLog\Models\Session;

class TrainingController extends Controller {

    public function enter() {
        $sessionDAO = new SessionDAO();
        $sessions = $sessionDAO->getSessionByUserAndType(false,  $_SESSION['user_id']);
        $this->render("training",  ['sessions' => $sessions]);
    }

    public function addTraining() {    
        $session = new Session();
        $session->desc = $_POST['desc'];
        $session->ort = $_POST['location'];
        $session->startAt = $_POST['datetime'];
        $session->isWettkampf = false; //trainign
        $session->insertedAt = date('Y-m-d H:i:s');
        $session->userId = $_SESSION['user_id'];
    
        $sessionDAO = new SessionDAO();
        $sessionDAO->addSession($session);
        header('Location: /training');
    }
}