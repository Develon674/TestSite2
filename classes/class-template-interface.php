<?php

namespace Develon674\TestSite2;

/**
 * A template.
 *
 */
interface Template_Interface {
     /**
     * 
     * @param array $vars A map of context keys to values.
     * @return string The rendered output.
     */
    public function render($vars);
}
