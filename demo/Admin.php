<?php

namespace Demo;

use Folk;

class Admin extends Folk\Admin
{
    public function __construct($url)
    {
        parent::__construct($url);

        $this->setEntities([
            Entities\Articles::class,
            Entities\Items::class,
            Entities\Tags::class,
        ]);
    }
}
