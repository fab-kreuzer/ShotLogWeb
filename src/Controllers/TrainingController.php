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