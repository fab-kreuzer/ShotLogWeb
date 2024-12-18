<?php

namespace ShotLog\Controllers;

use ShotLog\Controller;

class HomeController extends Controller {

    public function enter() {
        $this->render("index");
    }
}