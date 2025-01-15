<?php

namespace ShotLog\Models;

use ShotLog\Models\Serie;

class Session
{
    public $id;
    public $ort;
    public $startAt;
    public $isWettkampf;
    public $insertedAt;
    public $userId;
    public $desc;

    public function __construct($id = null, $ort = null, $startAt = null, $isWettkampf = null, $insertedAt = null, $userId = null, $desc = null)
    {
        $this->id = $id;
        $this->ort = $ort;
        $this->startAt = $startAt;
        $this->isWettkampf = $isWettkampf;
        $this->insertedAt = $insertedAt;
        $this->userId = $userId;
        $this->desc = $desc;
    }
}
