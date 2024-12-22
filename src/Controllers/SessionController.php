<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;
use ShotLog\Models\Session;

class SessionController extends Controller {

    public function deleteSession(): void
    {
        $sesionID = $_POST['sessionId'];
        $origin = $_POST['origin'];
        $sessionDAO = new SessionDAO();
        $sessionDAO->deleteSession($sesionID);
        header(header: 'Location: /' . $origin);
    }

    public function updateSession(): void
    {
        // Assume $session is populated with the updated values
        $session = new Session();
        $session->id = $_POST['sessionId'];
        $session->isWettkampf = $_POST['isWettkampf'];
        $session->ort = $_POST['ort'];
        $session->startAt = $_POST['start_at'];
        $session->desc = $_POST['desc'];

        $sessionDAO = new SessionDAO();
        $sessionDAO->updateSession($session);

        if ($session->isWettkampf) {
            header('Location: /competition');
        } else {
            header('Location: /training');
        }
    }
}