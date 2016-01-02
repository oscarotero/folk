<?php

namespace Demo;

use Folk;

class Admin extends Folk\Admin
{
    public function __construct()
    {
        $this->setUrl('http://localhost:8888');

        parent::__construct();

        $this->addEntity(new Entities\Post());
    }
}
