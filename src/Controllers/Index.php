<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Imagecow\Image;
use Zend\Diactoros\Stream;

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

        if (isset($query['file'])) {
            return $this->file($request, $response, $app);
        }

        return $app['templates']->render('pages/index');
    }

    private function file(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();
        $file = $app->getPath($query['file']);

        if (!is_file($file)) {
            return $response->withStatus(404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        return $response
            ->withBody(new Stream($file, 'r'))
            ->withHeader('Content-Type', $mime);
    }

    private function thumb(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();
        $thumb = $app->getPath($query['thumb']);

        if (!is_file($thumb)) {
            return $response->withStatus(404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $thumb);
        finfo_close($finfo);

        if ($mime === 'image/svg+xml') {
            return $response
                ->withBody(new Stream($thumb, 'r'))
                ->withHeader('Content-Type', $mime);
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
        $pattern = empty($query['pattern']) ? '/*' : $query['pattern'];

        $files = [];
        $baseLength = strlen($thumbs);

        if (is_dir($thumbs)) {
            foreach (glob($thumbs.$pattern, GLOB_NOSORT | GLOB_NOESCAPE | GLOB_BRACE) as $file) {
                if (is_file($file)) {
                    $files[] = substr($file, $baseLength);
                }
            }
        }

        $files = array_reverse($files);
        $files = array_splice($files, $offset, $limit);

        $response->getBody()->write(json_encode($files));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
