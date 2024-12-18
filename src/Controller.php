<?php

namespace ShotLog;

class Controller {

    protected function addNotification($level, $message)
    {
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }
        $_SESSION['notifications'][] = ['level' => $level, 'message' => $message];
    }
    protected function getNotifications()
    {
        $notifications = $_SESSION['notifications'] ?? [];
        unset($_SESSION['notifications']);
        return $notifications;
    }

    protected function render($view, $data = []) {
        $data = $data + ['notifications'=> $this->getNotifications()];
        extract($data);
        include "views/$view.php";
    }

}
?>