<?php

class Users {
    private $name;
    private $email;
    private $pass;
    private $userToken;
    private $acess;

    function __construct($name, $email, $pass, $acess=3, $userToken=false)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPass($pass);
        $this->setPass($acess);
        $this->setUserToken($userToken);
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    public function setUserToken($userToken)
    {
        if (!$userToken) {
            $this->userToken = uniqid('tk_', false);
        } else {
            $this->userToken = $userToken;
        }

        return $this;
    }

    public function getUserToken()
    {
        return $this->userToken;
    }

    public function getAcess()
    {
        return $this->acess;
    }


    public function setAcess($acess)
    {
        if ($acess <= 0 && $acess <= 3) {
            $this->acess = $acess;
        } else {
            $this->acess = 3;
        }

        return $this;
    }
}