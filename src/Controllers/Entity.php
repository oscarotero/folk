<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;
use Psr7Middlewares\Middleware\FormatNegotiator;
use FormManager\Builder as F;

abstract class Entity
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        $format = FormatNegotiator::getFormat($request);
        $entity = $app->getEntity($request->getAttribute('entity'));

        if ($entity !== null && method_exists($this, $format)) {
            return $this->$format($request, $response, $app, $entity);
        }

        return $response->withStatus(404);
    }

    /**
     * Helper to build the entity form.
     * 
     * @param EntityInterface $entity
     * @param Admin           $app
     * @param mixed|null      $id
     * 
     * return \Folk\Formats\Form
     */
    protected static function createForm(EntityInterface $entity, Admin $app, $id = null)
    {
        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data')
            ->add([
                'entity' => F::hidden()->val($entity->getName())->class('field-data-entity'),
                'data' => $entity->getScheme($app['builder']),
            ]);

        if ($id !== null) {
            $form['id'] = F::hidden()->val($id)->class('field-data-id');
        }

        return $form;
    }
}
