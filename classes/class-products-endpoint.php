<?php

namespace Develon674\TestSite2;

use WP_REST_Server;
use WP_REST_Request;
use WP_Query;

/**
 * Creates endpoint for post type
 *
 */
class Products_Endpoint {

    protected $query;
    protected $namespace = "myplugin/v1";
    protected $base = '/products/';

    public function __construct(WP_Query $query) {
        $this->query = $query;
    }

    public function routePath() {
        $namespace = rtrim($this->namespace, '/');
        $base = ltrim($this->base, '/');
        return "$namespace/$base";
    }

    public function registerRoutes() {

        register_rest_route($this->namespace, $this->base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => function(WP_REST_Request $request) {
                    return $this->getEntities($request);
                },
                'args' => [
                    'page' => [
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
                    'order' => [
                        'type' => 'string',
                        'default' => 'ASC',
                        'enum' => [
                            'ASC',
                            'DESC',
                        ],
                        'validate_callback' => function($param) {
                            return (is_numeric($param) ? false : true);
                        },
                    ],
                    'orderby' => [
                        'type' => 'string',
                        'default' => 'date',
                        'validate_callback' => function($param) {
                            return (is_numeric($param) ? false : true);
                        },
                    ],
                ],
            ],
        ]);
    }

    protected function getEntities(WP_REST_Request $request) {
        $args = [
            'post_type' => 'post',
            'posts_per_page' => $request->get_param('posts_per_page'),
            'paged' => $request->get_param('page'),
            'orderby' => $request->get_param('orderby'),
            'order' => $request->get_param('order'),
        ];
        return $this->query->query($args);
    }

}
