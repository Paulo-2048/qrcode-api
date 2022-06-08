<?php

class ApiController {
    private $endpoint;
    private $method;

    function __construct($endpoint, $method)
    {
        $this->$endpoint = $this->setEndpoint($endpoint);
        $this->$method = $this->setMethod($method);
    }


    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint)
    {

        if (in_array($endpoint, array('login', 'setuser', 'getusers', 'updateuser', 'deleteuser', 'myqrcodes', 'insertqrcode', 'updateqrcode', 'deleteqrcode', 'redirect'))) {
            $this->endpoint = $endpoint;
        } else {
            
        }
        
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        if ($method == 'GET' || $method == 'POST') {
            $this->method = $method;
        } else {
            
        }
        
        return $this;
    }
}
