<?php 
namespace Develon674\TestSite2;

use WP_Term;
use WP_Term_Query;

class MyPlugin {
    public function __construct() {
        
    }
    
    public function run() {
        add_action('product_finder_body', function() {
            echo $this->getOutput();
        });
    }
    
    /**
     * @param WP_Term[] $categories A list of categories.
     * @return array Returns list of categories in array.
    */
    protected function printCategories($categories) {
        foreach ($categories as $category) {
            echo '<p>'.$category->name.'</p>';
        }
    }
    
    protected function getCategories() {
        $catQuery = new WP_Term_Query([
            'taxonomy' => 'category', 
                'hide_empty' => true,
                     ]);

        $terms = $catQuery->get_terms();
        
        return $terms;
        
    }
    
    protected function getOutput() {
        $categories = $this->getCategories();
        return $this->printCategories($categories);
    }               
                   
}
