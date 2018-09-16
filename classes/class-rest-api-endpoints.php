<?php

namespace Develon674\TestSite2;
use WP_REST_Posts_Controller;

/**
 * Description of class-rest-api-endpoints
 *
 */
class Rest_Api_Endpoints extends WP_REST_Controller {
    
    protected $terms;
    public function __construct($terms) {
       $this->terms = $terms; 
    }
    
    public function register_routes() {
       $version = '1';
       $namespace = "myplugin/v/$version";
       $base = 'route';
       
       register_rest_route($namespace. '/' . $base, [
        [
          'methods' => WP_Rest_Server::READABLE,
          'callback' => [$this->terms]
        ],
       ]);
    }
    
}
