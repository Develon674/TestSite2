<?php

use Psr\Container\ContainerInterface;
use Develon674\TestSite2\Template;
use Develon674\TestSite2\Term_Manager;
use Develon674\TestSite2\Products_Endpoint;

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
        'products_endpoint' => function(ContainerInterface $container) {
            $queryFactory = $container->get('query_factory');
            $query = $queryFactory();
            return new Products_Endpoint($query);
        },
        'query_factory' => function() {
            return function() {
                        return new WP_Query();
                    };
        },
        'root_path' => $root_path,
    ];
};


