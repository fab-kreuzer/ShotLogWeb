<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;

class CompetitionController extends Controller {

    public function enter() {
        $sessionDAO = new SessionDAO();
        $sessions = $sessionDAO->getSessionByUserAndType(true, $_SESSION['user_id']);
        $this->render("competition", ["sessions"=> $sessions]);
    }
}