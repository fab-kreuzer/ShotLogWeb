<?php

namespace ShotLog\Models;

use JsonSerializable;

class Session implements JsonSerializable
{
    private $id;
    private $ort;
    private $startAt;
    private $isWettkampf;
    private $insertedAt;
    private $userId;
    private $desc;

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

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getOrt()
    {
        return $this->ort;
    }

    public function getStartAt()
    {
        return $this->startAt;
    }

    public function getIsWettkampf()
    {
        return $this->isWettkampf;
    }

    public function getInsertedAt()
    {
        return $this->insertedAt;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getDesc()
    {
        return $this->desc;
    }

    // Setters
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setOrt($ort): void
    {
        $this->ort = $ort;
    }

    public function setStartAt($startAt): void
    {
        $this->startAt = $startAt;
    }

    public function setIsWettkampf($isWettkampf): void
    {
        $this->isWettkampf = $isWettkampf;
    }

    public function setInsertedAt($insertedAt): void
    {
        $this->insertedAt = $insertedAt;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function setDesc($desc): void
    {
        $this->desc = $desc;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ort' => $this->ort,
            'startAt' => $this->startAt,
            'isWettkampf' => $this->isWettkampf,
            'insertedAt' => $this->insertedAt,
            'userId' => $this->userId,
            'desc' => $this->desc,
        ];
    }
}
