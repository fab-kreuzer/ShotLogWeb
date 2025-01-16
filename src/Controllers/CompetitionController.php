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
        $session->setDesc($_POST['desc']);
        $session->setOrt($_POST['location']);
        $session->setStartAt($_POST['datetime']);
        $session->setIsWettkampf(true);
        $session->setInsertedAt(date('Y-m-d H:i:s'));
        $session->setUserId($_SESSION['user_id']);
    
        $sessionDAO = new SessionDAO();
        $sessionDAO->addSession($session);
        header('Location: /competition');
    }

}