<?php

namespace Binotify\Model;

class User{
    
    private int $user_id;
    private string $email;
    private string $password;
    private string $username;
    private bool $isAdmin;

    function __construct(
        int $user_id,
        string $email,
        string $password,
        string $username,
        bool $isAdmin,
    ){
        $this->user_id = $user_id;
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->isAdmin = $isAdmin;
    }

    public function getUserId(): int{
        return $this->user_id;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function getIsAdmin(): bool{
        return $this->isAdmin;
    }

}