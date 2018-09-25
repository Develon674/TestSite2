<?php

use Psr\Container\ContainerInterface;
use Develon674\TestSite2\Template;
use Develon674\TestSite2\Term_Manager;
use Develon674\TestSite2\Products_Endpoint;
use Develon674\TestSite2\Post_Type_Manager;

return function(string $root_path, string $base_url) {

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
            $post_type = $container->get('post_type');
            $query = $queryFactory();
            return new Products_Endpoint($query, $post_type);
        },
        'query_factory' => function() {
            return function() {
                        return new WP_Query();
                    };
        },
        'post_type_manager' => function(ContainerInterface $container) {
            $post_type = $container->get('post_type');
            $text_domain = $container->get('text_domain');
            return new Post_Type_Manager($text_domain, $post_type);
        },
        'taxonomy_type_manager' => function(ContainerInterface $container) {
            $post_type = $container->get('post_type');
            $text_domain = $container->get('text_domain');
            return function(string $taxonomy) use ($post_type, $text_domain) {
                        return new Taxonomy_Type_Manager($text_domain, $post_type, $taxonomy);
                    };
        },
        'root_path' => $root_path,
        'base_url' => $base_url,
        'version' => '0.1',
        'post_type' => 'product',
        'shortcode_tag_name' => 'products',
        'taxonomies' => ['questions', 'answers'],
        'text_domain' => 'myplugin',
    ];
};


