<?php

namespace Folk\Formats\Traits;

trait ToolbarTrait
{
    private $icon_up = '<svg fill="#FFFFFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>';
    private $icon_down = '<svg fill="#FFFFFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z"/></svg>';
    private $icon_close = '<svg fill="#FFFFFF" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';

    private function getToolbarButtons(): string
    {
        return '<button title="Move to up" type="button" class="button format-child-up">'.$this->icon_up.'</button><button title="Move to down" type="button" class="button format-child-down">'.$this->icon_down.'</button><button title="Remove" type="button" class="button format-child-remove">'.$this->icon_close.'</button>';
    }
}
