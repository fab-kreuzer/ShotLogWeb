<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;

class LogoutController extends Controller {

    public function enter() {
        session_destroy();
        header('Location: /login');
        exit;
    }
}