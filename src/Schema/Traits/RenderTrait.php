<?php

namespace Folk\Schema\Traits;

trait RenderTrait
{
    private function renderFile(string $path, string $name): string
    {
        ob_start();
        require "{$path}/template.{$name}.php";
        return ob_get_clean();
    }
}
