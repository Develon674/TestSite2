<?php

namespace Develon674\TestSite2;

use Psr\Container\ContainerInterface;
use WP_Term;
use WP_Term_Query;

class MyPlugin {

    protected $container;
    protected $templateCache = [];

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    protected function getConfig($key) {
        return $this->container->get($key);
    }

    protected function getTemplate($key) {
        if (!isset($this->templateCache[$key])) {
            $templateFactory = $this->getConfig('template_factory');
            $template = $templateFactory($key);
            $this->templateCache[$key] = $template;
        }
        return $this->templateCache[$key];
    }

    public function run() {

        $productsEndpoint = $this->getConfig('products_endpoint');

        add_action('product_finder_body', function() {
            echo $this->printOutput();
        });
        add_action('rest_api_init', function() use ($productsEndpoint) {
            $productsEndpoint->registerRoutes();
        });
        add_action('init', function() {
            $this->registerAssets();
            add_shortcode($this->getConfig('shortcode_tag_name'), function($params, $content = '') {
                if (empty($params)) {
                    $params = [];
                }
                return $this->getShortcodeOutput($params, $content);
            });
        });
        add_action('wp_enqueue_scripts', function() use($productsEndpoint) {
            $this->enqueueAssets($productsEndpoint);
        });
    }

    protected function registerAssets() {
        wp_register_script('product-page-js', $this->getUrl('assets/js/products.js'), ['backbone', 'underscore'], $this->getConfig('version'));
    }

    protected function enqueueAssets($endpoint) {
        wp_enqueue_script('product-page-js');
        wp_localize_script('product-page-js', 'myplugin_products', [
            'url' => get_rest_url(null, $endpoint->routePath()),
            'terms' => $this->getOutput(),
                ]
        );
    }

    protected function getUrl($path = '') {
        $baseUrl = rtrim($this->getConfig('base_url'), '/');
        $path = ltrim($path, '/');

        return "$baseUrl/$path";
    }

    /**
     * @param WP_Term[] $terms A list of categories.
     * @return array Returns list of categories in array.
     */
    protected function printTerms($terms) {
        $template = $this->getTemplate('terms');
        echo $template->render(['terms' => $terms]);
    }

    protected function getTerms() {
        $catQuery = new WP_Term_Query([
            'taxonomy' => 'category',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        ]);

        $terms = $catQuery->get_terms();

        return $terms;
    }

    protected function getOutput() {
        $indexTerms = $this->getConfig('term_manager');
        $terms = $this->getTerms();
        $index = $indexTerms->indexTermsById($terms);
        $tree = $indexTerms->getTermTree($index);
        return $tree;
    }

    protected function printOutput() {
        $output = $this->getOutput();
        return $this->printTerms($output);
    }

    /**
     *
     * @param array $params
     * @param string $content
     * @return string
     */
    protected function getShortcodeOutput(array $params, $content = '') {
        $template = $this->getTemplate('shortcode');
        return $template->render($params);
    }

}
