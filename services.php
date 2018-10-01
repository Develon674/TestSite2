<?php

use Psr\Container\ContainerInterface;
use Dhii\Data\Container\CompositeContainer;
use Develon674\TestSite2\Template;
use Develon674\TestSite2\Term_Manager;
use Develon674\TestSite2\Products_Endpoint;
use Develon674\TestSite2\Admin_Fields;

return function(string $root_path, string $base_url) {

    return [
        'template_factory' => function(ContainerInterface $c) {
            $root_path = $c->get('root_path');
            return function(string $template) use($root_path) {
                return new Template("$root_path/templates/$template.php");
            };
        },
        'term_manager' => function() {
            return new Term_Manager();
        },
        'products_endpoint' => function(ContainerInterface $c) {
            $queryFactory = $c->get('query_factory');
            $query = $queryFactory();
            return new Products_Endpoint($query);
        },
        'query_factory' => function() {
            return function() {
                return new WP_Query();
            };
        },
        'term_query_factory' => function() {
            return function() {
                return new WP_Term_Query();
            };
        },
        'options' => function(ContainerInterface $c) {
            $text_domain = $c->get('text_domain');
            return new WP_Options_Container(uniqid($text_domain, true));
        },
        'composite' => function(ContainerInterface $c) {
            $options = $c->get('options');
            return new CompositeContainer([$options, $c]);
        },
        'default_field_values' => [],
        'admin_fields' => function(ContainerInterface $c) {
            $text_domain = $c->get('text_domain');
            $fields = $c->get('default_field_values');
            return new Admin_Fields($text_domain, $fields);
        },
        'root_path' => $root_path,
        'base_url' => $base_url,
        'version' => '0.1',
        'shortcode_tag_name' => 'products',
        'root_term_id' => 2,
        'text_domain' => 'myplugin',
    ];
};


