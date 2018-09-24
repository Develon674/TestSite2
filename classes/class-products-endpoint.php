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
    protected $name;

    public function __construct(WP_Query $query, string $name = 'post') {
        $this->query = $query;
        $this->name = $name;
    }
    
    protected function filterName() {
        return strtolower($this->name);
    }
    
    public function routePath() {
        $namespace = rtrim($this->namespace, '/');
        return "$namespace/{$this->filterName()}/";
    }

    public function registerRoutes() {

        register_rest_route($this->namespace, "/{$this->filterName()}/", [
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
            'post_type' => $this->filterName(),
            'posts_per_page' => $request->get_param('posts_per_page'),
            'paged' => $request->get_param('page'),
            'orderby' => $request->get_param('orderby'),
            'order' => $request->get_param('order'),
        ];
        $query = $this->modifyEntities($this->query->query($args));
        return $query;
    }

    protected function modifyEntities($entities) {
        foreach ($entities as $entity) {
            $thumbnail = get_the_post_thumbnail_url($entity->ID, 'full');
            if ($thumbnail) {
            $entity->post_thumbnail_url = $thumbnail;
            }
            $entity->post_content = apply_filters('the_content', $entity->post_content);
            $query[] = $entity;
        }
        return $query;
    }

}
