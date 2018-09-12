<?php

namespace Develon674\TestSite2;

use WP_Term;
use WP_Term_Query;

class MyPlugin {

    protected $root_path;
    
    public function __construct($root_path, $altTemplatePath) {
        $this->root_path = $root_path;
        $this->altTemplatePath = $altTemplatePath;
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
        echo $this->get_output('terms.php', ['terms' => $terms]);
    }
    
    protected function get_output($template, $vars) {
        extract($vars);
        ob_start();
        if (file_exists($template = $this->altTemplatePath.'/' . $template)) {
            include apply_filters('template_path', $template);
           
        }
        else {
            include $this->root_path.'/templates/'.$template;
        }
        
        return ob_get_clean();
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
        $indexTerms = new Term_Manager();
        $terms = $this->getTerms();
        $index = $indexTerms->indexTermsById($terms);
        $tree = $indexTerms->getTermTree($index);
      
        return $this->printTerms($tree);
    }

}
