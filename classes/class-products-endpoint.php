<?php

namespace Develon674\TestSite2;

use WP_REST_Server;
use WP_REST_Request;
use WP_Query;

/**
 * Description of class-rest-api-endpoints
 *
 */
class Products_Endpoint {

    protected $query;

    public function __construct(WP_Query $query) {
        $this->query = $query;
    }

    public function register_routes() {
        $version = '1';
        $namespace = "myplugin/v$version";
        $base = '/products/';

        register_rest_route($namespace, $base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => function(WP_REST_Request $request) {
                    return $this->get_entities($request);
                },
                'args' => [
                 'page' =>  [
                     'type' => 'integer',
                     'default' => 1,
                     'minimum' => 1,
                 ],
                 'posts_per_page' => [
                     'type' => 'integer',
                     'default' => 2,
                     'minimum' => 1,
                     'maximum' => 100,
                 ],
            ],
    ],
        ]);
    }

    protected function get_entities(WP_REST_Request $request) {
        $args = [
            'post_type' => 'post',
            'posts_per_page' => $request->get_param('posts_per_page'),
            'paged' => $request->get_param('page'),
            'orderby' => 'date',
            'order' => 'DESC'
        ];
        return $this->query->query($args);
    }

}
