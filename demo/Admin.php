<?php

namespace Demo;

use Folk;

class Admin extends Folk\Admin
{
    public function __construct()
    {
        parent::__construct('http://localhost/folk/demo');

        $this->addEntity(new Entities\Post());
    }
}
