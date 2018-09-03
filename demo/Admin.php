<?php

namespace Demo;

use Folk;

class Admin extends Folk\Admin
{
    public function __construct($path, $url)
    {
        parent::__construct($path, $url);

        $this->setEntities([
            // Entities\Articles::class,
            // Entities\Items::class,
            'tags' => new Entities\Tags('Etiquetas'),
        ]);

        // $this->addEntity(new Entities\Config('config', $this), 'config');
    }
}
