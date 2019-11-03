<?php

require __DIR__.'/vendor/autoload.php';

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use Gettext\Robo\Gettext;

    /**
     * Scan files to find new gettext values.
     */
    public function gettext()
    {
        $this->taskGettext()
            ->scan('templates/', '/\.php$/')
            ->scan('assets/js/modules', '/\.js$/')
            ->scan('assets/js/modules', '/\.js$/')
            ->save('messages', 'locales/en.po', 'locales/en.php', 'assets/js/locales/en.json')
            ->save('messages', 'locales/es.po', 'locales/es.php', 'assets/js/locales/es.json')
            ->save('messages', 'locales/gl.po', 'locales/gl.php', 'assets/js/locales/gl.json')
            ->run();
    }
}
