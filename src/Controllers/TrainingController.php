<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;
use ShotLog\DAO\SerienDAO;
use ShotLog\DAO\SessionDAO;
use ShotLog\DAO\ShotDAO;
use ShotLog\Models\Schuss;
use ShotLog\Models\Session;
use ShotLog\Models\Serie;

class TrainingController extends Controller {

    public function enter(): void
    {
        $sessionDAO = new SessionDAO();
        $sessions = $sessionDAO->getSessionByUserAndType(false,  $_SESSION['user_id']);
        $this->render("training",  ['sessions' => $sessions]);
    }

    public function addTraining(): void
    {
        // Parse form data
        $sessionDAO = new SessionDAO();

        // Create and save the session
        $session = new Session(
            null,
            $_POST['location'],
            $_POST['datetime'],
            false,
            date('Y-m-d H:i:s'),
            $_SESSION['user_id'],
            $_POST['desc']
        );
        $sessionDAO->addSession($session);
        $sessionId = $sessionDAO->lastInsertId();

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
        echo json_encode(['success' => true, 'sessionId' => $session->id]);
        header('Location: /training');
    }
}