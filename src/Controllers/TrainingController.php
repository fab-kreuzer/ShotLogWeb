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
        // Initialize the session object
        $session = new Session();
        $session->setDesc($_POST['desc']);
        $session->setOrt($_POST['location']);
        $session->setStartAt($_POST['datetime']);
    
        // Set the flag to "training" by default (isWettkampf = 0)
        $session->setIsWettkampf(0);
    
        // Handle the series and shots
        if (isset($_POST['series'])) {
            $seriesData = $_POST['series'];
            $seriesDAO = new SerienDAO();
    
            foreach ($seriesData as $seriesIndex => $series) {
                $newSeries = new Serie();
                $newSeries->setSessionId($session->getId());
                // Add shots to the series, if any
                $seriesDAO->createSeries($newSeries);
            }
        }
    
        // Save the session to the database
        $sessionDAO = new SessionDAO();
        $sessionDAO->createSession($session);
    
        // Redirect after saving
        header('Location: /trainings');
    }
    
    public function getTrainingData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sessionId = $_GET['sessionId'] ?? null;
            if ($sessionId == null) {
                echo json_encode(['success' => false, 'message' => 'Session ID is required']);
            }


            $sessionDAO = new SessionDAO();
            $serienDAO = new SerienDAO();
            $shotDAO = new ShotDAO();

            // Fetch session data
            $session = $sessionDAO->getSessionById($sessionId);
            if (!$session) {
                echo json_encode(['success' => false, 'message' => 'Session not found']);
                return;
            }

            // Fetch series data
            $series = $serienDAO->getSeriesBySessionId($sessionId);

            foreach ($series as &$serie) {
                $shots = $shotDAO->getShotsBySerieId($serie->getId());
                $serie->setSchusse($shots);
            }
            // Combine data
            $data = [
                'session' => $session,
                'series' => $series,
            ];

            echo json_encode(['success' => true, 'data' => $data]);
        }
    }

    public function deleteShot() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shotId = $_POST['shotId'] ?? null;
            if ($shotId == null) {
                echo json_encode(['success' => false, 'message' => 'Shot ID is required']);
            }

            $shotDAO = new ShotDAO();
            $shotDAO->deleteshot($shotId);
        }

    }
}