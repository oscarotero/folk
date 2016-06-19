<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Imagecow\Image;

class Index
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();

        if (isset($query['thumb'])) {
            return $this->thumb($request, $response, $app);
        }

        if (isset($query['thumbs'])) {
            return $this->thumbs($request, $response, $app);
        }

        return $app['templates']->render('pages/index');
    }

    private function thumb(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();
        $thumb = $app->getPath($query['thumb']);

        if (!is_file($thumb)) {
            return $response->withStatus(404);
        }

        $image = Image::fromFile($thumb);
        $image->resize(0, 200);

        $response->getBody()->write($image->getString());

        return $response->withHeader('Content-Type', $image->getMimeType());
    }

    private function thumbs(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();
        $thumbs = $app->getPath($query['thumbs']);
        $limit = empty($query['limit']) ? 100 : (int) $query['limit'];
        $offset = empty($query['offset']) ? 0 : (int) $query['offset'];

        $files = [];

        if (is_dir($thumbs)) {
            $dir = opendir($thumbs);

            while (($file = readdir($dir)) !== false) {
                $file = '/'.$file;

                if (is_file($thumbs.$file)) {
                    $files[] = $file;
                }
            }

            closedir($dir);
        }

        $files = array_reverse($files);
        $files = array_splice($files, $offset, $limit);

        $response->getBody()->write(json_encode($files));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
