<?php

namespace Develon674\TestSite2;

use Psr\Container\ContainerInterface;
use WP_Term;
use WP_Term_Query;

class MyPlugin {

    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function run() {
        add_action('product_finder_body', function() {
            echo $this->getOutput();
        });
    }

    /**
     * @param WP_Term[] $terms A list of categories.
     * @return array Returns list of categories in array.
     */
    protected function printTerms($terms) {
        $templateFactory = $this->container->get('template_factory');
        $template = $templateFactory('terms');
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
        $indexTerms = $this->container->get('term_manager');
        $terms = $this->getTerms();
        $index = $indexTerms->indexTermsById($terms);
        $tree = $indexTerms->getTermTree($index);
      
        return $this->printTerms($tree);
    }

}
