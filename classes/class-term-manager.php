<?php

namespace Develon674\TestSite2;

/**
 * This will create a hierarchy of terms from a list.
 *
 */
class Term_Manager {

    /**
     * 
     * @param WP_Term[] $terms
     * @return WP_Term[] List of terms by ID.
     */
    public function indexTermsById($terms) {
        $index = [];
        foreach ($terms as $term) {
            $index[$term->term_id] = $term;
        }
        return $index;
    }

    /**
     * 
     * @param WP_Term[] $terms 
     * 
     */
    public function getTermTree(array $terms, $parentId = 0) {
        $branch = [];

        foreach ($terms as $term) {
            /* @var $term WP_Term */
            if ($term->parent == $parentId) {
                $children = $this->getTermTree($terms, $term->term_id);
                if ($children) {
                    $term->children = $children;
                }
                $branch[$term->term_id] = $term;
                unset($terms[$term->term_id]);
            }
        }
        return $branch;
    }

}
