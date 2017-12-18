<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Middlewares\Utils\Factory;
use FormManager\Builder as F;

abstract class Entity
{
    protected $app;
    protected $formats = [
        'text/html' => 'html',
        'application/json' => 'json',
    ];

    public function __construct(Admin $app)
    {
        $this->app = $app;
    }

    public function __invoke(Request $request)
    {
        $format = $request->getHeaderLine('Accept');
        $format = $this->formats[$format] ?? 'html';
        $entityName = $request->getAttribute('entity');

        if ($this->app->hasEntity($entityName) && method_exists($this, $format)) {
            return $this->$format($request, $entityName);
        }

        return Factory::createResponse(404);
    }

    /**
     * Helper to build the entity form.
     * 
     * @param string     $entityName
     * @param mixed|null $id
     * 
     * return \Folk\Formats\Form
     */
    protected function createForm(string $entityName, $id = null)
    {
        $entity = $this->app->getEntity($entityName);

        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data')
            ->add([
                'entity' => F::hidden()->val($entityName)->class('field-data-entity'),
                'data' => $entity->getScheme($this->app->get('builder')),
            ]);

        if ($id !== null) {
            $form['id'] = F::hidden()->val($id)->class('field-data-id');
        }

        return $form;
    }
}
