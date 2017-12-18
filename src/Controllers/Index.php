<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Imagecow\Image;
use Middlewares\Utils\Factory;

class Index
{
    private $app;

    public function __construct(Admin $app)
    {
        $this->app = $app;
    }

    public function __invoke(Request $request)
    {
        $query = $request->getQueryParams();

        if (isset($query['thumb'])) {
            return $this->thumb($request);
        }

        if (isset($query['thumbs'])) {
            return $this->thumbs($request);
        }

        if (isset($query['file'])) {
            return $this->file($request);
        }

        return $this->app->get('templates')->render('pages/index');
    }

    private function file(Request $request)
    {
        $query = $request->getQueryParams();
        $file = $this->app->getPath($query['file']);

        if (!is_file($file)) {
            return Factory::createResponse(404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        return Factory::createResponse()
            ->withBody(Factory::createStream(fopen($file, 'r')))
            ->withHeader('Content-Type', $mime);
    }

    private function thumb(Request $request)
    {
        $query = $request->getQueryParams();
        $thumb = $this->app->getPath($query['thumb']);

        if (!is_file($thumb)) {
            return Factory::createResponse(404);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $thumb);
        finfo_close($finfo);

        if ($mime === 'image/svg+xml') {
            return Factory::createResponse()
                ->withBody(Factory::createStream(fopen($thumb, 'r')))
                ->withHeader('Content-Type', $mime);
        }

        $image = Image::fromFile($thumb);
        $image->resize(0, 200);

        echo $image->getString();

        return Factory::createResponse()
            ->withHeader('Content-Type', $image->getMimeType());
    }

    private function thumbs(Request $request)
    {
        $query = $request->getQueryParams();
        $thumbs = $this->app->getPath($query['thumbs']);
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

        echo json_encode($files);

        return Factory::createResponse()
            ->withHeader('Content-Type', 'application/json');
    }
}
