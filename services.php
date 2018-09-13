<?php

use Psr\Container\ContainerInterface;
use Develon674\TestSite2\Template;
use Develon674\TestSite2\Term_Manager;

return function(string $root_path) {
    
    return [
        'template_factory' => function(ContainerInterface $container) {
            $root_path = $container->get('root_path');
            return function(string $template) use($root_path) {
                return new Template("$root_path/templates/$template.php");
            };
        },
        'term_manager' => function() {
            return new Term_Manager();
        },
        'root_path' => $root_path,
    ];
            
};
    

