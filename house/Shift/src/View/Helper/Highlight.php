<?php

namespace Shift\View\Helper;

use Shift\Mvc\Controller\Plugin\Highlight as PluginHighlight;
use Zend\View\Helper\AbstractHelper;

class Highlight extends AbstractHelper
{
    public function __invoke()
    {
        $pluginHighlight = new PluginHighlight();
        $items = $pluginHighlight->getItems();
        if ($items) {
            echo '<script type="text/javascript">' . PHP_EOL;
            echo '$(function() {' . PHP_EOL;
            foreach ($items as $item) {
                echo "$('$item').effect('highlight', {}, 1600);" . PHP_EOL;
            }
            echo '});' . PHP_EOL;
            echo '</script>' . PHP_EOL;
        }
    }
}
