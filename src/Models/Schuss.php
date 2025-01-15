<?php

namespace ShotLog\Models;

class Schuss
{
    public int $id;
    public float $wert;
    public int $serienId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getWert(): float
    {
        return $this->wert;
    }

    public function setWert(float $wert): void
    {
        $this->wert = $wert;
    }

    public function getSerienId(): int
    {
        return $this->serienId;
    }

    public function setSerienId(int $serienId): void
    {
        $this->serienId = $serienId;
    }
}
