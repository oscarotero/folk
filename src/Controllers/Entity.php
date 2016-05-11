<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Psr7Middlewares\Middleware\FormatNegotiator;
use FormManager\Builder as F;

abstract class Entity
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        $format = FormatNegotiator::getFormat($request);
        $entityName = $request->getAttribute('entity');

        if ($app->hasEntity($entityName) && method_exists($this, $format)) {
            return $this->$format($request, $response, $app, $entityName);
        }

        return $response->withStatus(404);
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
    protected static function createForm(Admin $app, $entityName, $id = null)
    {
        $entity = $app->getEntity($entityName);

        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data')
            ->add([
                'entity' => F::hidden()->val($entityName)->class('field-data-entity'),
                'data' => $entity->getScheme($app['builder']),
            ]);

        if ($id !== null) {
            $form['id'] = F::hidden()->val($id)->class('field-data-id');
        }

        return $form;
    }
}
