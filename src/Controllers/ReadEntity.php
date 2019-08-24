<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;

class ReadEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $id = $request->getAttribute('id');

        $form = $this->createForm($entityName, $id);
        $form['data']->val($this->app->getEntity($entityName)->read($id));

        //Render template
        return $this->app->get('templates')->render('pages/read', [
            'entityName' => $entityName,
            'form' => $form,
            'id' => $id,
        ]);
    }

    public function json(Request $request, string $entityName)
    {
        $id = $request->getAttribute('id');

        return json_encode($this->app->getEntity($entityName)->read($id));
    }
}
