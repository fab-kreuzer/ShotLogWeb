<?php

namespace ShotLog\Models;

class User
{
    public $id;
    public $username;
    public $password;
    public $vorname;
    public $nachname;
    public $isDev;
    public $isAdmin;
    public $createdAt;

    /**
     * Constructor to initialize the User class.
     *
     * @param int|null $id
     * @param string|null $username
     * @param string|null $password
     * @param string|null $vorname
     * @param string|null $nachname
     * @param bool|null $isDev
     * @param bool|null $isAdmin
     * @param string|null $createdAt
     */
    public function __construct(
        ?int $id = null,
        ?string $username = null,
        ?string $password = null,
        ?string $vorname = null,
        ?string $nachname = null,
        ?bool $isDev = null,
        ?bool $isAdmin = null,
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->isDev = $isDev;
        $this->isAdmin = $isAdmin;
        $this->createdAt = $createdAt;
    }
}
