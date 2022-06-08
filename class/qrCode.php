<?php

include '../vendor/autoload.php';

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QrCode {
    private $title;
    private $description;
    private $link;
    private $ref;
    private $userToken;
    private $render;

    function __construct($title, $link, $userToken, $ref=false, $description=null)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setLink($link);
        $this->setUserToken($userToken);
        $this->setRef($ref);
        $this->setRender();
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    private function setRef($ref) {
        if (!$ref) {
            $this->ref = uniqid();
        } else {
            $this->ref = $ref;
        }

    }

    public function getRef() {
        return $this->ref;
    }

    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;

        return $this;
    }

    public function getUserToken()
    {
        return $this->userToken;
    }

    public function setRender(){
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $this->render = $writer->writeString($this->link);
    }

    public function getRender(){
        return $this->render;
    }
}