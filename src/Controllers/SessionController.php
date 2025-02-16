<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SerienDAO;
use ShotLog\DAO\SessionDAO;
use ShotLog\DAO\ShotDAO;
use ShotLog\Models\Schuss;
use ShotLog\Models\Serie;
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

    public function updateCompleteSession(): void
    {
        // Parse form data
        $sessionDAO = new SessionDAO();
        $sessionId = null;
        // Create and save the session
        $session = new Session(
            null,
            $_POST['ort'],
            $_POST['start_at'],
            $_POST['referrer'] == 'competition',
            date('Y-m-d H:i:s'),
            $_SESSION['user_id'],
            $_POST['desc']
        );


        if ($_POST['sessionId'] != null) {
            //Clear current Session
            $sessionDAO->clearCurrentSession($_POST['sessionId']);
            $sessionId = $_POST['sessionId'];
            $session->setId($sessionId);
            $sessionDAO->updateSession($session);
        } else {
            $sessionDAO->addSession($session);
            $sessionId = $sessionDAO->lastInsertId();

        }

        // Iterate over series and shots
        if (isset($_POST['series']) && is_array($_POST['series'])) {
            foreach ($_POST['series'] as $seriesData) {
                $serie = new Serie();
                $serie->setSessionId($sessionId);
                $serie->setIsTest(false);
                //save Serie
                $serienDAO = new SerienDAO();
                $serienDAO->saveSerie($serie);
                $serienId = $serienDAO->lastInsertId();

                if (isset($seriesData['schuss']) && is_array($seriesData['schuss'])) {
                    foreach ($seriesData['schuss'] as $shotValue) {
                        $shot = new Schuss();
                        $shot->setWert($shotValue);
                        $shot->setSerienId($serienId);
                        //save shot in db
                        $shotDAO = new ShotDAO();
                        $shotDAO->saveShot($shot);
                    }
                }
            }
        }
        // Respond with success
        echo json_encode(['success' => true, 'sessionId' => $sessionId]);
        header('Location: /' . $_POST['referrer']);
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