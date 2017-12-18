<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Zend\Diactoros\Response\RedirectResponse;
use Middlewares\Utils\Factory;

class CreateEntityField extends Entity
{
    public function json(Request $request, string $entityName)
    {
        $field = $request->getAttribute('field');
        $data = $request->getParsedBody();

        $form = $this->createForm($entityName);
        $form['data'][$field]->val($data['value']);

        if ($form->validate()) {
            $entity = $this->app->getEntity($entityName);

            $id = $entity->create($form['data']->val());
            $data = $entity->read($id);
            
            return json_encode([
                'id' => $id,
                'label' => $entity->getLabel($id, $data),
            ]);
        }

        return Factory::createResponse(400);
    }
}
