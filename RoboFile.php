<?php

require __DIR__.'/vendor/autoload.php';

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use Gettext\Robo\GettextScanner;

    /**
     * Scan files to find new gettext values.
     */
    public function gettext()
    {
        $this->taskGettextScanner()
            ->extract('templates/')
            ->extract('assets/js/modules', '/.*\.js/')
            ->generate('locales/en.po', 'assets/js/locales/en.json')
            ->generate('locales/es.po', 'assets/js/locales/es.json')
            ->generate('locales/gl.po', 'assets/js/locales/gl.json')
            ->run();
    }
}
