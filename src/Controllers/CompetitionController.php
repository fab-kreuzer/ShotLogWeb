<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;
use ShotLog\Models\Session;

class CompetitionController extends Controller {

    public function enter() {
        $sessionDAO = new SessionDAO();
        $sessions = $sessionDAO->getSessionByUserAndType(true, $_SESSION['user_id']);
        $this->render("competition", ["sessions"=> $sessions]);
    }

    public function addCompetition() {    
        $session = new Session();
        $session->desc = $_POST['desc'];
        $session->ort = $_POST['location'];
        $session->startAt = $_POST['datetime'];
        $session->isWettkampf = true; //trainign
        $session->insertedAt = date('Y-m-d H:i:s');
        $session->userId = $_SESSION['user_id'];
    
        $sessionDAO = new SessionDAO();
        $sessionDAO->addSession($session);
        header('Location: /competition');
    }

}