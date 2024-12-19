<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;
use ShotLog\Utils\CalenderUtils;

class CalenderController extends Controller {

    public function enter() {
        $this->render("calender");
    }

    public function getUserEvents() {
        $sessionDAO = new SessionDAO();
        $events = $sessionDAO->getSessionByUser($_SESSION['user_id']);
        echo CalenderUtils::toCalenderEntries($events);
    }
}