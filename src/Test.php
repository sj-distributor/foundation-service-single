<?php
namespace Wiltechsteam\FoundationServiceSingle;

class Test {

    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}