<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;

class TrainingController extends Controller {

    public function enter() {
        $sessionDAO = new SessionDAO();
        $sessions = $sessionDAO->getSessionByUserAndType(false,  $_SESSION['user_id']);
        $this->render("training",  ['sessions' => $sessions]);
    }
}