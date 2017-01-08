<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Middlewares\Utils\Factory;
use FormManager\Builder as F;

abstract class Entity
{
    protected $formats = [
        'text/html' => 'html',
        'application/json' => 'json',
    ];

    public function __invoke(Request $request, Admin $app)
    {
        $format = $request->getHeaderLine('Accept');
        $format = $this->formats[$format] ?? 'html';
        $entityName = $request->getAttribute('entity');

        if ($app->hasEntity($entityName) && method_exists($this, $format)) {
            return $this->$format($request, $app, $entityName);
        }

        return Factory::createResponse(404);
    }

    /**
     * Helper to build the entity form.
     * 
     * @param Admin      $app
     * @param string     $entityName
     * @param mixed|null $id
     * 
     * return \Folk\Formats\Form
     */
    protected static function createForm(Admin $app, string $entityName, $id = null)
    {
        $entity = $app->getEntity($entityName);

        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data')
            ->add([
                'entity' => F::hidden()->val($entityName)->class('field-data-entity'),
                'data' => $entity->getScheme($app->get('builder')),
            ]);

        if ($id !== null) {
            $form['id'] = F::hidden()->val($id)->class('field-data-id');
        }

        return $form;
    }
}
