<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SessionDAO;
use ShotLog\DAO\ShotDAO;
use ShotLog\Models\Schuss;
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
        $session->setId($_POST['sessionId']);
        $session->setIsWettkampf($_POST['isWettkampf']);
        $session->setOrt($_POST['ort']);
        $session->setStartAt($_POST['start_at']);
        $session->setDesc($_POST['desc']);

        $sessionDAO = new SessionDAO();
        $sessionDAO->updateSession($session);

        // Handle shots
        if (isset($_POST['shots'])) {
            $shots = json_decode($_POST['shots'], true);
            $shotDAO = new ShotDAO();

            foreach ($shots as $seriesIndex => $seriesShots) {
                foreach ($seriesShots as $shotIndex => $shotData) {
                    if ($shotData['dbid'] != null) {
                        $shot = new Schuss();
                        $shot->setId($shotData['dbid']);
                        $shot->setWert($shotData['value']);
                        $shotDAO->updateShot($shot);
                    }
                }
            }
        }


        if ($session->getIsWettkampf()) {
            header('Location: /competition');
        } else {
            header('Location: /training');
        }
    }

    public function updateTime()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $sessionId = $data['sessionId'];
        $newTime = $data['newTime'];

        $sessionDAO = new SessionDAO();
        $sessionDAO->updateTime($sessionId, $newTime);
        header('Location: /calender');

    }
}