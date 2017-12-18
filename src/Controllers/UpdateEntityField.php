<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Zend\Diactoros\Response\RedirectResponse;
use Middlewares\Utils\Factory;

class UpdateEntityField extends Entity
{
    public function json(Request $request, string $entityName)
    {
        $id = $request->getAttribute('id');
        $field = $request->getAttribute('field');
        $data = $request->getParsedBody();

        $form = $this->createForm($entityName, $id);
        $form['data']->val($this->app->getEntity($entityName)->read($id));
        $form['data'][$field]->val($data['value']);

        if ($form->validate()) {
            $this->app->getEntity($entityName)->update($id, $form['data']->val());
            
            return json_encode([
                'value' => $form['data'][$field]->val(),
                'htmlValue' => $form['data'][$field]->valToHtml(),
            ]);
        }

        return Factory::createResponse(400);
    }
}
