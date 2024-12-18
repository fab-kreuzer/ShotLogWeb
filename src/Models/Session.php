<?php

namespace ShotLog\Models;

class Session
{
    public $id;
    public $ort;
    public $startAt;
    public $isWettkampf;
    public $insertedAt;
    public $userId;

    public function __construct($id, $ort, $startAt, $isWettkampf, $insertedAt, $userId)
    {
        $this->id = $id;
        $this->ort = $ort;
        $this->startAt = $startAt;
        $this->isWettkampf = $isWettkampf;
        $this->insertedAt = $insertedAt;
        $this->userId = $userId;
    }
}
