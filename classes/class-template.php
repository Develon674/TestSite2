<?php

namespace Develon674\TestSite2;


class Template implements Template_Interface {
    
    protected $template;
    
    public function __construct($template) {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function render($vars) {
        extract($vars);
        ob_start();
       
        include $this->template;
        
        return ob_get_clean();
    }

}
