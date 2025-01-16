<?php

namespace ShotLog\Models;

use JsonSerializable;

class Serie implements JsonSerializable
{
    private int $id;
    private int $sessionId;
    private bool $isTest;
    private array $schusse;

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSessionId(): int
    {
        return $this->sessionId;
    }

    public function setSessionId(int $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getIsTest(): bool
    {
        return $this->isTest;
    }

    public function setIsTest(bool $isTest): void
    {
        $this->isTest = $isTest;
    }
    public function getSchusse(): array
    {
        return $this->schusse;
    }

    public function setSchusse(array $schusse): void
    {
        $this->schusse = $schusse;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'sessionId' => $this->sessionId,
            'isTest' => $this->isTest,
            'schusse' => array_map(function ($schuss) {
                return $schuss instanceof JsonSerializable ? $schuss->jsonSerialize() : $schuss;
            }, $this->schusse),
        ];
    }
}
